<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

use Stripe\Checkout\Session;
use Stripe\Stripe;

Stripe::setApiKey($stripApiKey);

$checkout_session = Session::create([ 
    'line_items' => [[ 
      'price_data' => [ 
            'product_data' => [ 
                'name' => "Product Name", 
                'metadata' => [ 
                    'pro_id' => "Product ID" 
                ] 
            ], 
            'unit_amount' => 100*100, 
            'currency' => "INR", 
        ], 
        'quantity' => 1, 
        'description' => "Product Description", 
    ]], 
    'mode' => 'payment', 
    'success_url' => 'http://localhost/stripe/success.php?session_id={CHECKOUT_SESSION_ID}', 
    'cancel_url' => "http://localhost/stripe/?error_msg=Payment cancelled", 
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
