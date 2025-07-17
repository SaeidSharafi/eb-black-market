<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum ItemTypeEnum: string
{
    use AdvanceEnum;

    case EQUIPMENT = 'equipment';
    case CONSUMABLE = 'consumable';
    case RESOURCE = 'resource';
    case PART = 'part';
    case RECIPE = 'recipe';



}
