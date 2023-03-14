<?php

namespace App\Services\Presenter;

use App\IndividualPermission;
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
        if ($this->presenters) {
            foreach ($this->presenters as $key => $this->item) {
                if ($this->item) {
                    if (!$this->db_presenter = Presenter::where('username', $this->item)->first()) {
                        //Stores new presenters
                        if ($this->name = SukatUser::findBy('uid', $this->item)) {
                            //Presenter found in SUKAT
                            $this->presenter = Presenter::create([
                                'username' => $this->item,
                                'name' => $this->name->getFirstAttribute('cn'),
                                'description' => 'sukat',
                            ]);
                            //Add edit-permission for presenter
                            IndividualPermission::create([
                                'video_id' => $this->video->id,
                                'username' => $this->item,
                                'name' => $this->name->getFirstAttribute('cn'),
                                'permission' => 'edit',
                            ]);
                        } else {
                            //External presenter
                            $this->presenter = Presenter::create([
                                'name' => $this->item,
                                //'username' => $this->item,
                                'description' => 'external',
                            ]);
                        }

                        VideoPresenter::create([
                            'video_id' => $this->video->id,
                            'presenter_id' => $this->presenter->id,
                        ]);
                    } else {
                        //Updates presenters
                        if ($this->name = SukatUser::findBy('uid', $this->item)) {
                            //Update presenter
                            $this->db_presenter::updateOrCreate([
                                'username' => $this->item],
                                [
                                    'username' => $this->item,
                                    'name' => $this->name->getFirstAttribute('cn'),
                                ]);
                            //Update edit-permission
                            IndividualPermission::updateOrCreate([
                                'video_id' => $this->video->id,
                                'username' => $this->item],
                                [
                                    'video_id' => $this->video->id,
                                    'username' => $this->item,
                                    'name' => $this->name->getFirstAttribute('cn'),
                                    'permission' => 'edit',
                                ]);
                        }
                        if ($key == 0) {
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
