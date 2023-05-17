<?php

namespace App\Console\Commands;

use App\Services\PacketHandler\UpdatePackage;
use Illuminate\Console\Command;

class UpdateLocalPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:local';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates local packages to new format';

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
        $update = new UpdatePackage();
        $update->local();
        return 0;
    }
}
