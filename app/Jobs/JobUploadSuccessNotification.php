<?php

namespace App\Jobs;

use App\Mail\UploadSuccessNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JobUploadSuccessNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video = [];
    public $presentation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video, $presentation)
    {
        $this->video = $video;
        $this->presentation = $presentation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send Mail
        Mail::to($this->presentation->user_email)->send(new UploadSuccessNotification($this->video));
    }
}
