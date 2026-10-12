<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Manual Payment — Kost Bank Details
    |--------------------------------------------------------------------------
    |
    | Dummy bank account shown to customers for the manual bank-transfer
    | payment flow. Fallback values are provided so the config works even
    | when the KOST_BANK_* keys are not present in .env.
    |
    */

    'bank' => [
        'name' => env('KOST_BANK_NAME', 'Bank Central Asia (BCA)'),
        'account_number' => env('KOST_BANK_ACCOUNT_NUMBER', '1234567890'),
        'account_holder' => env('KOST_BANK_ACCOUNT_HOLDER', 'Arca Kost Dummy'),
    ],

];
