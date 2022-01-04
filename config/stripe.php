<?php
return [
    'stripe_key' => env('STRIPE_KEY'),

    'stripe_secret' => env('STRIPE_SECRET'),

    'currency' => 'usd',

    'off_session' => true,

    'confirm' => true, 

    'capture_method' => 'manual'
];
