<?php

namespace App\Http\Controllers;

use App\Services\TelegramConversationService;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request, TelegramConversationService $conversationService)
    {
        $update = Telegram::getWebhookUpdate();

        // --- THIS IS THE FIX ---
        // If the update is a button press (callback query)...
        if ($update->isType('callback_query')) {
            // ...answer it immediately before doing any other work.
            // This prevents the timeout error.
            try {
                Telegram::answerCallbackQuery([
                    'callback_query_id' => $update->getCallbackQuery()->getId(),
                ]);
            } catch (\Exception $e) {
                // Log the exception if it fails, but don't crash the entire request.
                // It might fail if the query was already answered or is truly invalid.
                \Illuminate\Support\Facades\Log::error('Failed to answer callback query: ' . $e->getMessage());
            }
        }

        // Pass the update as an array to our service.
        $conversationService->processUpdate($update->toArray());
        return response()->json(['status' => 'ok']);
    }
}
