<?php

namespace App\Models;

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
    ];

    public function marketListings(): HasMany
    {
        return $this->hasMany(MarketListing::class);
    }
}
