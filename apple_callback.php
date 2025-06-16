<?php
session_start();
require 'vendor/autoload.php';

require_once 'backend/controller/config.php';

use GuzzleHttp\Client;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Firebase\JWT\Key;
use AppleSignIn\ASDecoder;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client_id = $_ENV['APPLE_CLIENT_ID'];
$client_secret = $_ENV['APPLE_CLIENT_SECRET'];
$redirect_uri = $_ENV['APPLE_CALLBACK_URL'];

// print_r($_SESSION);
// exit();

try {
    
    // Step 1: Exchange the authorization code for tokens
    if (!isset($_REQUEST['code'])) {
        throw new Exception('Authorization code not found.');
    }

    $client = new Client();

    $response = $client->request('POST', 'https://appleid.apple.com/auth/token', [
        'form_params' => [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $_REQUEST['code'],
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_uri,
        ],
    ]);
    $body = json_decode($response->getBody()->getContents(), true);
    if (!isset($body['id_token'])) {
        throw new Exception('ID token not received.');
    }

    $id_token = $body['id_token'];
    $access_token = $body['access_token'];
    $refresh_token = $body['refresh_token'];

    $jwtHeader = json_decode(base64_decode(explode('.', $id_token)[0]), true);
    $kid = $jwtHeader['kid'];

    // Fetch the appropriate public key
    $publicKey = ASDecoder::fetchPublicKey($kid);

    $decoded = JWT::decode($id_token, new Key($publicKey['publicKey'], $publicKey['alg']));

    $apple_email = $decoded->email;
    $apple_id = $decoded->sub;

    if (isset($_REQUEST['user'])) {
        $user_data = json_decode($_REQUEST['user'], true);
        $first_name = $user_data['name']['firstName'];
        $last_name = $user_data['name']['lastName'];
        $email = $user_data['email'];

        $data = array(
            'username' => $first_name . '_' . $last_name,
            'email' => $email,
            'apple_id' => $apple_id,
            'auth_provider' => 'apple',
            'is_verified' => $decoded->email_verified,
            'registration_date' => date('Y-m-d H:i:s'),
            'last_login' => date('Y-m-d H:i:s'),
            'remember_token' => bin2hex(random_bytes(6))
        );
        $user = $crud->select('users', '*', null, "`email`=? AND `auth_provider`=?", array($email, 'apple'));
        if (is_array($user)) {
            // Update existing user record
            $crud->updatePrepare('users', $data, "`email`=? AND `auth_provider`=?", array($email, 'apple'));
            $_SESSION['is_login'] = true;
            $_SESSION['login_id'] = $user['user_id'];
        } else {
            // Insert new user record
            $crud->insert('users', $data);
            $_SESSION['is_login'] = true;
            $_SESSION['login_id'] = $crud->lastInsertId();
        }

        $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
        unset($_SESSION['redirect_url']); // Clear the redirect URL from the session

        $plan = isset($_SESSION['plan']) ? $_SESSION['plan'] : 'default';
        unset($_SESSION['plan']);

        $crud->displayMessage('Login Successfully', 'success', $redirectUrl . '?plan=' . $plan);
    } else {
        $user = $crud->select('users', '*', null, "`apple_id`=? AND `auth_provider`=?", array($apple_id, 'apple'));
        if (is_array($user)) {
            $_SESSION['is_login'] = true;
            $_SESSION['login_id'] = $user['user_id'];
            $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
            unset($_SESSION['redirect_url']); // Clear the redirect URL from the session

            $plan = isset($_SESSION['plan']) ? $_SESSION['plan'] : 'default_plan';
            unset($_SESSION['plan']);

            $crud->displayMessage('Login Successfully', 'success', $redirectUrl . '?plan=' . $plan);
        } else {
            $crud->displayMessage('User not found', 'error', 'login.php');
        }
    }
} catch (Exception $e) {
    // $crud->displayMessage('An error occurred: ' . $e->getMessage(), 'error', 'login.php');
    print_r($e->getMessage());
}
