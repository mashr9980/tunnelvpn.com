<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

$log_file = 'api_access.log';
$log_entry = date('Y-m-d H:i:s') . " - " . $_SERVER['REMOTE_ADDR'] . " - " . $_SERVER['REQUEST_URI'] . "\n";
file_put_contents($log_file, $log_entry, FILE_APPEND);

include_once '../controller/config.php';

$getdata = json_decode(file_get_contents("php://input"), true);

$required_fields = array('token');
// $missing_fields = array('token');

// foreach ($required_fields as $field) {
//     if (!isset($getdata[$field]) || empty($getdata[$field])) {
//         $missing_fields[] = $field;
//     }
// }

// if (!empty($missing_fields)) {
//     $response = array(
//         'status' => false,
//         'message' => 'Missing Required Fields',
//         'fields' => $missing_fields
//     );
//     http_response_code(400);
//     echo json_encode($response);
//     exit;
// }

$getServers = $crud->select(
    'dedicated_servers',
    'dedicated_servers.*, users.username, users.email',
    'JOIN dedicated_ip ON dedicated_servers.dedicated_ip_id = dedicated_ip.id JOIN users ON dedicated_ip.user_id = users.user_id',
    'users.remember_token = ?',
    array($getdata['token'])
);
if (is_array($getServers)) {
    if (!empty($getServers) && !is_array($getServers[0])) {
        $getServers = array($getServers);
    }
    echo json_encode(array('status' => true, 'servers' => $getServers), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array('status' => false, 'servers' => array()), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
}
