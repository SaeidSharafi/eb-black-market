<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum TelegramConversationStepEnum: string
{
    use AdvanceEnum;

    case AWAITING_LISTING_TYPE = 'awaiting_listing_type';
    case AWAITING_ITEM_NAME = 'awaiting_item_name';
    case AWAITING_ITEM_SELECTION = 'awaiting_item_selection';
    case AWAITING_PRICE = 'awaiting_price';
    case AWAITING_PRICE_AMOUNT = 'awaiting_price_amount';

    public function description(): string
    {
        return match ($this) {
            self::AWAITING_LISTING_TYPE => 'Please choose whether you want to Buy or Sell.',
            self::AWAITING_ITEM_NAME => 'Please enter the name of the item.',
            self::AWAITING_ITEM_SELECTION => 'Please select the correct item from the list below.',
            self::AWAITING_PRICE => 'Please set a price for your listing.',
            self::AWAITING_PRICE_AMOUNT => 'Please enter the amount.',
        };
    }
}
