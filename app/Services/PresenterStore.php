<?php

namespace App\Services;

use App\Presenter;
use App\VideoPresenter;
use Illuminate\Database\Eloquent\Model;

class PresenterStore extends Model
{
    public function __construct($request, $video)
    {
        $this->presenter = $request->presenter;
        $this->video = $video;
    }

    public function presenter()
    {
        if(!$this->db_presenter = Presenter::where('name', $this->presenter)->first()) {
            $this->presenter = Presenter::create([
                'name' => $this->presenter,
            ]);

            VideoPresenter::create([
                'video_id' => $this->video->id,
                'presenter_id' => $this->presenter->id,
            ]);
        }
        else
        {
            VideoPresenter::create([
                'video_id' => $this->video->id,
                'presenter_id' => $this->db_presenter->id,
            ]);
        }


        return $this->presenter;
    }
}
