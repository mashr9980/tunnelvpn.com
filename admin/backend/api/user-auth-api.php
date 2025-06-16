<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

$log_file = 'api_access.log';
$log_entry = date('Y-m-d H:i:s') . " - " . $_SERVER['REMOTE_ADDR'] . " - " . $_SERVER['REQUEST_URI'] . "\n";
file_put_contents($log_file, $log_entry, FILE_APPEND);

include_once '../controller/config.php';
require_once '../controller/user-crud.php';
use App\Auth\UserAuth;
include_once '../mail/mailer.php';

$user = new UserAuth($crud);

if (isset($_GET['action']) && $_GET['action'] == 'register') {
    $getdata = json_decode(file_get_contents("php:
    $data = array(
        'username' => $getdata['name'],
        'email' => $getdata['email'],
        'password' => $getdata['password']
    );

    $registerUser = $user->userRegister($data);
    if (is_bool($registerUser)) {
        echo json_encode(array('status' => true, 'message' => 'Sign Up Successfully. Please check your email to verify your account.'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array('status' => false, 'message' => $registerUser), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $getdata = json_decode(file_get_contents("php:
    $required_fields = array('name', 'password');
    $missing_fields = array();

    foreach ($required_fields as $field) {
        if (!isset($getdata[$field]) || empty($getdata[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $response = array(
            'status' => 'error',
            'message' => 'Missing Required Fields',
            'fields' => $missing_fields
        );
        echo json_encode($response);
        exit;
    }

    $data = array(
        'username' => $getdata['name'],
        'password' => $getdata['password']
    );
    $loginuser = $user->userLogin($data, true, true);
    if (is_array($loginuser)) {
        echo json_encode(array('status' => true, 'message' => 'User Login Successfully', 'user' => $loginuser), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array('status' => false, 'message' => $loginuser), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'forgotpass') {
    $getdata = json_decode(file_get_contents("php:
    $required_fields = array('email');
    $missing_fields = array();

    foreach ($required_fields as $field) {
        if (!isset($getdata[$field]) || empty($getdata[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $response = array(
            'status' => 'error',
            'message' => 'Missing Required Fields',
            'fields' => $missing_fields
        );
        echo json_encode($response);
        exit;
    }

    $user = $crud->select('users', 'user_id,email', null, "`email`=?", array($getdata['email']));
    if (is_array($user)) {
        $oldToken = $crud->delete('password_resets', "`user_id`=?", array($user['user_id']));

        $user_id = $user['user_id'];
        $token = mt_rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data = [
            'user_id' => $user_id,
            'token' => $token,
            'expires_at' => $expires_at
        ];

        $addToken = $crud->insert('password_resets', $data);
        if (is_bool($addToken)) {
            if (sendMail($user['email'], 'Password Reset', $token)) {
                echo json_encode(array('status' => true, 'message' => 'Password Reset Link Sent Please check your email for password reset link.'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
                exit;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Failed to send Password Reset Link'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
                exit;
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Error in Creating Reset Token'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            exit;
        }
    } else {
        echo json_encode(
            array('status' => false, 'message' => 'Email Not Found'),
            JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE
        );
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'check_token') {
    $getdata = json_decode(file_get_contents("php:
    $required_fields = array('token');
    $missing_fields = array();

    foreach ($required_fields as $field) {
        if (!isset($getdata[$field]) || empty($getdata[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $response = array(
            'status' => 'error',
            'message' => 'Missing Required Fields',
            'fields' => $missing_fields
        );
        echo json_encode($response);
        exit;
    }

    $token = $getdata['token'];    $resetRecord = $crud->select('password_resets', 'user_id, expires_at', null, "`token`=?", array($token));

    if (is_array($resetRecord)) {
        $expires_at = $resetRecord['expires_at'];        if (strtotime($expires_at) < time()) {
            echo json_encode(array('status' => false, 'message' => 'Token has expired'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(array('status' => true, 'message' => 'Token is valid'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
        exit;
    } else {
        echo json_encode(array('status' => false, 'message' => 'Invalid token'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'resetpass') {
    $getdata = json_decode(file_get_contents("php:
    $required_fields = array('token', 'password');
    $missing_fields = array();

    foreach ($required_fields as $field) {
        if (!isset($getdata[$field]) || empty($getdata[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $response = array(
            'status' => 'error',
            'message' => 'Missing Required Fields',
            'fields' => $missing_fields
        );
        echo json_encode($response);
        exit;
    }

    $token = $getdata['token'];
    $new_password = $getdata['password'];    $resetRecord = $crud->select('password_resets', 'user_id, expires_at', null, "`token`=?", array($token));

    if (is_array($resetRecord)) {

        $user_id = $resetRecord['user_id'];        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);        $updatePassword = $crud->update('users', array('password' => $hashed_password), "`user_id`=$user_id");

        if (is_bool($updatePassword)) {            $crud->delete('password_resets', "`user_id`=?", array($user_id));

            echo json_encode(array('status' => true, 'message' => 'Password updated successfully'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            echo json_encode(array('status' => false, 'message' => 'Failed to update password'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            exit;
        }
    } else {
        echo json_encode(array('status' => false, 'message' => 'Invalid or expired token'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'NewPass') {
    $data = json_decode(file_get_contents("php:    $token = $data['token'] ?? '';
    $new_password = $data['new_password'] ?? '';

    if (empty($token) || empty($new_password)) {
        echo json_encode(['status' => 'false', 'message' => 'Token and new password are required']);
        exit;
    }

    $reset = $crud->select('password_resets', 'user_id,expires_at', null, "`token`=?", array($token));
    if (!is_array($reset) || strtotime($reset['expires_at']) < time()) {
        echo json_encode(['status' => 'false', 'message' => 'Invalid or expired token']);
        exit;
    }

    $user_id = $reset['user_id'];
    $newPass = [
        'password' => password_hash($new_password, PASSWORD_DEFAULT)
    ];

    $updateUser = $crud->update('users', $newPass, "`user_id`= $user_id");
    if (is_bool($updateUser)) {
        $deleteToken = $crud->delete('password_resets', "`token`=?", array($token));
        echo json_encode(['status' => 'true', 'message' => 'Password has been updated']);
    } else {
        echo json_encode(['status' => 'false', 'message' => 'Failed to update password']);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'verifyLink') {
    $data = json_decode(file_get_contents("php:    $email = $data['email'] ?? '';

    if (empty($email)) {
        echo json_encode(['status' => false, 'message' => 'Email is required']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'message' => 'Invalid Email']);
        exit;
    }

    $user = $crud->select('users', '*', null, "(`email` = ? OR `username`=?) AND `is_verified` = ? ", array($email, $email, 0));
    if (is_array($user)) {
        $user_id = $user['user_id'];
        $verification_token = bin2hex(random_bytes(16));
        $updateData = array('verification_token' => $verification_token);
        $NewToken = $crud->update('users', $updateData, "`user_id`=$user_id");
        if ($NewToken) {
            $reset_link = $Site . '/verify.php?token=' . $verification_token;
            if (sendMail($email, 'Verify Email', $reset_link, null, $user['username'], null, true)) {
                echo json_encode(array('status' => true, 'message' => 'Verification email has been sent.'));
                exit;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Failed to send verification email.'));
                exit;
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Failed to Create New Token'));
        }
    } else {
        echo json_encode(array('status' => false, 'message' => 'No account found with this email or the account is already verified.'));
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'deleteuser') {
    $data = json_decode(file_get_contents("php:
    if (isset($data['user_id'])) {
        $user_id = $data['user_id'];
        $deleteUser = $crud->delete('users', "`user_id`=?", array($user_id));
        if (is_bool($deleteUser)) {
            echo json_encode(['status' => true, 'message' => 'User Deleted Successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => $deleteUser]);
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'User ID not provided']);
    }
    exit;
}
