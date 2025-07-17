<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum ListinStatusEnum: string
{
    use AdvanceEnum;
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
