<?php

return [
    'language_updated' => 'Language updated successfully!',
    'welcome_back' => 'Welcome back, :name!',
    'create_new_listing' => 'Create New Listing',
    'show_my_listing' => 'Show My Listings',
    'manage_listing' => 'Manage Listings',
    'change_language' => 'Change Language',
    'buy' => 'Buy',
    'sell' => 'Sell',
    'done' => 'Done',
    'securely_connect_account' => 'Securely Connect Account',
    'welcome_connect_account' => 'Welcome! To get started, please connect your account securely.',
    'item_selected_set_price' => 'Item selected. Please set a price or press Done.',
    'enter_price_in_currency' => 'Please enter the price in :currency.',
    'invalid_price_input' => '⚠️ Invalid input. Please enter a positive numeric price.',
    'invalid_quantity_input' => '⚠️ Invalid quantity. Please enter a positive whole number.',
    'quantity_set_now_price' => 'Quantity set to :quantity. Now please set a price or press Done.',
    'price_set_current_prices' => 'Price set. Current prices: [:prices]. Set another or press Done.',
    'listing_created_success' => '✅ Success! Your listing has been created.',
    'no_items_found' => '⚠️ No items found matching \':search\'. Please try again.',
    'please_search_again' => 'Please enter the name of the item you\'re looking for.',
    'my_listings' => "You have :count listings:
:listings",

    // Fallback and help messages
    'unknown_command' => '❓ Unknown command ":command". Here are your available options:',
    'unknown_command_login_required' => '❓ Please connect your account first to use bot commands.',
    'no_active_conversation' => '💬 I received your message ":message", but you don\'t have an active conversation. Here\'s what you can do:',
    'unexpected_input' => '🤔 I didn\'t understand that input in this context.',
    'emergency_reset' => 'Something went wrong. I\'ve reset your session. Let\'s start fresh!',
    'conversation_cancelled' => '❌ Operation cancelled. You can start a new action from the menu below.',

    // Step-specific help messages
    'help_language_selection' => '🌐 Please use the buttons above to select your language.',
    'help_listing_type' => '📝 Please use the buttons above to choose Buy or Sell.',
    'help_item_selection' => '🎯 Please use the buttons above to select an item from the list.',
    'help_quantity' => '🔢 Please enter a positive whole number for the quantity.',
    'help_price_selection' => '💰 Please use the buttons above to set a price or click Done.',
    'help_general' => '💡 Please use the menu buttons or type /start for help.',
    'steps' => [
        'awaiting_language_selection' => 'Please select your preferred language.',
        'awaiting_listing_type' => 'Please choose whether you want to Buy or Sell.',
        'awaiting_item_name' => 'Please enter the name of the item.',
        'awaiting_item_selection' => 'Please select the correct item from the list below.',
        'awaiting_quantity' => 'Please enter the quantity of the item you want to list.',
        'awaiting_price' => 'Please set a price for your listing.',
        'awaiting_price_amount' => 'Please enter the amount.',
        'unknown_step' => 'Unknown step. Please restart the process.',
    ],

    // Authentication messages
    'auth' => [
        'success_title' => 'Authentication Successful!',
        'success_message' => 'Your Telegram account has been securely connected to Empires Market.',
        'success_description' => 'You can now close this window and return to your Telegram chat to start trading.',
        'failed_title' => 'Authentication Failed',
        'failed_description' => 'We encountered an issue while connecting your account. Please try again.',
        'security_notice' => 'Your security is our priority. All connections are encrypted and secure.',
        'return_to_telegram' => 'Return to Telegram',
        'try_again' => 'Try Again',
        'what_next' => 'What\'s Next?',
        'start_trading' => 'Start creating listings and trading items',
        'explore_market' => 'Explore the marketplace',
        'manage_account' => 'Manage your account settings',
    ],
];
