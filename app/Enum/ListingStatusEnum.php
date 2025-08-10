<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum ListingStatusEnum: string
{
    use AdvanceEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    case SOLD = 'sold';

    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
            self::SOLD => 'danger',
        };
    }

}
