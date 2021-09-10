<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Livewire\Component;
use App\Services\Ldap\SukatUser;


class IndividualUser extends Component
{
    public $query;
    public $uids = [];
    public $users = [];
    public $highlightIndex;

    public function mount()
    {
       $this->clear();
    }

    public function clear()
    {
        $this->query = '';

        $this->users = [];

        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {

        if ($this->highlightIndex === count($this->users) - 1) {

            $this->highlightIndex = 0;

            return;

        }

        $this->highlightIndex++;

    }

    public function decrementHighlight()
    {

        if ($this->highlightIndex === 0) {

            $this->highlightIndex = count($this->users) - 1;

            return;

        }

        $this->highlightIndex--;

    }

    public function selectUser()
    {
        $user = $this->users[$this->highlightIndex] ?? null;

        if ($user) {

            dd('Ok');

        }

    }

    public function updatedQuery()
    {
        //Retrive userdetails from SUKAT
        $sukat_search = SukatUser::whereStartsWith('cn', $this->query)->limit(5)->get()->toArray();
        $collection = collect($sukat_search);
        $dn = $collection->map(function ($item, $key)  {
            return [$item->displayname];

        });
        $userid = $collection->map(function ($item, $key)  {
            return $item->uid;

        });
        $displayname = collect(Arr::flatten($dn));
        //$uid =  Arr::flatten($userid);
        $combined = $displayname->combine(Arr::flatten($userid));
        $this->users = $combined->toArray();

    }

    public function render()
    {
        return view('livewire.individual-user');
    }
}
