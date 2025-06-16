<?php
session_start();

include_once '../controller/config.php';
require_once $rootPath . '/src/Database/Database.php';
use App\Database\Database;
$crud = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST['createsubserver'])) {
    $data = $_POST;
    unset($data['createsubserver']);

    $requiredfields = array('server_id', 'sub_server_name', 'sub_server_config','ip_addresss','longitude','latitude', 'panel_address', 'password');
    $checkdata = $crud->validateMissing($data, $requiredfields);
    if (!empty($checkdata)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage($checkdata, 'error', '../../add-sub-server.php');
        exit;
    }

    $checkExistingSubServer = $crud->select('sub_servers', 'sub_server_id', null, "`server_id`=?", array($data['server_id']));
    if (is_array($checkExistingSubServer)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage('This server already has a sub server.', 'error', '../../add-sub-server.php');
        exit;
    }

    $checkServer = $crud->select('sub_servers', 'sub_server_id', null, "`sub_server_name`=?", array($data['sub_server_name']));
    if (is_array($checkServer)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage('Sub Server Already Existed', 'error', '../../add-sub-server.php');
        exit;
    }

    $addserver = $crud->insert('sub_servers', $data);
    if (is_bool($addserver)) {
        $crud->displayMessage('Sub Server Added Successfully', 'success', '../../all-sub-server.php');
    } else {
        $crud->displayMessage($addserver, 'error', '../../add-sub-server.php');
    }
}

if (isset($_POST['updatesubserver'])) {
    $data = $_POST;
    unset($data['updatesubserver']);
    unset($data['sub_server_id']);
    $sub_server_id = $_POST['sub_server_id'];

    $requiredfields = array('server_id', 'sub_server_name', 'sub_server_config','ip_addresss','longitude','latitude', 'panel_address', 'password');
    $checkdata = $crud->validateMissing($data, $requiredfields);
    if (!empty($checkdata)) {
        $crud->displayMessage($checkdata, 'error', '../../edit-sub-server.php?sub_server_id=' . $sub_server_id);
        exit;
    }

    $checkServer = $crud->select('sub_servers', 'sub_server_id', null, "`sub_server_name`=?", array($data['sub_server_name']));
    if (is_array($checkServer)) {
        if ($checkServer['sub_server_id'] != $sub_server_id) {
            $crud->displayMessage('Sub Server Already Existed', 'error', '../../edit-sub-server.php?sub_server_id=' . $sub_server_id);
        }
    }

    $updateSubServer = $crud->update('sub_servers', $data, "`sub_server_id`=$sub_server_id");
    if (is_bool($updateSubServer)) {
        $crud->displayMessage('Sub Server Updated Successfully', 'success', '../../all-sub-server.php');
    } else {
        $crud->displayMessage($updateSubServer, 'info', '../../all-sub-server.php');
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'deletesubserver') {
    $sub_server_id = $_GET['sub_server_id'];
    $deleteSubserver = $crud->delete('sub_servers', "`sub_server_id`=?", array($sub_server_id));
    if (is_bool($deleteSubserver)) {
        $crud->displayMessage('Sub Server Deleted Successfully', 'success', '../../all-sub-server.php');
    } else {
        $crud->displayMessage($deleteSubserver, 'error', '../../all-sub-server.php');
    }
}
