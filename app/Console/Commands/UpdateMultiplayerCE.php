<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UpdateMultiplayerCE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:multiplayer-ce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This artisan command is used to pull the latest committed updates from the multiplayer-ce repo.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Define the paths for the multiplayer repository
        $multiplayerPath = storage_path(). '/multiplayer-ce';
        $multiplayerJsSource = storage_path('multiplayer-ce/multiplayer.js');
        $multiplayerJsDestination = public_path('js/multiplayer.js');
        $updateMultiplayerCmd = "cd $multiplayerPath && git pull";

        //Execute the update command for the multiplayer repository
        exec($updateMultiplayerCmd, $output, $statusCode);

        //Check if the repository update was successful
        if ($statusCode === 0) {
            if (isset($output[0]) && $output[0] === 'Already up to date.') {
                $this->comment('MultiplayerCE is already up to date.');
            } else {
                // Log or output the update results if not "Already up to date"
                $this->comment('MultiplayerCE update output: ' . implode(PHP_EOL, $output));
            }
        } else {
            //Handle failure: output the error details
            $this->comment('Failed to update MultiplayerCE repository. Error: ' . implode(PHP_EOL, $output));
            return 1; // Return failure status
        }

        // Ensure destination directory exists
        File::ensureDirectoryExists(dirname($multiplayerJsDestination));

        // Validate source
        if (!File::exists($multiplayerJsSource)) {
            $this->error("Source file not found: {$multiplayerJsSource}");
            return self::FAILURE;
        }

        //Copy the updated multiplayer.js file to the public directory
        if (!File::copy($multiplayerJsSource, $multiplayerJsDestination)) {
            $this->error('Failed to copy multiplayer.js to public/js.');
            return self::FAILURE;
        }

    //Indicate that the update and copy were successful
        $this->comment('MultiplayerCE has been successfully updated and multiplayer.js has been copied.');
        return 0; // Return success status

    }
}
