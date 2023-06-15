<?php

namespace App\Services\PacketHandler;

use App\Course;
use App\Stream;
use App\StreamResolution;
use App\Video;
use Illuminate\Support\Str;

class UpdatePackage
{
    protected $presentation;
    protected $json;

    public function local()
    {
        //Updates local main stream name
        $streams = Stream::where('audio', true)->get();
        foreach ($streams as $stream) {
            $stream->name = 'main';
            $stream->save();
        }
    }

    public function remote()
    {
        $this->presentation = Video::find('c110b04a-195e-4f7e-9269-24fb8184efd6');
        $this->presentation
            ->makeHidden('id')
            ->makeHidden('origin')
            ->makeHidden('creation')
            ->makeHidden('link')
            ->makeHidden('thumb')
            ->makeHidden('state')
            ->makeHidden('download')
            ->makeHidden('category_id')
            ->makeHidden('presentation')
            ->makeHidden('notification_id')
            ->makeHidden('title_en')
            ->makeHidden('status')
            ->makeHidden('type')
            ->makeHidden('jobid')
            ->makeHidden('duration')
            ->makeHidden('autogenerate_subtitles')
            ->makeHidden('user')
            ->makeHidden('user_email')
            ->makeHidden('local')
            ->makeHidden('visibility')
            ->makeHidden('unlisted')
            ->makeHidden('files')
            ->makeHidden('permission')
            ->makeHidden('entitlement')
            ->makeHidden('daisy_courses')
            ->makeHidden('created_at')
            ->makeHidden('updated_at');

        //Conditions
        if(!$this->presentation->description) {
            $this->presentation
                ->makeHidden('description');
        }

        //Additions
        $this->presentation->pkg_id = $this->presentation->id;
        $this->presentation->created = $this->presentation->creation;
        $this->presentation->title = ['sv' => $this->presentation['title'], 'en' => $this->presentation['title_en']];

        //Courses
        $courses = [];
        if ($this->presentation->courses()) {
            foreach ($this->presentation->courses() as $course) {
                $course = Course::find($course->id);
                $courses[] = \Illuminate\Support\Collection::make([
                    'designation' => $course->designation,
                    'semester' => Str::lower($course->semester) . substr($course->year, 2)
                ]);
            }
        }
        $this->presentation->courses = \Illuminate\Support\Collection::make($courses);

        //Tags
        $tags = [];
        if ($this->presentation->tags()) {
            foreach ($this->presentation->tags() as $tag) {
                $tags[] = $tag;
            }
        }
        $this->presentation->tags = \Illuminate\Support\Collection::make($tags);

        //Sources
        $streams = Stream::where('video_id', $this->presentation->id)->get();
        foreach ($streams as $key => $stream) {
            $resolutions = StreamResolution::where('stream_id', $stream->id)->get();

            foreach ($resolutions as $resolution) {
                $videosource[$resolution->resolution] = $this->base_uri() .'/'. $this->presentation->id . '/' . $resolution->filename;
            }
            $build = \Illuminate\Support\Collection::make([
                'video' => \Illuminate\Support\Collection::make($videosource),
                'poster' => $this->base_uri() . '/' . $this->presentation->id . '/' . $stream->poster,
                'playAudio' => (bool)$stream->audio
            ]);

            $buildsource[$stream->name] = $build;

        }
        $this->presentation->sources = \Illuminate\Support\Collection::make($buildsource);

        $this->json = $this->presentation;
        $this->json = $this->json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Success
        return $this->json;
        //
    }

    private function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            abort(503);
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

}
