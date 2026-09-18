<?php

return [
    'api_key' => env('BACHS_API_KEY'),
    'base_url' => env('BACHS_BASE_URL', 'https://sandbox-api.bachs.io'),
    'webhook_secret' => env('BACHS_WEBHOOK_SECRET'),
    'webhook_tolerance' => env('BACHS_WEBHOOK_TOLERANCE', 300),
];
