<?php

namespace App\Models;

use App\Enum\TelegramConversationStepEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramConversation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'step' => TelegramConversationStepEnum::class, // Automatically cast to and from the Enum
        'data' => 'array', // Automatically serialize/deserialize JSON
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
