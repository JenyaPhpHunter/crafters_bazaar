<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\GenericMail;

class EmailService
{
//    use App\Services\EmailService;
    // Приклад використання EmailService
//$emailService = new EmailService();
//$emailService->sendWelcomeEmail($email);
    /**
     * Відправка електронного листа.
     *
     * @param string $email
     * @param string $titleEmail
     * @param string $content
     * @return void
     */
    public function sendEmail($email, $titleEmail, $content)
    {
        Mail::to($email)->send(new GenericMail($titleEmail, $content));
    }

    /**
     * Відправка вітального листа.
     *
     * @param string $email
     * @return void
     */
    public function sendWelcomeEmail($email, $password = NULL)
    {
        $titleEmail = 'Вітаємо вас в нашому магазині';
        if ($password){
            $content = "
            <h1 style=\"color: blue;\">Дякуємо, що приєдналися до нас!</h1>
            <p>Ваш логін: {$email}</p>
            <p>Ваш пароль: {$password}</p>
            <p style=\"font-style: italic; color: green;\">Сподіваємось, ви насолоджуєтесь нашими послугами!</p>
        ";
        } else {
            $content = 'Дякую, що приєдналися до нас!';
        }
        $this->sendEmail($email, $titleEmail, $content);
    }



    /**
     * Відправка листа для скидання пароля.
     *
     * @param string $email
     * @param string $token
     * @return void
     */
//    public function sendPasswordResetEmail($email, $token)
//    {
//        $titleEmail = 'Password Reset';
//        $content = 'To reset your password, please click the link: ' . url('password/reset', $token);
//        $this->sendEmail($email, $titleEmail, $content);
//    }
}
