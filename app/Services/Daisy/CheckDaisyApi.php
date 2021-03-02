<?php

namespace App\Services\Daisy;

use App\System;
use Illuminate\Database\Eloquent\Model;

class CheckDaisyApi extends Model
{
    public function call($healt='health')
    {
        $system = System::find(1);
        $daisy = new DaisyIntegration($system);
        return json_decode($daisy->getResource($healt)->getBody()->getContents() , true);
    }


}
