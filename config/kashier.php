<?php
// config/kashier.php

return [
    'merchant_id' => env('KASHIER_MERCHANT_ID'),
    'secret_key'  => env('KASHIER_SECRET_KEY'),
    'mode'        => env('KASHIER_MODE', 'test'), // test | live
    'currency'    => env('KASHIER_CURRENCY', 'EGP'),
];
