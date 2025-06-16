<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

include_once 'backend/controller/config.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use AppleSignIn\ASDecoder;

try {   
    $body = json_decode(file_get_contents("php://input"), true);
    if (!isset($body['id_token'])) {
        throw new Exception('ID token not received.');
    }
    $id_token = $body['id_token'];

    $jwtHeader = json_decode(base64_decode(explode('.', $id_token)[0]), true);
    $kid = $jwtHeader['kid'];
    $publicKey = ASDecoder::fetchPublicKey($kid);
    $decoded = JWT::decode($id_token, new Key($publicKey['publicKey'], $publicKey['alg']));
    $apple_email = $decoded->email;
    $apple_id = $decoded->sub;
    if (isset($body['user'])) {
        $user_data = json_decode($_POST['user'], true);
        $first_name = htmlspecialchars($user_data['name']['firstName'], ENT_QUOTES, 'UTF-8');
        $last_name = htmlspecialchars($user_data['name']['lastName'], ENT_QUOTES, 'UTF-8');

        $data = array(
            'username' => $first_name . '_' . $last_name,
            'email' => $apple_email,
            'apple_id' => $apple_id,
            'auth_provider' => 'apple',
            'is_verified' => $decoded->email_verified,
            'registration_date' => date('Y-m-d H:i:s'),
            'last_login' => date('Y-m-d H:i:s'),
            'remember_token' => bin2hex(random_bytes(6))
        );

        // Check if the user already exists using the email address
        $user = $crud->select('users', '*', null, "`email`=? AND `auth_provider`=?", array($apple_email, 'apple'));
        if (is_array($user)) {
            // Update existing user record
            $data['password'] = $user['password']; // Retain the existing password
            $crud->updatePrepare('users', $data, "`email`=? AND `auth_provider`=?", array($apple_email, 'apple'));
            $user_id = $user['user_id'];
        } else {
            // Insert new user record
            $data['password'] = "KABssbas7788asaAIU7TA";
            $crud->insert('users', $data);
            $user_id = $crud->lastInsertId();
        }

        $response = [
            'status' => true,
            'message' => 'Login Successfully',
            'user_id' => $user_id,
            'user' => $data,
            'user_token' => $data['remember_token']
        ];
    } else {
        $user = $crud->select('users', '*', null, "`apple_id`=? AND `auth_provider`=?", array($apple_id, 'apple'));
        if (is_array($user)) {
            $response = [
                'status' => true,
                'message' => 'Login Successfully',
                'user' => $user,
                'user_id' => $user['user_id']
            ];
        } else {
            throw new Exception('User not found.');
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => false, 'message' => $e->getMessage()]);
    exit;
}

echo json_encode($response);
