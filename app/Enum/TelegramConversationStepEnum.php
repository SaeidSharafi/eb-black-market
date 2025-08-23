<?php

namespace App\Enum;

use App\Traits\AdvanceEnum;

enum TelegramConversationStepEnum: string
{
    use AdvanceEnum;

    case AWAITING_LANGUAGE_SELECTION = 'awaiting_language_selection';
    case AWAITING_LISTING_TYPE = 'awaiting_listing_type';
    case AWAITING_ITEM_NAME = 'awaiting_item_name';
    case AWAITING_ITEM_SELECTION = 'awaiting_item_selection';
    case AWAITING_ITEM_LEVEL = 'awaiting_item_level';
    case AWAITING_QUANTITY = 'awaiting_quantity';
    case AWAITING_PRICE = 'awaiting_price';
    case AWAITING_PRICE_AMOUNT = 'awaiting_price_amount';

    public function description(): string
    {
        return match ($this) {
            self::AWAITING_LANGUAGE_SELECTION => __('telegram.steps.awaiting_language_selection'),
            self::AWAITING_LISTING_TYPE => __('telegram.steps.awaiting_listing_type'),
            self::AWAITING_ITEM_NAME => __('telegram.steps.awaiting_item_name'),
            self::AWAITING_ITEM_SELECTION => __('telegram.steps.awaiting_item_selection'),
            self::AWAITING_ITEM_LEVEL => __('telegram.steps.awaiting_item_level'),
            self::AWAITING_QUANTITY => __('telegram.steps.awaiting_quantity'),
            self::AWAITING_PRICE => __('telegram.steps.awaiting_price'),
            self::AWAITING_PRICE_AMOUNT => __('telegram.steps.awaiting_price_amount'),
            default => __('telegram.steps.unknown_step'),
        };
    }
}
