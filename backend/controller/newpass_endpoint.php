<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$log_file = __DIR__ . '/newpass_api.log';
ini_set('log_errors', 1);
ini_set('error_log', $log_file);

function logMessage($message, $type = 'INFO') {
    global $log_file;
    $log_entry = date('Y-m-d H:i:s') . " - [$type] - " . $message . "\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

header('Content-Type: application/json');

logMessage("NewPass API accessed from IP: " . $_SERVER['REMOTE_ADDR']);

logMessage("Including configuration and CRUD files");
include_once '../controller/config.php';
require_once '../controller/user-crud.php';
use App\Auth\UserAuth;
use App\Database\Database;

logMessage("Initializing CRUD object");
$crud = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$userAuth = new UserAuth($crud);

try {    logMessage("Decoding JSON input");
    $json_input = file_get_contents("php:    $data = json_decode($json_input, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input: ' . json_last_error_msg());
    }

    logMessage("Received data: " . print_r($data, true));    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $old_password = $data['old_password'] ?? '';
    $new_password = $data['new_password'] ?? '';

    $missing_fields = [];
    if (empty($username)) $missing_fields[] = 'username';
    if (empty($email)) $missing_fields[] = 'email';
    if (empty($old_password)) $missing_fields[] = 'old_password';
    if (empty($new_password)) $missing_fields[] = 'new_password';

    if (!empty($missing_fields)) {
        throw new Exception('Missing required fields: ' . implode(', ', $missing_fields));
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    if (strlen($new_password) < 8) {
        throw new Exception('New password must be at least 8 characters long');
    }

    logMessage("Input validation passed");    logMessage("Fetching user data for username: $username and email: $email");
    $userData = $crud->select('users', '*', null, "`username`=? AND `email`=?", array($username, $email));

    if (!is_array($userData) || empty($userData)) {
        throw new Exception('User not found');
    }

    logMessage("User found: " . print_r($userData, true));    if (!password_verify($old_password, $userData['password'])) {
        throw new Exception('Old password is incorrect');
    }

    logMessage("Old password verified successfully");    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);    logMessage("Updating password for user ID: " . $userData['user_id']);
    $updateData = ['password' => $hashed_new_password];    logMessage("Update data: " . print_r($updateData, true));
    logMessage("User ID for update: " . $userData['user_id']);    $updateUser = $crud->update('users', $updateData, "`user_id` = ?", array($userData['user_id']));

    if ($updateUser === true) {
        $success_message = "Password updated successfully for user " . $username;
        logMessage($success_message, 'SUCCESS');
        echo json_encode(['status' => true, 'message' => $success_message]);
    } else {
        throw new Exception("Failed to update password in the database: " . $updateUser);
    }

} catch (Exception $e) {
    $error_message = "Error: " . $e->getMessage();
    logMessage($error_message, 'ERROR');
    echo json_encode(['status' => false, 'message' => $error_message]);
}

logMessage("NewPass API execution completed");