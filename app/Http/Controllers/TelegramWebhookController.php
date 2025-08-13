<?php

namespace App\Http\Controllers;

use App\Services\TelegramConversationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request, TelegramConversationService $conversationService)
    {
        try {
            // Validate webhook payload
            if (!$request->has('update_id')) {
                Log::warning('Invalid webhook payload - missing update_id', [
                    'request_body' => $request->getContent(),
                    'ip' => $request->ip()
                ]);
                return response()->json(['status' => 'ok']); // Still return 200 to prevent retries
            }

            $update = Telegram::getWebhookUpdate();

            // Answer callback queries immediately to prevent timeout errors
            if ($update->isType('callback_query')) {
                try {
                    Telegram::answerCallbackQuery([
                        'callback_query_id' => $update->getCallbackQuery()->getId(),
                    ]);
                } catch (Throwable $e) {
                    // Log the exception if it fails, but don't crash the entire request.
                    // It might fail if the query was already answered or is truly invalid.
                    Log::warning('Failed to answer callback query: ' . $e->getMessage(), [
                        'callback_query_id' => $update->getCallbackQuery()->getId(),
                        'exception' => $e
                    ]);
                }
            }

            // Pass the update as an array to our service.
            $conversationService->processUpdate($update->toArray());

            return response()->json(['status' => 'ok']);
        } catch (Throwable $e) {
            // Log the error but return success to prevent Telegram from retrying
            Log::error('Telegram webhook error: ' . $e->getMessage(), [
                'request_body' => $request->getContent(),
                'headers' => $request->headers->all(),
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            // Always return 200 OK to prevent Telegram from retrying the webhook
            // Telegram will retry failed webhooks which can cause spam
            return response()->json(['status' => 'error', 'message' => 'Internal error'], 200);
        }
    }
}
