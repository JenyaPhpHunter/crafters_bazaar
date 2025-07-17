<?php

namespace App\Mail;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserJoinedBrandMail extends Mailable
{
    use Queueable, SerializesModels;

    public Brand $brand;
    public User $user;

    public function __construct(Brand $brand, User $user)
    {
        $this->brand = $brand;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject("Новий користувач {$this->user->getFullName()} приєднався до вашого бренду")
            ->view('emails.user_joined_brand')
            ->with([
                'brand' => $this->brand,
                'user' => $this->user,
            ]);

    }
}
