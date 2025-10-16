<?php

namespace App\Http\Resources\Presentation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresentationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
          'id' => $this->presentation_id,
          'title' => $this->title,
          'thumb' => $this->thumb,
          'presenter' => $this->presenter,
          'subtitles' => $this->subtitles,
          'tags' => $this->tags,
        ];
    }
}
