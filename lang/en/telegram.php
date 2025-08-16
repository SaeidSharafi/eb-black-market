<?php

return [
    'language_updated'               => 'Language updated successfully!',
    'welcom_guest'                  => 'Welcome! Please visit our website to connect your account.',
    'welcome_back'                   => 'Welcome back, :name!',
    'welcome_back_help' => 'Here\'s how you can get started:
- *Create a New Listing*: Tap the "*Create New Listing*" button below to begin a guided process.
- *Manage Existing Listings*: Use the "*Manage Listings*" button to view and edit your current items.
- *Quick Sell: For a faster experience*, you can create a listing by sending a message directly in this chat. For example, you can type: `sell item x10 1ton`

*Important*: If you intend to use the quick sell feature with natural language, please do not use the "Create New Listing" button.

For a full list of commands and more detailed information, please use the /help command.
',
    'create_new_listing'             => 'Create New Listing',
    'show_my_listing'                => 'Show My Listings',
    'manage_listing'                 => 'Manage Listings',
    'change_language'                => 'Change Language',
    'buy'                            => 'Buy',
    'sell'                           => 'Sell',
    'done'                           => 'Done',
    'securely_connect_account'       => 'Securely Connect Account',
    'welcome_connect_account'        => 'Welcome! To get started, please connect your account securely.',
    'item_selected_set_price'        => 'Item selected. Please set a price or press Done.',
    'enter_price_in_currency'        => 'Please enter the price in :currency.',
    'invalid_price_input'            => '⚠️ Invalid input. Please enter a positive numeric price.',
    'invalid_quantity_input'         => '⚠️ Invalid quantity. Please enter a positive whole number.',
    'quantity_set_now_price'         => 'Quantity set to :quantity. Now please set a price or press Done.',
    'price_set_current_prices'       => 'Price set. Current prices: [:prices]. Set another or press Done.',
    'listing_created_success'        => '✅ Success! Your listing has been created.',
    'no_items_found'                 => '⚠️ No items found matching \':search\'. Please try again.',
    'please_search_again'            => 'Please enter the name of the item you\'re looking for.',
    'my_listings'                    => "You have :count listings:
:listings",

    // Natural language listing messages
    'could_not_parse_listing'        => '⚠️ I couldn\'t understand your listing format.',
    'listing_format_example'         => '📝 Try these formats:

*Single item (default quantity = 1):*
sell Ritti 1 TON
sell Lamp 1 TON 300 QRK 400 NOT
buy Digger\'s Boots 50 QRK

*With explicit quantity:*
sell Iron bracket 5x 100 TON
sell Copper bracket x3 200 TON
buy Healing Potion 10x 50 QRK

*List format:*
selling:
Ritti 1 TON
Iron bracket 5x 100 TON
Copper bracket x3 200 TON
Healing Potion 10x 50 QRK

*💡 Tips:*
• Use "x" for quantities: 5x, x5, 5шт
• For items with numbers, be explicit: "Iron Sword 1000" 5x 100 TON
• Default quantity is 1 if not specified',
    'parsed_listings_confirmation'   => '✅ I found these listings:',
    'listings_creation_summary'      => '📊 Created :created listings successfully. :failed failed.',
    'failed_items'                   => '❌ Failed items',
    'natural_listing_tip'            => '💡 Tip: You can also create listings naturally by typing something like:
"sell Iron Sword 5x 100 TON" or "buy Magic Potion - 10 - 50 QRK"',
    'help_message'                   => '🤖 Empire Market Bot Help

You can use this bot in two ways:

1️⃣ *Wizard Mode*: Use /newlisting for step-by-step listing creation
2️⃣ *Natural Language*: Type your listings directly',

    // Natural language confirmation flow
    'natural_listings_preview'       => '🔍 *Listing Preview*

Please review the parsed listings below:',
    'item_not_found'                 => '(item not found)',
    'natural_listings_summary'       => '📊 *Summary*: :valid valid, :invalid invalid, :total total',
    'confirm_create_listings'        => 'Create :count Listings',
    'try_again'                      => 'Try Again',
    'cancel'                         => 'Cancel',
    'session_expired_retry'          => 'Session expired. Please send your listings again.',
    'no_valid_listings'              => 'No valid listings found. Please try again with correct item names.',
    'retry_natural_listings_help'    => '📝 Please send your listings again. Make sure to use the correct format:

*Examples:*
sell Iron Sword 100 TON
buy Magic Potion 5x 50 QRK

*List format:*
selling:
Iron Sword 100 TON
Magic Shield 200 TON',

    // Fallback and help messages
    'unknown_command'                => '❓ Unknown command ":command". Here are your available options:',
    'unknown_command_login_required' => '❓ Please connect your account first to use bot commands.',
    'no_active_conversation'         => '💬 I received your message ":message", but you don\'t have an active conversation. Here\'s what you can do:',
    'unexpected_input'               => '🤔 I didn\'t understand that input in this context.',
    'emergency_reset'                => 'Something went wrong. I\'ve reset your session. Let\'s start fresh!',
    'conversation_cancelled'         => '❌ Operation cancelled. You can start a new action from the menu below.',

    // Step-specific help messages
    'help_language_selection'        => '🌐 Please use the buttons above to select your language.',
    'help_listing_type'              => '📝 Please use the buttons above to choose Buy or Sell.',
    'help_item_selection'            => '🎯 Please use the buttons above to select an item from the list.',
    'help_quantity'                  => '🔢 Please enter a positive whole number for the quantity.',
    'help_price_selection'           => '💰 Please use the buttons above to set a price or click Done.',
    'help_general'                   => '💡 Please use the menu buttons or type /start for help.',
    'steps'                          => [
        'awaiting_language_selection' => 'Please select your preferred language.',
        'awaiting_listing_type'       => 'Please choose whether you want to Buy or Sell.',
        'awaiting_item_name'          => 'Please enter the name of the item.',
        'awaiting_item_selection'     => 'Please select the correct item from the list below.',
        'awaiting_quantity'           => 'Please enter the quantity of the item you want to list.',
        'awaiting_price'              => 'Please set a price for your listing.',
        'awaiting_price_amount'       => 'Please enter the amount.',
        'unknown_step'                => 'Unknown step. Please restart the process.',
    ],

    // Authentication messages
    'auth'                           => [
        'success_title'       => 'Authentication Successful!',
        'success_message'     => 'Your Telegram account has been securely connected to Empires Market.',
        'success_description' => 'You can now close this window and return to your Telegram chat to start trading.',
        'failed_title'        => 'Authentication Failed',
        'failed_description'  => 'We encountered an issue while connecting your account. Please try again.',
        'security_notice'     => 'Your security is our priority. All connections are encrypted and secure.',
        'return_to_telegram'  => 'Return to Telegram',
        'try_again'           => 'Try Again',
        'what_next'           => 'What\'s Next?',
        'start_trading'       => 'Start creating listings and trading items',
        'explore_market'      => 'Explore the marketplace',
        'manage_account'      => 'Manage your account settings',
    ],
];
