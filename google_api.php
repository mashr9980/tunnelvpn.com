<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

require_once 'vendor/autoload.php';
require_once 'backend/controller/config.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_CALLBACK_URL']);

try {
    $body = json_decode(file_get_contents("php://input"), true);
    if (!isset($body['code'])) {
        throw new Exception('Authorization code not found.');
    }

    // $token = $client->fetchAccessTokenWithAuthCode($body['code']);
    $client->setAccessToken($body['code']);

    $oauth2 = new Google\Service\Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $google_id = $userInfo->id;
    $email = $userInfo->email;
    $name = $userInfo->name;

    $user = $crud->select('users', '*', null, "`google_id`=?", array($google_id));
    if (is_array($user)) {
        echo json_encode(array('status' => true, 'message' => 'Login Successfully', 'user_token' => $user['remember_token'], 'user'=> $user));
        exit();
    } else {
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
        $crud->insert('users', $data);
        echo json_encode(array('status' => true, 'message' => 'Login Successfully', 'user_id' => $crud->lastInsertId(), 'user_token' => $data['remember_token'], 'user'=> $data));
        exit();
    }
} catch (Exception $e) {
    echo json_encode(array('status' => false, 'message' => $e->getMessage()));
    exit();
}
