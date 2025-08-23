<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketListing extends Model
{

    use HasFactory;
    protected $fillable
        = [
            'item_id',
            'item_level',
            'user_id',
            'quantity',
            'quantity_per_bundle',
            'price',
            'status',
            'price_qrk',
            'price_not',
            'price_ton',
            'price_usd',
            'listing_type',
            'expired_notification_sent_at',
        ];

    protected $casts
        = [
            'item_id'             => 'integer',
            'user_id'             => 'integer',
            'quantity'            => 'integer',
            'quantity_per_bundle' => 'integer',
            'price'               => 'float',
        ];


    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
