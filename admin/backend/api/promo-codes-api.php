<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

include_once '../controller/config.php';

if (isset($_GET['action']) && $_GET['action'] == 'getPromo') {
    $getdata = json_decode(file_get_contents("php://input"), true);

    $promo = $getdata['code'];
    $currenttime = date('Y-m-d H:i:s');

    $checkPromo = $crud->select('promo_codes', '*', null, "`code`=? AND `expiration_date` >= ?", array($promo, $currenttime));
    if (is_array($checkPromo)) {
        echo json_encode(array('status' => true, 'Code' => 'Available'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('status' => false, 'Code' => 'Invalid Code'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    }
}
