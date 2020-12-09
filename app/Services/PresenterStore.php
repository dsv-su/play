<?php

namespace App\Services;

use App\Presenter;
use App\VideoPresenter;
use Illuminate\Database\Eloquent\Model;

class PresenterStore extends Model
{
    public function __construct($request, $video)
    {
        $this->presenters = $request->presenters;
        $this->video = $video;
    }

    public function presenter()
    {
        foreach ($this->presenters as $this->item)
        {
            if(!$this->db_presenter = Presenter::where('name', $this->item)->first()) {
                $this->presenter = Presenter::create([
                    'name' => $this->item,
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
        }
    }
}
