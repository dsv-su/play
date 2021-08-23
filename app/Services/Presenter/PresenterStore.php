<?php

namespace App\Services\Presenter;

use App\Presenter;
use App\Services\Ldap\SukatUser;
use App\VideoPresenter;
use Illuminate\Database\Eloquent\Model;

class PresenterStore extends Model
{
    protected $presenter, $item, $video;
    protected $name, $username;

    public function __construct($request, $video)
    {
        $this->presenters = $request->presenters;
        $this->video = $video;
    }

    public function presenter()
    {
        if($this->presenters) {
            foreach ($this->presenters as $key => $this->item)
            {
                if($this->item) {
                    if(! $this->db_presenter = Presenter::where('username', $this->item)->first()) {
                        //Stores new presenters
                        if($this->name = SukatUser::findBy('uid', $this->item)) {
                            $this->presenter = Presenter::create([
                                'username' => $this->item,
                                'name' => $this->name->getFirstAttribute('cn'),
                            ]);
                        } else {
                            $this->presenter = Presenter::create([
                                'username' => $this->item,
                            ]);
                        }

                        VideoPresenter::create([
                            'video_id' => $this->video->id,
                            'presenter_id' => $this->presenter->id,
                        ]);
                    }
                    else
                    {
                        //Updates presenters
                        if($this->name = SukatUser::findBy('uid', $this->item)) {
                            $this->db_presenter::updateOrCreate([
                                'username' => $this->item],
                                [
                                    'username' => $this->item,
                                    'name' => $this->name->getFirstAttribute('cn'),
                                ]);
                        }
                        if($key == 0) {
                            //Remove any old associations
                            VideoPresenter::where('video_id', $this->video->id)->delete();
                        }
                        //Create new associations
                        VideoPresenter::Create([
                            'video_id' => $this->video->id,
                            'presenter_id' => $this->db_presenter->id,
                        ]);
                    }
                } else {
                    //Remove any old associations
                    VideoPresenter::where('video_id', $this->video->id)->delete();
                } // end check
            } // end foreach
        }


    }
}
