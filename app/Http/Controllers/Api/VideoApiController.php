<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\Presentation\PresentationResource;
use App\IndividualPermission;
use App\Jobs\JobUploadSuccessNotification;
use App\Mail\ErrorAlert;
use App\ManualPresentation;
use App\Services\Course\CourseStore;
use App\Services\PermissionHandler\PermissionHandler;
use App\Services\Presenter\PresenterStore;
use App\Services\Stream\StreamsStore;
use App\Services\Tag\TagsStore;
use App\Services\Video\VideoStore;
use App\Services\Video\VideoUpdate;
use App\tokenHandler;
use App\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VideoApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['permission']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Video::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PresentationRequest $request
     * @return JsonResponse
     */
    public function store(PresentationRequest $request): JsonResponse
    {
        $payload = auth()->payload();

        if ($payload->get('per') == 'store') {
            //Start transaction
            DB::beginTransaction();

            //Check if video exist
            if (! $presentation = Video::find($request->id)) {
                try {
                    //Store video
                    $video = new VideoStore($request);
                    $video = $video->presentation();
                    //Set video permissions
                    $permission = new PermissionHandler($request, $video);
                    $permission->setPermission();
                    //Store presenter
                    $presenter = new PresenterStore($request, $video);
                    $presenter->presenter();
                    //Store course
                    $course = new CourseStore($request, $video);
                    $course->course();
                    //Store tags
                    $tags = new TagsStore($request, $video);
                    $tags->tags();
                    //Store streams
                    $streams = new StreamsStore($request, $video);
                    $streams->streams();
                } catch (\Exception $e) {
                    DB::rollback(); // Something went wrong
                    report($e);
                    return response()->json(['error' => 'Something went wrong while creating', 'message' => $e->getMessage()], 400);
                }
            } else {
                try {
                    //Update existing video
                    $video = new VideoUpdate($presentation, $request);
                    $video = $video->presentation_update();
                    //Set video permissions
                    $permission = new PermissionHandler($request, $video);
                    $permission->setPermission();
                    //Store presenter
                    $presenter = new PresenterStore($request, $video);
                    $presenter->presenter();
                    //Store course
                    $course = new CourseStore($request, $video);
                    $course->course();
                    //Store tags
                    $tags = new TagsStore($request, $video);
                    $tags->tags();
                    //Store streams
                    $streams = new StreamsStore($request, $video);
                    $streams->streams();
                } catch (\Exception $e) {
                    DB::rollback(); // Something went wrong
                    report($e);
                    return response()->json(['error' => 'Something went wrong while updating', 'message' => $e->getMessage()], 400);
                }

                DB::commit();   // Successfully updated
                return response()->json('Presentation has been updated', Response::HTTP_CREATED);
            }

            DB::commit();   // Successfully stored

            //If manual upload - Send email to uploader
            if($video->origin == 'manual') {
                //Retrive upload
                $presentation = ManualPresentation::find($video->notification_id);

                //Set edit/delete individual permission for uploader
                IndividualPermission::updateOrCreate([
                    'video_id' => $video->id,
                    'username' => $presentation->user,
                    'name' => 'Uploader', //This can later look up SUKAT for displayname
                    'permission' => 'delete'
                ]);

                //Send email to uploader
                $job = (new JobUploadSuccessNotification($video, $presentation));
                // Dispatch Job and continue
                dispatch($job);

                //Update presentation status
                $presentation->status = 'completed';
                $presentation->save();

                //Remove temp storage
                Storage::disk('public')->deleteDirectory($presentation->local);
            }
            return response()->json('Presentation has been created', Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return
     */
    public function show($id)
    {
        return new PresentationResource(Video::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function perm($id)
    {
        auth()->invalidate();
        //$video = Video::where('presentation_id', $id)->first();
        return response()->json([
            'permission' => 'true'
        ], 200);
    }

    public function permission(Request $request)
    {
        $ticket = json_encode(request(['token']));
        $payload = auth()->payload();

        $video = Video::find($payload->get('id'));
        $allow = count(json_decode($video->sources, true));

        try {
            JWTAuth::parseToken($ticket)->authenticate();
            //Allow the same token for all streams in presentation
            if($tokenhandler = tokenHandler::where([['video_id', $payload->get('id')],['token', $request->token]])->first()) {
                //Expire token if all streams have passed
                if($tokenhandler->allow < 1) {
                    JWTAuth::parseToken($ticket)->invalidate();
                    $tokenhandler->delete();
                    // Token is expired
                    return response()->json([
                        'permission' => 'denied'
                    ]);
                } else {
                    //Pass next stream
                    $tokenhandler->allow = $tokenhandler->allow - 1;
                    $tokenhandler->save();
                }

            } else {
                //Remove old existing token
                if($oldtoken = tokenHandler::where('video_id', $payload->get('id'))->first()){
                    $oldtoken->delete();
                }
                //New request
                tokenHandler::create([
                    'video_id' => $payload->get('id'),
                    'token' => $request->token,
                    'allow' => $allow - 1,
                ]);
            }

            return response()->json([
                'permission' => 'granted'
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            // Token is expired
            return response()->json([
                'permission' => 'denied'
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            // Token is invalid
            return response()->json([
                'permission' => 'invalid'
            ]);

        }  catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            // Token is not present
            return response()->json([
                'permission' => 'denied'
            ]);
        }

    }

    public function permissions($id)
    {
        $video = Video::where('presentation_id', $id)->first();
        $entitlements = explode(";", $video->entitlement);

        return response()->json([
            'public' => $video->permission,
            'entitlements' => $entitlements
        ], 200);

    }

}
