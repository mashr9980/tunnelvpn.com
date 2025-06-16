<?php
require_once 'vendor/autoload.php';

require_once 'backend/controller/config.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_CALLBACK_URL']);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth2 = new Google\Service\Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $google_id = $userInfo->id;
    $email = $userInfo->email;
    $name = $userInfo->name;

    $data = array(
        'username' => $name,
        'email' => $email,
        'google_id' => $google_id,
        'auth_provider' => 'google',
        'is_verified' => true,
        'registration_date' => date('Y-m-d H:i:s'),
        'last_login' => date('Y-m-d H:i:s'),
        'remember_token' => bin2hex(random_bytes(6))
    );

    $user = $crud->select('users', '*', null, "`email`=?", array($email));
    if (is_array($user)) {
        $crud->updatePrepare('users', $data, "`email`=?", array($email));
        $_SESSION['is_login'] = true;
        $_SESSION['login_id'] = $user['user_id'];
    } else {
        $crud->insert('users', $data);
        $_SESSION['is_login'] = true;
        $_SESSION['login_id'] = $crud->lastInsertId();
    }

    $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
    unset($_SESSION['redirect_url']); // Clear the redirect URL from the session

    $plan = isset($_SESSION['plan']) ? $_SESSION['plan'] : '';
    unset($_SESSION['plan']);

    $crud->displayMessage('Login Successfully', 'success', $redirectUrl . '?plan=' . $plan);

    exit();
} else {
    header('Location: login.php');
}
