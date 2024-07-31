<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericMail;

class EmailService
{
//    protected $userService;
//
//    public function __construct(UserService $userService)
//    {
//        $this->userService = $userService;
//    }
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

    public function sendPutUpForSaleEmail($email, $product)
    {
        $titleEmail = 'Ваш товар виставлено на продаж';
            $content = "
            <h1 style=\"color: blue;\">Ваш товар виставлено на продаж!</h1>

            <p>Код товару: {$product->id}</p>
            <p>Посилання: <a href=\"http://crafters_bazaar.loc/products/{$product->id}/edit\">http://crafters_bazaar.loc/products/{$product->id}/edit</a></p>
            <p style=\"font-style: italic; color: green;\">Ваш менеджер </p>
            <p style=\"font-style: italic; color: green;\">Маємо надію, що Ваш товар скоро придбають)</p>
        ";

        $product->date_approve_sale = date('Y-m-d H:i:s');
        $product->save();

        $this->sendEmail($email, $titleEmail, $content);
    }

    public function sendProductForSaleEmail($product)
    {
//        echo "<pre>";
//        print_r($admin->email);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($titleEmail);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($product->id);
//        echo "</pre>";
//        die();
        $titleEmail = 'Товар запропоновано на продаж';
        $content = "
            <h1 style=\"color: blue;\">Товар запропоновано на продаж!</h1>

            <p>Код товару: {$product->id}</p>
            <p>Посилання: <a href=\"http://crafters_bazaar.loc/products/{$product->id}/edit\">http://crafters_bazaar.loc/products/{$product->id}/edit</a></p>
            <p style=\"font-style: italic; color: green;\">Перевірте та відправте товар на продаж</p>
        ";

        $admin = $this->choiceSellerAdmin();
        $product->admin_id = $admin->id;
        $product->date_put_up_for_sale = date('Y-m-d H:i:s');
        $product->save();

        $this->sendEmail($admin->email, $titleEmail, $content);
    }

    public function choiceSellerAdmin()
    {
        $seller_admin = User::where('role_id', 3)->inRandomOrder()->first();

        return $seller_admin;
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
