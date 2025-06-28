<?php

namespace Чернетка;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $titleEmail;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titleEmail, $content)
    {
        $this->titleEmail = $titleEmail;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->titleEmail)
            ->view('emails.generic')
            ->text('emails.generic_plain') // plain-text версія
            ->with('content', $this->content);
    }
}

