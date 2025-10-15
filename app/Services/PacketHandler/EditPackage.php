<?php

namespace App\Services\PacketHandler;

use App\Models\Course;
use App\Models\ManualPresentation;
use App\Services\Notify\PlayStoreNotify;
use App\Services\Upload\Metadata;
use App\Models\Tag;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EditPackage
{
    protected $video, $gsubtitles;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function sendBackend(Request $request)
    {
        //dd($request->all());
        //EditHandler
        /*$presentation = ManualPresentation::where('pkg_id', $this->video->id)->latest()->first();
        $presentation->type = 'edit';
        //Video attributes
        $presentation->title = $request->title;
        $presentation->title_en = $request->title_en;
        $presentation->description = $request->description;
        $presentation->created = Carbon::createFromFormat('Y-m-d', $request->recording_date)->timestamp;
        $presentation->visibility = $this->video->visibility;
        $presentation->unlisted = $this->video->unlisted;

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
                    'semester' => Str::lower($course->semester) . $course->year
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

        //Subtitle language
        if(!$presentation->autogenerate_subtitles) {
            $presentation->sublanguage = $request->subtitle_language;
            $presentation->save();
        }*/

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
return        $notify->sendSuccess('edit');

    }

    public function sendBulkBackend(Request $request)
    {
        //EditHandler
        $presentation = ManualPresentation::where('pkg_id', $this->video->id)->latest()->first();
        $presentation->type = 'edit';
        //Video attributes
        $presentation->title = $this->video->title;
        $presentation->title_en = $this->video->title_en ?? 'English title';
        $presentation->description = $this->video->description;
        $presentation->created = (int)$this->video->creation;
        $presentation->visibility = $this->video->visibility;
        $presentation->unlisted = $this->video->unlisted;

        //Video presenters (exkluded external)
        if(!empty($request->supresenters)) {
            $presentation->presenters = $request->supresenters;
        } else {
            $presentation->presenters = $this->video->presenters()->pluck('username') ?? null;
        }

        //External preseneters
        if(!empty($request->externalpresenters)) {
            $presentation->presenters = array_merge($presentation->presenters,$request->externalpresenters);
        }


        //Video courses
        if (!$request->courses == null) {
            foreach ($request->courses as $courseid) {
                $course = Course::find($courseid);
                $courses[] = \Illuminate\Support\Collection::make([
                    'designation' => $course->designation,
                    //'semester' => Str::lower($course->semester) . substr($course->year, 2)
                    'semester' => Str::lower($course->semester) . $course->year
                ]);
            }

        } else {
            //Use presentations origin course association converted to new format
            foreach($this->video->courses() as $course) {
                $courses[] = \Illuminate\Support\Collection::make([
                    'designation' => $course->designation,
                    //'semester' => Str::lower($course->semester) . substr($course->year, 2)
                    'semester' => Str::lower($course->semester) . $course->year
                ]);
            }
        }
        $presentation->courses = $courses;
        //Video Tags
        if (!$request->tags == null) {
            foreach ($request->tags as $tag) {
                $tags[] = $tag;
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
return        $notify = new PlayStoreNotify($presentation);
        $notify->sendSuccess('edit');
    }
}
