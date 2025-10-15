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
        // Define the paths
        $multiplayerPath = storage_path() . '/app/multiplayer';
        $updateMultiplayerCmd = "cd $multiplayerPath && git pull";
        $createLocalPlayerCmd = "cd $multiplayerPath && python3 make_dlplayer.py";

        // Update multiplayer repository
        exec($updateMultiplayerCmd, $output, $statusCode);

        // Check if the repository is already up to date
        if ($statusCode === 0) {
            if (isset($output[0]) && $output[0] === 'Already up to date.') {
                $this->comment('Multiplayer is already up to date.');
            } else {
                // Handle unexpected output, maybe log it
                $this->comment('Multiplayer update output: ' . implode(PHP_EOL, $output));
            }
        } else {
            // If the git pull fails, handle the error
            $this->comment('Failed to update multiplayer repository. Error: ' . implode(PHP_EOL, $output));
            return 1; // Indicate failure
        }

        // Create local player if the update was successful
        exec($createLocalPlayerCmd, $createPlayerOutput, $createPlayerStatusCode);

        if ($createPlayerStatusCode === 0) {
            $this->comment('Multiplayer successfully updated and local player created.');
        } else {
            // If creating local player fails, handle the error
            $this->comment('Failed to create local player. Error: ' . implode(PHP_EOL, $createPlayerOutput));
            // Indicate failure
            return 1;
        }
        // Indicate success
        return 0;
    }
}
