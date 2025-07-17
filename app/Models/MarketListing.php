<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketListing extends Model
{

    use HasFactory;
    protected $fillable
        = [
            'item_id',
            'user_id',
            'quantity',
            'quintity_per_bundle',
            'price',
            'status',
            'price_qrk',
            'price_not',
            'price_ton',
            'price_usd',
        ];

    protected $casts
        = [
            'item_id'             => 'integer',
            'user_id'             => 'integer',
            'quantity'            => 'integer',
            'quintity_per_bundle' => 'integer',
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
