<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Merchant ID (optional, kadang dibutuhkan untuk Core API)
    |--------------------------------------------------------------------------
    */
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key (untuk Snap di frontend)
    |--------------------------------------------------------------------------
    */
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key (untuk komunikasi server-to-server)
    |--------------------------------------------------------------------------
    */
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Environment: true = Production, false = Sandbox
    |--------------------------------------------------------------------------
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitize & 3DS (disarankan true)
    |--------------------------------------------------------------------------
    */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds'       => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | URL Snap.js (otomatis pilih berdasarkan environment)
    |--------------------------------------------------------------------------
    */
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

];