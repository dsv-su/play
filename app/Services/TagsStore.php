<?php

namespace App\Services;

use App\Tag;
use App\VideoTag;
use Illuminate\Database\Eloquent\Model;

class TagsStore extends Model
{
    public function __construct($request, $video)
    {
        $this->tags = $request->tags;
        $this->video = $video;
    }

    public function tags()
    {
        foreach ($this->tags as $this->item) {
            if (!$this->db_tag = Tag::where('name', $this->item)->first())  {
                $this->tag = Tag::create([
                    'name' => $this->item
                ]);
                VideoTag::create([
                    'video_id' => $this->video->id,
                    'tag_id' => $this->tag->id,
                ]);
            }
            else
                {
                VideoTag::create([
                    'video_id' => $this->video->id,
                    'tag_id' => $this->db_tag->id,
                ]);
            }
        }
    }
}
