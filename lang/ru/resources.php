<?php
return [
    'items' => [
        'navigation' => 'Товары',
        'label' => 'Товар',
        'plural_label' => 'Товары',
        'title' => 'Товары',
        'fields' => [
            'name' => 'Название',
            'type' => 'Тип',
            'image' => 'Изображение',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
        ],
    ],
    'market_listings' => [
        'navigation' => 'Объявления',
        'label' => 'Объявление',
        'plural_label' => 'Объявления',
        'title' => 'Объявления',
        'fields' => [
            'item' => 'Товар',
            'item_name' => 'Название товара',
            'seller' => 'Продавец',
            'telegram' => 'Телеграм',
            'quantity' => 'Количество',
            'quantity_per_bundle' => 'Кол-во в упаковке',
            'image' => 'Изображение',
            'price_qrk' => 'Цена QRK',
            'price_not' => 'Цена NOT',
            'price_ton' => 'Цена TON',
            'price_usd' => 'Цена USDT',
            'status' => 'Статус',
        ],
        'status' => [
            'active' => 'Активно',
            'inactive' => 'Неактивно',
            'sold' => 'Продано',
        ],
        'sections' => [
            'prices' => 'Цены',
            'prices_description' => 'Установите цены для каждой валюты',
        ],
    ],
];

