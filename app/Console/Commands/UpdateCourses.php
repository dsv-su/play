<?php

namespace App\Console\Commands;

use App\Services\Daisy\DaisyIntegration;
use Illuminate\Console\Command;

class UpdateCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load and update courses from Daisy';

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
        $daisy = new DaisyIntegration();
        $daisy->init();
        return 0;
    }
}
