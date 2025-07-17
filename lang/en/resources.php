<?php
return [
    'items' => [
        'navigation' => 'Items',
        'label' => 'Item',
        'plural_label' => 'Items',
        'title' => 'Items',
        'fields' => [
            'name' => 'Name',
            'type' => 'Type',
            'image' => 'Image',
            'description' => 'Description',
            'created_at' => 'Created At',
        ],
    ],
    'market_listings' => [
        'navigation' => 'Market Listings',
        'label' => 'Market Listing',
        'plural_label' => 'Market Listings',
        'title' => 'Market Listings',
        'fields' => [
            'item' => 'Item',
            'item_name' => 'Item Name',
            'seller' => 'Seller',
            'telegram' => 'Telegram',
            'quantity' => 'Quantity',
            'quantity_per_bundle' => 'Quantity per Bundle',
            'image' => 'Image',
            'price_qrk' => 'Price QRK',
            'price_not' => 'Price NOT',
            'price_ton' => 'Price TON',
            'price_usd' => 'Price USDT',
            'status' => 'Status',
        ],
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'sold' => 'Sold',
        ],
        'sections' => [
            'prices' => 'Prices',
            'prices_description' => 'Set prices for each currency',
        ],
    ],
];

