<?php

namespace App\Mail;

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
//        $imagePath = 'photos/20240212_172557_11.jpg';
        return $this->subject($this->titleEmail)
            ->view('emails.generic')
//            ->attach($imagePath, [                         // якщо потрібно вкласти файл
//                'as' => 'Example Image',
//                'mime' => 'image/jpeg',
//            ])
            ->with('content', $this->content);
    }
}

