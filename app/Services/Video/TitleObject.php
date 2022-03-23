<?php

namespace App\Services\Video;


class TitleObject
{
    public $title, $json;

    public function __construct($title)
    {
        if($this->isJson($title)) {
            $this->json = true;
            $this->title = json_decode(json_encode($title, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), true);
        } else {
            $this->json = false;
            $this->title = $title;
        }

    }

    public function swedish()
    {
        if($this->json) {
            if(is_null($this->title['sv'])) {
                return 'Okänd titel';
            }
            return $this->title['sv'];
        } else {
            return $this->title;
        }
    }

    public function english()
    {
        if($this->json) {
            if(is_null($this->title['en'])) {
                return 'Unknown title';
            }
            return $this->title['en'];
        }  else {
            return '';
        }
    }

    private function isJson($string) {
        if(is_array($string)) {
            return true;
        } else {
            return false;
        }

        /*if(json_decode($string, true) === null) {
            return false;
        } else {
            return true;
        }*/
    }
}
