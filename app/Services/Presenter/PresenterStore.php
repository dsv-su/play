<?php

namespace App\Services\Presenter;

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
            if(!$this->db_presenter = Presenter::where('username', $this->item)->first()) {
                $this->presenter = Presenter::create([
                    'username' => $this->item,
                ]);

                VideoPresenter::create([
                    'video_id' => $this->video->id,
                    'presenter_id' => $this->presenter->id,
                ]);
            }
            else
            {
                VideoPresenter::updateOrCreate([
                    'video_id' => $this->video->id,
                    'presenter_id' => $this->db_presenter->id,
                ]);
            }
        }
    }
}
