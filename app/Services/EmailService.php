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

    public function sendPutUpForSaleEmail($product)
    {
        $titleEmail = 'Ваш товар виставлено на продаж';
            $content = "
            <h1 style=\"color: blue;\">Ваш товар виставлено на продаж!</h1>

            <p>Код товару: {$product->id}</p>
            <p>Посилання: <a href=\"http://crafters_bazaar.loc/products/{$product->id}/edit\">http://crafters_bazaar.loc/products/{$product->id}</a></p>
            <p style=\"font-style: italic; color: green;\">Ваш менеджер </p>
            <p style=\"font-style: italic; color: green;\">Маємо надію, що Ваш товар скоро придбають)</p>
        ";
        $this->sendEmail($product->user->email, $titleEmail, $content);
    }

    public function sendProductForSaleEmail($product)
    {
        $adminSellerEmail = $this->choiceRandomAdminEmail();
        $titleEmail = 'Товар запропоновано на продаж';
        $baseUrl = config('app.url'); // отримуємо базовий URL з конфігурації
        $content = "
        <h1 style=\"color: blue;\">Товар запропоновано на продаж!</h1>

        <p>Код товару: {$product->id}</p>
        <p>Посилання: <a href=\"{$baseUrl}/products/{$product->id}/edit\">{$baseUrl}/products/{$product->id}/edit</a></p>
        <p style=\"font-style: italic; color: green;\">Перевірте та відправте товар на продаж</p>
        ";

        $this->sendEmail($adminSellerEmail, $titleEmail, $content);
    }

    public function sendApproveKindSubkind($kind_product, $sub_kind_product, $product_id = null)
    {
        $baseUrl = config('app.url'); // отримуємо базовий URL з конфігурації
        $adminSellerEmail = $this->choiceRandomAdminEmail();
        if (!$kind_product->checked && !$sub_kind_product->checked) {
            $titleEmail = 'Додано новий вид та підвид товару';
            $content = "
                <h1 style=\"color: blue;\">Додано новий вид та підвид товару!</h1>
                <p>Посилання на новостворений вид товару:
                <a href=\"{$baseUrl}/admin/admin_kind_products/{$kind_product->id}/edit\">
                {$baseUrl}/admin/admin_kind_products/{$kind_product->id}/edit</a>
                </p>
                <p>Посилання на новостворений підвид товару:
                <a href=\"{$baseUrl}/admin/admin_sub_kind_products/{$sub_kind_product->id}/edit\">
                {$baseUrl}/admin/admin_sub_kind_products/{$sub_kind_product->id}/edit</a>
                </p>
            ";
        } elseif (!$kind_product->checked) {
            $titleEmail = 'Додано новий вид товару';
            $content = "<h1 style=\"color: blue;\">Додано новий вид товару!</h1>
                <p>Посилання на новостворений вид товару:
                <a href=\"{$baseUrl}/admin/admin_kind_products/{$kind_product->id}/edit\">
                {$baseUrl}/admin/admin_kind_products/{$kind_product->id}/edit</a>
                </p>
                ";
        } elseif (!$sub_kind_product->checked) {
            $titleEmail = 'Додано новий підвид товару';
            $content = "<h1 style=\"color: blue;\">Додано новий підвид товару!</h1>
                <p>Посилання на новостворений підвид товару:
                <a href=\"{$baseUrl}/admin/admin_sub_kind_products/{$sub_kind_product->id}/edit\">
                {$baseUrl}/admin/admin_sub_kind_products/{$sub_kind_product->id}/edit</a>
                </p>
                ";
        }

        $content .= "
            <p>Код товару в якому створили вид або підвид: {$product_id}</p>
            <p>Посилання на товар в якому створили вид або підвид: <a href=\"{$baseUrl}/products/{$product_id}/edit\">{$baseUrl}/products/{$product_id}/edit</a></p>
        ";
//        echo "<pre>";
//        print_r($adminSellerEmail);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($titleEmail);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($content);
//        echo "</pre>";
//        die();
        $this->sendEmail($adminSellerEmail, $titleEmail, $content);
    }

    public function choiceRandomAdminEmail()
    {
//        $adminSeller = User::where('role_id', '=',  4)->inRandomOrder()->first();
        $adminSeller = User::where('role_id', '=',  1)->inRandomOrder()->first();

        return $adminSeller->email;
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
