<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateAdminHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminhandler:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trunacate the AdminHandler table daily';

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin_handlers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return 0;
    }
}
