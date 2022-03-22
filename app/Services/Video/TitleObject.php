<?php

namespace App\Services\Video;


class TitleObject
{
    public $title;

    public function __construct($title)
    {
        $this->title = json_decode(json_encode($title, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), true);;
    }

    public function swedish()
    {
        if(is_null($this->title['sv'])) {
            return 'Okänd titel';
        }
        return $this->title['sv'];
    }

    public function english()
    {
        if(is_null($this->title['en'])) {
            return 'Unknown title';
        }
        return $this->title['en'];
    }
}
