<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;

$keyFilePath = 'keys/AuthKey_B2JLJ2247V.p8'; // Replace with your key file path
$teamId = '566WK7HFCJ'; // Replace with your Team ID
$clientId = 'com.griddownlllc.tunnel'; // Replace with your Client ID
$keyId = 'B2JLJ2247V'; // Replace with your Key ID

$privateKey = file_get_contents($keyFilePath);

$header = [
    'alg' => 'ES256',
    'kid' => $keyId
];

$claims = [
    'iss' => $teamId,
    'iat' => time(),
    'exp' => time() + 86400 * 180,
    'aud' => 'https://appleid.apple.com',
    'sub' => $clientId,
];

$jwt = JWT::encode($claims, $privateKey, 'ES256', $keyId);

echo $jwt;