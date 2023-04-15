<?php

return [
    'url' =>  'https://api.openai.com/v1/completions',
    'key' => env('CHAT_GPT_TOKEN', null),
    'max_tokens' => env('CHAT_GPT_MAX_TORENS', 4000),
    'version' => env('CHAT_GPT_VERSION', 'gpt-3.5-turbo'),
    'locations' => [
        'controllers' => 'app/Http/Controllers/',
        'views' => 'resources/views/',
    ],
    'product_description_request' => [
        'en' => 'Make me description for product: ::product',
        'ru' => 'Сделай мне описание для продукта: ::product',
    ]
];
