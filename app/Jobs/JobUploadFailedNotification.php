<?php

namespace App\Jobs;

use App\Mail\UploadFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JobUploadFailedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $presentation = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($presentation)
    {
        $this->presentation = $presentation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->presentation->user_email)->send(new UploadFailedNotification($this->presentation));
    }
}
