<?php
require_once 'vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_CALLBACK_URL']);
$client->addScope('profile');
$client->addScope('email');

// Redirect to Google OAuth 2.0 server
$login_url = $client->createAuthUrl();
header('Location: ' . $login_url);
exit;
