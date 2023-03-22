<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UploadFailedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $presentation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($presentation)
    {
        $this->presentation = $presentation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@dsv.su.se', 'DSVPlay')->subject("[DSVPlay] Failed upload")
            ->view('emails.upload_failed');
    }
}
