<?php

return [

    'key' => env('CHAT_GPT_TOKEN', null),

    'max_tokens' => env('CHAT_GPT_MAX_TORENS', 4000),
    'version' => env('CHAT_GPT_VERSION', 'gpt-3.5-turbo'),
];
