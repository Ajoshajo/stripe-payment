<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

if (!empty($_GET['session_id'])) {
    $session_id = $_GET['session_id'];

    Stripe::setApiKey($stripApiKey);

    try {
        $checkout_session = Session::retrieve($session_id);
    } catch (Exception $e) {
        $api_error = $e->getMessage();
    }

    if (empty($api_error) && $checkout_session) {
        try {
            $paymentIntent = PaymentIntent::retrieve($checkout_session->payment_intent);
        } catch (ApiErrorException $e) {
            $api_error = $e->getMessage();
        }

        try {
            $customer = \Stripe\Customer::retrieve($checkout_session->customer);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $paymentIntent) {

            $transactionID = $paymentIntent->id;
            $paidAmount = $paymentIntent->amount;
            $paidAmount = ($paidAmount / 100);
            $paidCurrency = $paymentIntent->currency;
            $payment_status = $paymentIntent->status;
            $customer_name = $customer_email = '';
            if (!empty($customer)) {
                $customer_name = !empty($customer->name) ? $customer->name : '';
                $customer_email = !empty($customer->email) ? $customer->email : '';
            }
            ?>
                <h1>Payment Success</h1>

                <h4>Payment Information</h4>
                <p><b>Reference Number:</b> <?php echo $payment_id; ?></p>
                <p><b>Transaction ID:</b> <?php echo $transactionID; ?></p>
                <p><b>Paid Amount:</b> <?php echo $paidAmount . ' ' . $paidCurrency; ?></p>
                <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>

            <?php
} else {
            header("HTTP/1.1 303 See Other");
            header("Location: http://localhost/stripe/?error_msg=" . $api_error);
        }
    } else {
        header("HTTP/1.1 303 See Other");
        header("Location: http://localhost/stripe/?error_msg=" . $api_error);
    }
}
