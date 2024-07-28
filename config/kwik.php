<?php

return [
    'base' => [
        'url' => env('KWIK_API_BASE_URL', 'https://staging-api-test.kwik.delivery/')
    ],

    'domain'=>[
        'name' => env('KWIK_DOMAIN_NAME', 'staging-client-panel.kwik.delivery')
    ],

    'access' => [
        'token' => env('KWIK_ACCESS_TOKEN', ''),
    ],

    'app' => [
        'access' => [
            'token' => env('KWIK_APP_ACCESS_TOKEN', ''),
        ],
    ],

    'is_vendor' => env('KWIK_IS_VENDOR', true),
    'email' =>  env('KWIK_EMAIL', 'vendor@email.domain'),
    'password' =>  env('KWIK_PASSWORD', 'password')
  
];