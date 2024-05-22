<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Subscriber;
use App\Services\TelegramService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TelegramController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Webhook handler
     *
     * @param Request $request
     * @param string $token
     *
     * @return JsonResponse
     */
    public function webhook(Request $request, string $token): JsonResponse
    {
        if ($token !== env('TELEGRAM_BOT_TOKEN')) {
            return response()->json(['message' => 'INVALID_TOKEN'], Response::HTTP_BAD_REQUEST);
        }

        $chatId = $request->input('message.chat.id');
        $name = $request->input('message.chat.username');

        Subscriber::register($chatId, $name);

        return response()->json($request->all());
    }

    /**
     * Sending mail in telegram
     *
     * @throws Exception
     */
    public function send(Message $message)
    {
        $chatIds = Subscriber::getChatIds();

        $this->telegramService->send(
            $chatIds,
            $message->getMessage()
        );
    }
}
