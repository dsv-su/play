<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $video, $failed;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($video, $failed)
    {
        $this->video = $video;
        $this->failed = $failed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('play@dsv.su.se', 'DSVPlay')->subject("[DSVPlay] Failed notification")
            ->view('emails.failed_notification');
    }
}
