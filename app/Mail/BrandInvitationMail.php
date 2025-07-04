<?php

namespace App\Mail;

use App\Models\Brand;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BrandInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Brand $brand;
    public string $email;

    public function __construct(Brand $brand, string $email)
    {
        $this->brand = $brand;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Запрошення до бренду')
            ->view('emails.brand_invitation');
    }
}
