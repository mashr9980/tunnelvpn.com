<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

include_once 'backend/controller/config.php';

$getdata = json_decode(file_get_contents("php://input"), true);

$remember_token = $getdata['remember_token'];
$user = $crud->select('users', 'user_id', null, "remember_token = ?", array($remember_token));

if (is_array($user) && !empty($user['user_id'])) {
    $user_id = $user['user_id'];
    if (isset($getdata['username']) && !empty($getdata['username'])) {
        $updateData = array('username' => $getdata['username']);
        $crud->update('users', $updateData, "`user_id`=$user_id");
    }
    if (isset($getdata['email']) && !empty($getdata['email'])) {
        $checkuser = $crud->select('users', '*', null, "email = ?", array($getdata['email']));
        if (!is_array($checkuser) || empty($checkuser['user_id'])) {
            $updateData = array('email' => $getdata['email']);
            $crud->update('users', $updateData, "`user_id`=$user_id");
        }
    }
    echo json_encode(array('status' => true, 'message' => 'User Updated Successfully'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array('status' => false, 'message' => 'Invalid remember token'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
}
