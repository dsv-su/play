<?php

namespace App\Jobs;

use App\Mail\ErrorAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Developer Notification Job
 */
class JobDevNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $exception = [];

    /**
     * Create a new job instance.
     *
     * @param array $exception
     * @return void
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        // Send Mail
        Mail::to("ryan@dsv.su.se")->send(new ErrorAlert($this->exception));
    }
}
