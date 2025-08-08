<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum ItemTypeEnum: string
{
    use AdvanceEnum;

    case WEAPON = 'weapon';
    case PANTS = 'pants';
    case GLOVES = 'gloves';
    case BODY = 'body';
    case HELMET = 'helmet';
    case BOOTS = 'boots';
    case AMPILIER = 'amplifier';
    case ACCESSORY = 'accessory';


    case CONSUMABLE = 'consumable';
    case RESOURCE = 'resource';
    case PART = 'part';
    case RECIPE = 'recipe';



}
