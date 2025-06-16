<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

$log_file = 'api_access.log';
$log_entry = date('Y-m-d H:i:s') . " - " . $_SERVER['REMOTE_ADDR'] . " - " . $_SERVER['REQUEST_URI'] . "\n";
file_put_contents($log_file, $log_entry, FILE_APPEND);

include_once '../controller/config.php';

if (isset($_GET['action']) && $_GET['action'] == 'NewPurchase') {
    $getdata = json_decode(file_get_contents("php://input"), true);

    $required_fields = array('token', 'status', 'expiry_date');
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

    $getUser = $crud->select('users', 'user_id', null, "`remember_token`=?", array($getdata['token']));
    if (is_array($getUser)) {
        $purchase = $crud->select('purchases', 'purchase_id', null, "`user_id`=?", array($getUser['user_id']));
        $user_id = $getUser['user_id'];
        $data = $getdata;
        $data['user_id'] = $user_id;
        unset($data['token']);
        if (is_array($purchase)) {
            // If a purchase exists, update the existing record
            $purchase_id = $purchase['purchase_id']; // Assuming there's a single purchase for the user
            $addPurchase = $crud->update('purchases', $data, "`purchase_id`=$purchase_id");
            if (is_bool($addPurchase)) {
                echo json_encode(array('status' => 'success', 'message' => 'Purchase Updated Successfully'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to Add Purchase', 'purchase' => $addPurchase), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            }
        } else {
            $addPurchase = $crud->insert('purchases', $data);
            if (is_bool($addPurchase)) {
                echo json_encode(array('status' => 'success', 'message' => 'Purchase Added Successfully'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to Add Purchase'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
            }
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'getStatus') {
    $getdata = json_decode(file_get_contents("php://input"), true);

    $required_fields = array('token', 'status', 'expiry_date');
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

    $getUser = $crud->select('users', 'user_id', null, "`remember_token`=?", array($getdata['token']));
    if (is_array($getUser)) {

        $purchase = $crud->select('purchases', '*', null, "`user_id`=?", array($getUser['user_id']));

        // Check if a purchase was found
        // if (!empty($purchase)) {
        // Access the first purchase row
        // $purchase = $purchase[0];
        //      $purchases[] = [
        //             "status" => $purchase['status'],
        //             "date" => $purchase['expiry_date'],
        //         ];
        echo json_encode(array('status' => 'true', 'message' => 'Purchase Get Successfully', 'data' => $purchase), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array('status' => 'false', 'message' => 'Purchase Get failed by user'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    }
}
