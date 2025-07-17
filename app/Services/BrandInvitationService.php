<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\BrandInvitation;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandInvitationService
{
    protected EmailService $emailService;
    protected BrandInvitationService $invitationService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function processInvitations(?string $invitedEmails, Brand $brand): void
    {
        if (empty($invitedEmails)) {
            return;
        }

        $emails = array_filter(array_map('trim', explode(',', $invitedEmails)));

        foreach ($emails as $email) {
            $invitation = BrandInvitation::firstOrNew([
                'brand_id' => $brand->id,
                'email' => $email,
            ]);

            if ($invitation->exists) {
                // Наприклад, обмеження по кількості повторних відправок, щоб не спамити
                if ($invitation->resent_count >= 5) {
                    continue; // Пропускаємо, більше 5 разів не відсилаємо
                }
                $invitation->resent_count++;
            } else {
                $invitation->invited_by = auth()->id();
                $invitation->resent_count = 0;
            }

            $invitation->last_sent_at = now();
            $invitation->save();

            $this->emailService->sendBrandInvitationEmail($brand, $email);
        }
    }

    public function acceptInvitation(Request $request, Brand $brand)
    {
        if ($brand->trashed()) {
            return redirect()->route('brands.index')->with('error', 'Цей бренд вже видалено.');
        }

        if (!auth()->check()) {
            return redirect()->route('login-register')->with('info', 'Будь ласка, увійдіть, щоб приєднатися до бренду.');
        }

        $email = $request->query('email');

        return $this->handleJoinBrandByEmail($brand, $email);
    }

    public function join(Brand $brand)
    {
        if ($brand->trashed()) {
            return redirect()->route('brands.index')->with('error', 'Цей бренд вже видалено.');
        }

        if (!auth()->check()) {
            return redirect()->route('login-register')->with('info', 'Будь ласка, увійдіть, щоб приєднатися до бренду.');
        }

        $email = auth()->user()->email;

        return $this->handleJoinBrandByEmail($brand, $email);
    }

    private function handleJoinBrandByEmail(Brand $brand, string $email)
    {
        $email = urldecode($email);
        $invitation = $brand->invitations()->where('email', $email)->first();

        if (!$invitation) {
            return redirect()->route('brands.index')->with('error', 'Це запрошення не дійсне або було скасовано.');
        }

        if (strcasecmp(auth()->user()->email, $email) !== 0) {
            return redirect()->route('brands.index')->with('error', 'Це запрошення не для вашого акаунта.');
        }

        $this->joinUserToBrand($brand, auth()->user(), $invitation);

        return redirect()->route('brands.show', $brand)->with('success', 'Ви приєдналися до бренду!');
    }

    private function joinUserToBrand(Brand $brand, User $user, ?BrandInvitation $invitation = null): void
    {
        if (!$brand->users()->where('user_id', $user->id)->exists()) {
            $brand->users()->attach($user->id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if ($invitation && !$invitation->accepted_at) {
            $invitation->accepted_at = now();
            $invitation->save();
        }

        try {
            $this->emailService->notifyOwnerUserJoined($brand, $user);
        } catch (\Throwable $e) {
            Log::error('Помилка при відправці листа: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }


    public function leave(Brand $brand)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Увійдіть, щоб покинути бренд.');
        }

        if ($user->id == $brand->creator->id) {
            return redirect()->route('brands.show', $brand)->with('info', 'Ви не можете покинути бренд, але Ви можете його видалити');
        }

        if ($brand->users->contains($user->id)) {
            // 1. Видалити з pivot-таблиці
            $brand->users()->detach($user->id);

            // 2. Видалити запрошення за email (якщо було)
            $brand->invitations()
                ->where('email', $user->email)
                ->delete();

            try {
                $this->emailService->notifyOwnerUserLeft($brand, $user);
            } catch (\Throwable $e) {
                Log::error('Помилка при відправці листа про вихід користувача: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            return redirect()->route('brands.index')->with('success', 'Ви покинули бренд.');
        }

        return redirect()->route('brands.show', $brand)->with('error', 'Ви не є учасником цього бренду.');
    }

    public function removeUserFromBrand(Brand $brand, User $user): void
    {
        // Видалити з pivot
        $brand->users()->detach($user->id);

        // Надіслати лист
        try {
            $this->emailService->notifyUserRemovedFromBrand($brand, $user);
        } catch (\Throwable $e) {
            Log::error('Помилка при надсиланні листа про видалення користувача з бренду: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Видалити пов’язане запрошення (якщо є)
        $brand->invitations()->where('email', $user->email)->delete();
    }
    public function cancelInvitation(Brand $brand, BrandInvitation $invitation): void
    {
        $email = $invitation->email;

        $invitation->delete();

        try {
            $this->emailService->notifyInvitationCancelled($brand, $email);
        } catch (\Throwable $e) {
            Log::error('Помилка при надсиланні листа про скасування запрошення: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

}
