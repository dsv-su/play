<?php

namespace App\Services\Cattura;

use App\Cattura;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatturaRecoders extends Model
{

    protected $cattura;

    public function __construct(Cattura $cattura)
    {
        $this->cattura = $cattura;
    }

    public function init()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('catturas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($file)) {
            abort('503');
        }
        $system_config = parse_ini_file($file, true);
        if($system_config['recorders']) {
            foreach ($system_config['recorders'] as $recorder => $url) {
                $this->cattura->create([
                    'recorder' => $recorder,
                    'status' => 'CHECKING',
                    'url' => $url
                ]);
            }

        } else {
            abort('503');
        }
        return 0;
    }

    public function updateState():void
    {
        $store = new CheckCatturaRecorderStatus();
        foreach($this->cattura->all()->toArray() as $key => $system) {
            $check = $store->call($system['url'],'api/1/status?since=');
            $recorder = $this->cattura->where('recorder', $system['recorder'])->first();
            $recorder->status = $check['capture']['state'];
            $recorder->save();
        }

    }
}
