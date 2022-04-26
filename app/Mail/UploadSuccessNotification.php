<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UploadSuccessNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $presentation;
    public $title_array = [], $title_swedish, $title_english;

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
        return $this->from('play@dsv.su.se', 'DSVPlay')->subject("[DSVPlay] Upload success")
            ->view('emails.upload_success');
    }
}
