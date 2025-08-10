<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum ListingTypeEnum: string
{
    use AdvanceEnum;
    case SELL = 'sell';
    case BUY = 'buy';

}
