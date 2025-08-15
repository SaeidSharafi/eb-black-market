<?php

namespace App\Enum;

enum CallbackQueryActionEnum: string
{
    case SET_LANGUAGE = 'set_language';
    case SET_LISTING_TYPE = 'set_listing_type';
    case SELECT_ITEM = 'select_item';
    case SET_PRICE_CURRENCY = 'set_price_currency';
    case FINALIZE_LISTING = 'finalize_listing';
    case EXECUTE_COMMAND = 'execute_command';
    case CONFIRM_NATURAL_LISTINGS = 'confirm_natural_listings';
    case RETRY_NATURAL_LISTINGS = 'retry_natural_listings';
}
