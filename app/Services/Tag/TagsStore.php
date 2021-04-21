<?php

namespace App\Services\Tag;

use App\Tag;
use App\VideoTag;
use Illuminate\Database\Eloquent\Model;

class TagsStore extends Model
{
    protected $tags, $video;

    public function __construct($request, $video)
    {
        $this->tags = $request->tags;
        $this->video = $video;
    }

    public function tags()
    {
        if(count($this->tags)>0) {

            foreach ($this->tags as $key => $this->item) {
                if ($this->item) {
                    if (! $this->db_tag = Tag::where('name', $this->item)->first()) {
                        $this->tag = Tag::create([
                            'name' => $this->item
                        ]);
                        VideoTag::create([
                            'video_id' => $this->video->id,
                            'tag_id' => $this->tag->id,
                        ]);
                    } else {
                        if($key == 0) {
                            //Remove any old associations
                            VideoTag::where('video_id', $this->video->id)->delete();
                        }
                        //Create new associations
                        VideoTag::Create([
                            'video_id' => $this->video->id,
                            'tag_id' => $this->db_tag->id,
                        ]);
                    }
                } //end check
            } // end foreach

        } else {
            //Remove any old associations
            VideoTag::where('video_id', $this->video->id)->delete();
        }
    }

}
