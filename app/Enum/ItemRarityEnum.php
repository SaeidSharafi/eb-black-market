<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum ItemRarityEnum: string
{
    use AdvanceEnum;
    case COMMON = 'common';
    case UNCOMMON = 'uncommon';
    case RARE = 'rare';
    case EPIC = 'epic';
    case LEGENDARY = 'legendary';

    public function getRarityColor(): string
    {
        return match ($this) {
            self::COMMON => 'bg-gray-500',
            self::UNCOMMON => 'bg-green-400',
            self::RARE => 'bg-blue-400',
            self::EPIC => 'bg-purple-400',
            self::LEGENDARY => 'bg-orange-400',
        };
    }

}
