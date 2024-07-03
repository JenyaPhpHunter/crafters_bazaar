<?php

namespace App\Services;

use GuzzleHttp\Client;

//    use App\Services\TelegramService;
// Приклад використання TelegramService
//$telegramService = new TelegramService(new \Telegram\Bot\Api('YOUR_TELEGRAM_BOT_TOKEN'));
//$telegramService->sendWelcomeMessage($chatId);
//Конфігурація: Зберігайте налаштування, такі як токен Telegram, в файлі конфігурації (config/services.php).


class TelegramService
{
    protected $token;
    protected $chatId;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage($message)
    {
        $client = new Client();
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $response = $client->post($url, [
            'json' => [
                'chat_id' => $this->chatId,
                'text' => $message,
            ],
        ]);

        return $response->getStatusCode() == 200;
    }
}
