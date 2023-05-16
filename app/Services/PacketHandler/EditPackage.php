<?php

namespace App\Services\PacketHandler;

use App\Course;
use App\ManualPresentation;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Upload\Metadata;
use App\Tag;
use App\Video;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Null_;

class EditPackage
{
    protected $video, $gsubtitles;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function sendBackend(Request $request)
    {
        //EditHandler
        $presentation = ManualPresentation::where('pkg_id', $this->video->id)->latest()->first();
        $presentation->type = 'edit';

        //Video attributes
        $presentation->title = $request->title;
        $presentation->title_en = $request->title_en;
        $presentation->description = $request->description;
        $presentation->created = Carbon::createFromFormat('d/m/Y', $request->date)->timestamp;


        //Video presenters
        if(!empty($request->presenteruids)) {
            $presentation->presenters = $request->presenteruids;
        } else {
            $presentation->presenters = null;
        }


        //Video courses
        if (!$request->courseids == null) {
            foreach ($request->courseids as $courseid) {
                $course = Course::find($courseid);
                $courses[] = \Illuminate\Support\Collection::make([
                    'designation' => $course->designation,
                    'semester' => Str::lower($course->semester) . substr($course->year, 2)
                ]);
            }
            $presentation->courses = $courses;
        }

        //Video Tags
        if (!$request->tags == null) {
            foreach ($request->tags as $tagid) {
                $tag = Tag::find($tagid);
                $tags[] = $tag->name;
            }
            $presentation->tags = $tags;
        }

        $presentation->save();

        //Send to backend
        //Create thumbs and metadata
        $metadata = new Metadata();
        $metadata->create($presentation);

        //Change packethandler status
        $presentation->status = 'stored';
        $presentation->save();

        //Change video state
        $this->video->state = 0;
        $this->video->save();

        //Send notification to editor

        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendSuccess('edit');

    }
}
