<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $chatId = $request->input('message.chat.id');
        $name = $request->input('message.chat.username');

        Subscriber::create($chatId, $name);
    }
}
