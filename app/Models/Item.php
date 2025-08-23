<?php

namespace App\Models;

use App\Enum\ItemRarityEnum;
use App\Enum\ItemTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasTranslations;

    protected $guarded =[];
    public array $translatable = ['name'];

    protected $casts = [
        'last_listed_at' => 'datetime',
        'rarity' => ItemRarityEnum::class,
        'type' => ItemTypeEnum::class
    ];

    public function marketListings(): HasMany
    {
        return $this->hasMany(MarketListing::class);
    }
}
