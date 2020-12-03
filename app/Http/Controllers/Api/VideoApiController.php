<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresentationRequest;
use App\Http\Resources\Presentation\PresentationResource;
use App\Video;
use Carbon\Carbon;
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
        $video = new Video;
        $video->presentation_id = $request->id;
        $video->title = $request->title;
        $video->thumb = $request->thumb;
        $video->presenter = $request->presenter;
        $video->duration = (new Carbon($request->end ?? null))->diff(new Carbon($request->start ?? null))->format('%h:%I');
        $video->subtitles = $request->subtitles;
        $video->tags = json_encode($request->tags, true);
        $video->sources = json_encode($request->sources, true);
        $video->presentation = json_encode($request->all(), true);
        $video->course_id = $request->course_id;
        $video->category_id = $request->category_id;
        $video->save();
        return response()->json('Presentation has been created', Response::HTTP_CREATED);
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

    public function permission(Request $request)
    {
        //TODO
        //return $request->input('user');
        //return $request->getContent();
        return response()->json('Wait for it', 200);

    }
}
