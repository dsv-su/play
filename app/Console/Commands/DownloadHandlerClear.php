<?php

namespace App\Console\Commands;

use App\Presentation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DownloadHandlerClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans up stored downloads';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $downloads = Presentation::all();
        foreach($downloads as $download) {
            if($download->status == 'stored') {
                //Remove files and zip
                Storage::disk('public')->deleteDirectory($download->local);
                Presentation::destroy($download->id);
            }
        }

        return 0;
    }
}
