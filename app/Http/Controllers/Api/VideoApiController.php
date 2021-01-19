<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\Presentation\PermissionsResource;
use App\Http\Resources\Presentation\PresentationResource;
use App\Services\CourseStore;
use App\Services\PresenterStore;
use App\Services\TagsStore;
use App\Services\VideoStore;
use App\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VideoApiController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
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

        if($payload->get('per') == 'store')
        {
            //Store video
            $video = new VideoStore($request);
            $video = $video->presentation();
            //Store presenter
            $presenter = new PresenterStore($request, $video);
            $presenter->presenter();
            //Store course
            $course = new CourseStore($request, $video);
            $course->course();
            //Store tags
            $tags = new TagsStore($request, $video);
            $tags->tags();

            return response()->json('Presentation has been created', Response::HTTP_CREATED);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PresentationResource(Video::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
            'Permission' => 'True'
        ], 200);
    }

    public function permission()
    {
        $ticket = json_encode(request(['token']));
        try {
            JWTAuth::parseToken($ticket)->authenticate();
            JWTAuth::parseToken($ticket)->invalidate();
            return response()->json([
                'Permission' => 'Granted'
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            // Token is expired
            return response()->json([
                'Permission' => 'Denied'
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            // Token is invalid
            return response()->json([
                'Permission' => 'Denied'
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            // Token is not present
            return response()->json([
                'Permission' => 'Denied'
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
