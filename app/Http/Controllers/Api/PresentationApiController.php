<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\Presentation\PresentationResource;
use App\Jobs\JobEditNotification;
use App\Jobs\JobUploadSuccessNotification;
use App\Models\IndividualPermission;
use App\Models\ManualPresentation;
use App\Models\Video;
use App\Models\tokenHandler;
use App\Services\Api\CatchAll;
use App\Services\Course\CourseStoreOrUpdate;
use App\Services\PermissionHandler\PermissionHandler;
use App\Services\Presenter\PresenterStore;
use App\Services\Stream\StreamsStore;
use App\Services\Tag\TagsStore;
use App\Services\Video\VideoStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class PresentationApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt:api')->except(['permission']);
    }

    /**
     * List videos (paginated).
     */
    public function index(): JsonResponse
    {
        $videos = Video::query()->latest('id')->paginate(25);

        return response()->json([
            'data' => PresentationResource::collection($videos),
            'meta' => [
                'current_page' => $videos->currentPage(),
                'last_page'    => $videos->lastPage(),
                'per_page'     => $videos->perPage(),
                'total'        => $videos->total(),
            ],
        ]);
    }

    /**
     * Store or update a presentation (webhook-like entrypoint).
     */
    public function store(PresentationRequest $request): JsonResponse
    {
        $payload = auth()->payload();

        if ($payload->get('per') !== 'store') {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Error / non-success path: just log and return.
        if ($request->type !== 'success') {
            try {
                (new CatchAll($request))->logRequest();
            } catch (\Throwable $e) {
                report($e);
                return response()->json([
                    'error'   => 'Something went wrong while logging',
                    'message' => $e->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }
            return response()->json('Logged', Response::HTTP_OK);
        }

        // Success path: create/update inside a transaction.
        try {
            $video = DB::transaction(function () use ($request) {
                $video = (new VideoStore($request))->presentation();
                $this->applySharedWrites($request, $video);

                //Return a fresh model instance
                return $video->fresh();
            });
        } catch (\Throwable $e) {
            report($e);

            $op = 'creating';
            if ($id = $request->input('package.pkg_id')) {
                $op = Video::find($id) ? 'updating' : 'creating';
            }

            return response()->json([
                'error'   => "Something went wrong while {$op}",
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        // Post-commit: handle manual upload / edit notifications, visibility, cleanup.
        $this->handleManualPresentationSideEffects($request, $video);

        return response()->json([
            'message'  => 'Presentation saved.',
            //'video_id' => $video->id, //Debugging
        ], Response::HTTP_CREATED);
    }

    /**
     * Show a single presentation or 404.
     */
    public function show(string $id): JsonResponse
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new PresentationResource($video));
    }

    /**
     * Update placeholder (explicit 501 until implemented).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json(['error' => 'Not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Destroy placeholder (explicit 501 until implemented).
     */
    public function destroy($id): JsonResponse
    {
        return response()->json(['error' => 'Not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     *  perm endpoint – invalidates auth and returns granted=true.
     *
     */
    public function perm($id): JsonResponse
    {
        try {
            auth()->invalidate();
        } catch (\Throwable $e) {
            report($e);
            // continue; method historically returns granted regardless
        }

        return response()->json(['permission' => true], Response::HTTP_OK);
    }

    /**
     * Stream permission gate using short-lived tokens.
     *
     * Request: { token: string }
     * Uses JWT in the token itself (per original behavior).
     */
    public function permission(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $payload = auth()->payload();
        $videoId = (string) $payload->get('id');

        $video = Video::find($videoId);
        if (!$video) {
            return response()->json(['permission' => 'denied'], Response::HTTP_NOT_FOUND);
        }

        $sources = json_decode((string) $video->sources, true) ?: [];
        $allowCount = is_array($sources) ? count($sources) : 0;

        // Parse/validate the provided JWT (embedded in 'token').
        try {
            JWTAuth::parseToken($request->input('token'))->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['permission' => 'denied'], Response::HTTP_OK);
        } catch (TokenInvalidException $e) {
            return response()->json(['permission' => 'invalid'], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json(['permission' => 'denied'], Response::HTTP_OK);
        }

        // Allow once per stream across the whole presentation.
        try {
            DB::transaction(function () use ($request, $videoId, $allowCount) {
                /** @var tokenHandler|null $record */
                $record = tokenHandler::query()
                    ->where('video_id', $videoId)
                    ->where('token', $request->input('token'))
                    ->lockForUpdate()
                    ->first();

                if ($record) {
                    // Token exists: decrement or invalidate if exhausted.
                    if ($record->allow < 1) {
                        // invalidate JWT and delete record
                        try {
                            JWTAuth::parseToken($request->input('token'))->invalidate();
                        } catch (\Throwable $e) {
                            report($e);
                        }
                        $record->delete();

                        throw new \RuntimeException('exhausted'); // bubble to uniform response
                    }

                    $record->decrement('allow');
                } else {
                    // Replace any old token for this video with the new one (single active token rule).
                    tokenHandler::query()->where('video_id', $videoId)->delete();

                    tokenHandler::create([
                        'video_id' => $videoId,
                        'token'    => $request->input('token'),
                        'allow'    => max(0, $allowCount - 1),
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            // exhausted
            return response()->json(['permission' => 'denied'], Response::HTTP_OK);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['permission' => 'denied'], Response::HTTP_OK);
        }

        return response()->json(['permission' => 'granted'], Response::HTTP_OK);
    }

    /**
     * Public permission/entitlement view.
     */
    public function permissions($id): JsonResponse
    {
        $video = Video::where('presentation_id', $id)->first();
        if (!$video) {
            return response()->json(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $entitlements = $video->entitlement ? explode(';', (string) $video->entitlement) : [];

        return response()->json([
            'public'       => $video->permission,
            'entitlements' => array_values(array_filter($entitlements, static fn ($e) => $e !== '')),
        ], Response::HTTP_OK);
    }

    /**
     * Apply the relations to a presentation (permissions, presenter, course, tags, streams).
     */
    private function applySharedWrites(PresentationRequest $request, Video $video): void
    {
        (new PermissionHandler($request, $video))->setPermission();
        (new PresenterStore())->presenter($request, $video);
        (new CourseStoreOrUpdate($request, $video))->store();
        (new TagsStore())->handle($request, $video);
        (new StreamsStore($request, $video))->streams();
    }

    /**
     * Manual/edited presentation side effects: origin, visibility, emails, cleanup.
     * Queues emails after commit to avoid races.
     */
    private function handleManualPresentationSideEffects(Request $request, Video $video): void
    {
        /** @var ManualPresentation|null $manual */
        $manual = ManualPresentation::where('jobid', $request->jobid)->first();
        if (!$manual) {
            return;
        }

        if (!in_array($manual->type, ['manual', 'edit'], true)) {
            return;
        }
        //Set visibility settings from upload
        $video->origin     = $manual->type === 'manual' ? 'manual' : 'edited';
        $video->visibility = $manual->visibility;
        $video->unlisted   = $manual->unlisted;
        $video->save();

        if ($manual->type === 'manual') {
            //Grant uploader edit/delete
            IndividualPermission::updateOrCreate(
                ['video_id' => $video->id, 'username' => $manual->user],
                ['name' => 'Uploader', 'permission' => 'delete']
            );
        }

        //Notify when processing is done
        if ($video->state) {
            $job = $manual->type === 'manual'
                ? new JobUploadSuccessNotification($video, $manual)
                : new JobEditNotification($video, $manual);

            dispatch($job->afterCommit());

            //Flag completed
            $manual->status = 'completed';
            $manual->save();

            //Cleanup local disk
            if ($manual->type === 'manual' && $manual->local) {
                Storage::disk('public')->deleteDirectory($manual->local);
            }
        }
    }
}
