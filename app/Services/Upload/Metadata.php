<?php

namespace App\Services\Upload;

use App\Jobs\JobUploadFailedNotification;
use App\ManualPresentation;
use App\Stream;
use Illuminate\Support\Collection;

class Metadata
{
    protected $sourse = [];
    protected $gsubtitles = [];

    public function create(ManualPresentation $presentation)
    {
        //$Determine = new PresentationDuration();
        //$Thumb = new StreamThumb();

        $finalPath = $this->storage() . '/'. $presentation->local;
        $videoPath = $finalPath . '/video/';
        $subtitlePath = $finalPath . '/subtitle/';
        //Creates the source attribute
        $presentation->sources = [];
        //Adds source and created thumbs
        foreach (\Illuminate\Support\Facades\Storage::disk('play-store')->files($videoPath) as $key => $filename) {
        /* Disabled 231102 RD
            //Add duration
            if($key ==  0 ) {
                if($presentation->duration = $Determine->duration($filename)) {
                    $presentation->save();
                } else {
                    //Something went wrong - Send email to uploader
                    $job = (new JobUploadFailedNotification($presentation));

                    // Dispatch Job and continue
                    dispatch($job);
                }

            }

            //Set time in sec for thumb generation
            if($presentation->duration < 30 ) {
                $thumbcreated_after = $presentation->duration/3;
            } else {
                //Fallback
                $thumbcreated_after = 30;
            }

            //Create thumb for uploaded video
            $thumburl = $Thumb->create($finalPath, $filename, $thumbcreated_after);

            //Sources

            $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            //Add video source
            */

            foreach($files = \Illuminate\Support\Facades\Storage::disk('play-store')->files($videoPath) as $stream => $f) {
                $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($f));
                if($stream == 0) {
                    $this->source['main'] = [
                        'video' => 'video/'. basename($f),
                        //'poster' => 'poster/'. $thumb_name . '.png',
                        'playAudio' => true,
                    ];
                } else {
                    $this->source['camera'.$stream] = [
                        'video' => 'video/'. basename($f),
                        //'poster' => 'poster/'. $thumb_name . '.png',
                        'playAudio' => false,
                    ];
                }
            }

            $presentation->sources = $this->source;

        }

        //Subtitle
        if($subtitles = \Illuminate\Support\Facades\Storage::disk('play-store')->files($subtitlePath)) {
            switch($presentation->sublanguage) {
                case('english'):
                    if($presentation->type == 'manual') {
                        $presentation->subtitles = [
                            'English' => 'subtitle/' . basename($subtitles[0])
                        ];
                    } else {
                        //Edit
                        if(!empty($presentation->subtitles)) {
                            $presentation->subtitles = array_merge($presentation->subtitles, [
                                'English' => 'subtitle/' . basename($subtitles[0])
                            ]);
                        } else {
                            $presentation->subtitles = [
                                'English' => 'subtitle/' . basename($subtitles[0])
                                //'Generated' => ''
                            ];
                        }
                    }
                    break;
                case('swedish'):
                    if($presentation->type == 'manual') {
                        $presentation->subtitles = [
                            'Svenska' => 'subtitle/' . basename($subtitles[0])
                        ];
                    } else {
                        //Edit
                        if(!empty($presentation->subtitles)) {
                            $presentation->subtitles = array_merge($presentation->subtitles, [
                                'Svenska' => 'subtitle/' . basename($subtitles[0])
                            ]);
                        } else {
                            $presentation->subtitles = [
                                'Svenska' => 'subtitle/' . basename($subtitles[0])
                                //'Generated' => ''
                            ];
                        }
                    }
                    break;
                default:
                    if($presentation->type == 'manual') {
                        $presentation->subtitles = [
                            'Svenska' => 'subtitle/' . basename($subtitles[0])
                        ];
                    } else {
                        //Edit
                        if(!empty($presentation->subtitles)) {
                            $presentation->subtitles = array_merge($presentation->subtitles, [
                                'Svenska' => 'subtitle/' . basename($subtitles[0])
                            ]);
                        } else {
                            $presentation->subtitles = [
                                'Svenska' => 'subtitle/' . basename($subtitles[0])
                                //'Generated' => ''
                            ];
                        }
                    }
            }
            //Add reference to upload dir
            $presentation->upload_dir = '/data0/'. $this->storage() . '/' . $presentation->local;

        }

        //Subtitle generation
        if($presentation->pkg_id) {
            $stream = Stream::where('video_id', $presentation->pkg_id)->where('audio', true)->first();
            if($presentation->sublanguage) {
                $this->gsubtitles['Generated'] = Collection::make([
                    'type' => 'whisper',
                    'source' => $stream->name ?? 'main',
                    'language' => $presentation->sublanguage
                ]);
            } else {
                $this->gsubtitles['Generated'] = Collection::make([
                    'type' => 'whisper',
                    'source' => $stream->name ?? 'main'
                ]);
            }

        } else {
            if($presentation->sublanguage) {
                $this->gsubtitles['Generated'] = Collection::make([
                    'type' => 'whisper',
                    'source' => $stream->name ?? 'main',
                    'language' => $presentation->sublanguage
                ]);
            } else {
                $this->gsubtitles['Generated'] = Collection::make([
                    'type' => 'whisper',
                    'source' => $stream->name ?? 'main'
                ]);
            }
        }

        $presentation->generate_subtitles = $this->gsubtitles;

        //Failcheck
        if(!count($files ?? []) > 0) {
            return false;
        }

        return $presentation->save();
    }

    private function storage()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['nfs']['storage'];
    }
}
