<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UploadHandlerClearFailed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload_failed:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans up failed uploads';

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
        DB::table('manual_presentations')->where('status', 'notified fail')->orWhere('status', 'notification error')->delete();
        return 0;
    }
}
