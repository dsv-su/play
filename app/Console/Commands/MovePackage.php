<?php

namespace App\Console\Commands;

use App\Models\Package;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MovePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:move-package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Move presentation package from model video to package
        Video::whereNotNull('presentation')
            ->chunkById(200, function ($videos) {
                DB::transaction(function () use ($videos) {
                    foreach ($videos as $video) {
                        $package = Package::find($video->id) ?? new Package(['id' => $video->id]);
                        $package->presentation = $video->presentation;
                        $package->save();

                        $video->update(['presentation' => null]);
                    }
                });
            });

        return Command::SUCCESS;
    }
}
