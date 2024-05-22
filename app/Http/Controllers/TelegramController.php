<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TelegramController extends Controller
{
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
        Log::debug(json_encode($request->all()));

        if ($token !== env('TELEGRAM_BOT_TOKEN')) {
            return response()->json(['message' => 'INVALID_TOKEN'], Response::HTTP_BAD_REQUEST);
        }

        $chatId = $request->input('message.chat.id');
        $name = $request->input('message.chat.username');

        Subscriber::register($chatId, $name);

        return response()->json($request->all());
    }
}
