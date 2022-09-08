<?php

namespace App\Jobs;

use App\Mail\FailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JobFailedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $video, $failed;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video, $failed)
    {
        $this->video = $video;
        $this->failed = $failed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send Mail
        Mail::to("ryan@dsv.su.se")->send(new FailedNotification($this->video, $this->failed));
        Mail::to("marihan@dsv.su.se")->send(new FailedNotification($this->video, $this->failed));
    }
}
