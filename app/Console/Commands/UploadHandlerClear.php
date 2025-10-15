<?php

namespace App\Console\Commands;

use App\ManualPresentation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UploadHandlerClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans up unfinished uploads';

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
        DB::table('manual_presentations')->where('status', 'init')->orWhere('status', 'completed')->delete();
        return 0;
    }
}
