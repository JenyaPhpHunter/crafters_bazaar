<?php

namespace App\Mail;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRemovedFromBrandMail extends Mailable
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
        return $this->subject("Вас було видалено з бренду {$this->brand->title}")
            ->view('emails.user_removed_from_brand')
            ->with([
                'brand' => $this->brand,
                'user' => $this->user,
            ]);
    }
}
