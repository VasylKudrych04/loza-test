<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Log;
use Throwable;

class TelegramService
{
    protected $telegramApiUrl;

    public function __construct()
    {
        $this->telegramApiUrl = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN');
    }

    /**
     * Sending messages in Telegram
     *
     * @param array $chatIds Array if chat IDs
     * @param string $message Message for mailing
     * @throws Exception
     */
    public function send(array $chatIds, string $message)
    {
        foreach ($chatIds as $chatId) {
            try {
                $this->post('/sendMessage', [
                    'chat_id' => $chatId,
                    'text' => $message,
                ]);
            } catch (Throwable $e) {
                Log::error("Error sending message to chat ID $chatId: " . $e->getMessage());
            }
        }
    }

    /**
     * @throws Exception|GuzzleException
     */
    protected function post($url, $data) {
        $client = new Client();
        $response = $client->post($this->telegramApiUrl . $url, ['json' => $data]);
        $responseEntity = json_decode($response->getBody()->getContents());

        if (empty($responseEntity->ok)) {
            throw new Exception('RESPONSE_STATUS_NOT_OK');
        }

        return $responseEntity;
    }
}
