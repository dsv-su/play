<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\Presentation\PermissionsResource;
use App\Http\Resources\Presentation\PresentationResource;
use App\Services\CourseStore;
use App\Services\PresenterStore;
use App\Services\VideoStore;
use App\Video;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresentationRequest $request)
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

    public function permissions(Request $request)
    {

        $video = Video::where('presentation_id', $request->id)->first();
        $entitlements = explode(";", $video->entitlement);

        return response()->json([
            'public' => $video->permission,
            'entitlements' => $entitlements
        ], 200);

    }
}
