<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Symfony\Component\String\s;

class UpdateMultiplayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:multiplayer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This artisan command is used to pull the latest committed updates from the multiplayer repo.';

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
        // Update multiplayer repo
        $update_multiplayer = 'cd '.storage_path().'/app/multiplayer;git pull';
        $create_local_player = 'cd '.storage_path().'/app/multiplayer;python3 make_dlplayer.py';
        exec($update_multiplayer, $output);

        if($output[0] == 'Already up to date.') {
            $this->comment( 'Multiplayer is '. implode( PHP_EOL, $output ) );
        } else {
            exec($create_local_player);
            $this->comment( 'Multiplayer successfully updated' );
        }
        return 0;
    }
}
