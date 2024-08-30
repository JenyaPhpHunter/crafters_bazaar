<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function sendRequest($url, $data)
    {
        $data['apiKey'] = $this->apiKey;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function beautifyComment($comment)
    {
        // Відправлення запиту до API ChatGPT для покращення коментаря
        $response = Http::post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'prompt' => $comment,
            'max_tokens' => 150,
            'temperature' => 0.7,
            'model' => 'text-davinci-004',
            'api_key' => env('OPENAI_API_KEY'), // API ключ, збережений у .env файлі
        ]);

        // Перевірка чи запит успішний
        if ($response->successful()) {
            $beautifyComment = $response->json()['choices'][0]['text'];

            // Повернення покращеного коментаря
            return response()->json(['beautifyComment' => trim($beautifyComment)]);
        } else {
            return response()->json(['error' => 'Не вдалося покращити коментар.'], 500);
        }
    }
}
