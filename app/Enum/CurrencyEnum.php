<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum CurrencyEnum: string
{
    use AdvanceEnum;

    case TON = 'TON';
    case USDT = 'USDT';
    case QRK = 'QRK';
    case NOT = 'NOT';
}
