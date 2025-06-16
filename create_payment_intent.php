<?php
require 'vendor/autoload.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['login_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'not_logged_in']);
    exit();
}

\Stripe\Stripe::setApiKey('sk_test_51NRfsYIxw1u7K45rcMj8m1o1ctnvAkWMyNCHR1uVQZgaaiQJlpaSjV8OIDi1eyJr16JpSg5kXVHkHMJhutr4TXxy009YXOQLR0');

$user_id = $_SESSION['login_id'];
$data = json_decode(file_get_contents('php://input'), true);
$plan = $data['plan'];
$name = $data['name'];
$email = $data['email'];
$address = $data['address'];
$dedicatedIp = $data['dedicatedIp'];
$dedicatedIpCity = $data['dedicatedIpCity'];
$dedicatedIpCountry = $data['dedicatedIpCountry'];

$amount = 0;
$description = '';
$expire_date = '';

switch ($plan) {
    case 'standard_monthly':
        $amount = 1295; // $12.95 per month
        $description = 'Standard Plan (Monthly)';
        $duration = 1;
        $expire_date = date('Y-m-d', strtotime('+1 month'));
        break;
    case 'standard_halfyear':
        $amount = 5994; // $9.99 per month * 6 months
        $description = 'Standard Plan (Half-Yearly)';
        $duration = 6;
        $expire_date = date('Y-m-d', strtotime('+6 months'));
        break;
    case 'premium_yearly':
        $amount = 8004; // $6.67 per month * 12 months
        $description = 'Premium Plan (Yearly)';
        $duration = 12;
        $expire_date = date('Y-m-d', strtotime('+1 year'));
        break;
    default:
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid plan selected']);
        exit();
}

$errors = [];
if ($dedicatedIp === true) {
    if (empty($dedicatedIpCity)) {
        $errors[] = 'City is required for dedicated IP.';
    }
    if (empty($dedicatedIpCountry)) {
        $errors[] = 'Country is required for dedicated IP.';
    }
}

if (!empty($errors)) {
    echo json_encode(['error' => implode(' ', $errors)]);
    exit();
}

$dedicatedIpChargePerMonth = 419;
$dedicatedIpTotalCharge = $dedicatedIpChargePerMonth * $duration;
if ($dedicatedIp) {
    $amount += $dedicatedIpTotalCharge;
    $description .= ' + Dedicated IP';
    $_SESSION['dedicated_status'] = true;
    $_SESSION['dedicated_city'] = $dedicatedIpCity;
    $_SESSION['dedicated_country'] = $dedicatedIpCountry;
}

try {
    $payment_intent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'usd',
        'description' => $description,
        'metadata' => [
            'user_id' => $user_id,
            'plan' => $plan,
        ],
        'receipt_email' => $email,
    ]);

    echo json_encode(['paymentIntentClientSecret' => $payment_intent->client_secret]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
