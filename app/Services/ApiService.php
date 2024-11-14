<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private $apiKey;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey ?? env('OPENAI_API_KEY');
    }

    /**
     * Використовується для відправки запитів до API міст від нової пошти.
     */
    public function sendRequest($url, $data)
    {
        $data['apiKey'] = $this->apiKey;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * Покращення коментаря за допомогою ChatGPT.
     */
    public function beautifyComment($description)
    {
        // Дані для запиту
        $data = [
            'prompt' => "Напиши привабливий опис для товару на основі наступної інформації: $description. Зроби текст таким, щоб зацікавити покупця і переконати його зробити покупку.",
            'max_tokens' => 200,
            'temperature' => 0.8,
            'model' => 'gpt-3.5-turbo',
        ];
//        Log::info('API Key in constructor:', ['key' => $this->apiKey]);
//        Log::info('API Key from env:', ['key' => env('OPENAI_API_KEY')]);
//        Log::info($data);
//        Log::info('API Key:', ['key' => $this->apiKey]);
        try {
            // Оновлений запит з правильним заголовком Authorization: Bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey, // Перевірте правильність ключа
                'Content-Type' => 'application/json',
            ])
                ->post('https://api.openai.com/v1/completions', $data);

            // Логування відповіді OpenAI для налагодження
            \Log::info('OpenAI Response:', $response->json());

            if ($response->successful()) {
                $beautifiedDescription = trim($response->json()['choices'][0]['text']);
                return response()->json(['beautifiedDescription' => $beautifiedDescription]);
            }

            return response()->json(['error' => 'Не вдалося створити опис товару.'], $response->status());

        } catch (\Exception $e) {
            // Логування помилки сервера
            Log::info('API Key:', ['key' => $this->apiKey]);
            Log::error('Server Error:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Помилка сервера: ' . $e->getMessage()], 500);
        }
    }
}
