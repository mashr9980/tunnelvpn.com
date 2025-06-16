<?php
session_start();
include_once '../controller/config.php';

if (isset($_POST['createserver'])) {
    $data = $_POST;
    unset($data['createserver']);

    $data['status'] = isset($_POST['status']) ? '1' : '0';

    if (empty($data['server_name'])) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage("Server name is required", 'error', '../../add-server.php');
        exit;
    }

    // $checkServer = $crud->select('servers', 'server_name', null, "`server_name`=?", array($data['server_name']));
    // if (is_array($checkServer)) {
    //     $_SESSION['oldData'] = $data;
    //     $crud->displayMessage("Server name already exists", 'error', '../../add-server.php');
    //     exit;
    // }

    if (isset($_FILES['server_img'])) {
        $upload = '../../upload-img/server-img/';
        $fileupload = $crud->uploadImages($_FILES['server_img'], $upload, 52428800, 1);
        if (is_array($fileupload)) {
            $data['server_img'] = $fileupload['newfileName'];
        } else {
            $_SESSION['oldData'] = $data;
            $crud->displayMessage($fileupload, 'error', '../../add-server.php');
            exit;
        }
    }
    $addserver = $crud->insert('servers', $data);
    if ($addserver) {
        $crud->displayMessage('Server added successfully', 'success', '../../all-server.php');
    } else {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage($addserver, 'info', '../../add-server.php');
    }
}

if (isset($_POST['updateserver'])) {
    $data = $_POST;
    unset($data['updateserver']);
    $data['status'] = isset($_POST['status']) ? '1' : '0';
    $server_id = $data['server_id'];

    if (empty($data['server_name'])) {
        $crud->displayMessage("Server name is required", 'error', '../../edit-server.php?server_id=' . $server_id);
        exit;
    }

    $checkServer = $crud->select('servers', 'server_id,server_name', null, "`server_name`=?", array($data['server_name']));
    if (is_array($checkServer)) {
        if ($checkServer['server_id'] != $data['server_id']) {
            $crud->displayMessage("Server name already exists", 'error', '../../edit-server.php?server_id=' . $server_id);
            exit;
        }
    }

    if (isset($_FILES['new_server_img']) && $_FILES['new_server_img']['error'] == UPLOAD_ERR_OK) {
        $upload = '../../upload-img/server-img/';
        $fileupload = $crud->uploadImages($_FILES['new_server_img'], $upload, 52428800, 1);
        if (is_array($fileupload)) {
            $data['server_img'] = $fileupload['newfileName'];

            $old_image = $data['old_server_img'];
            $old_img_path = '../../upload-img/server-img/' . $old_image;
            if (file_exists($old_img_path)) {
                unlink($old_img_path);
            }
        } else {
            $crud->displayMessage($fileupload, 'error', '../../edit-server.php?server_id=' . $server_id);
            exit;
        }
    }

    unset($data['server_id']);
    unset($data['old_server_img']);

    print_r($data);
    $updateserver = $crud->update('servers', $data, "`server_id` = $server_id");
    if ($updateserver) {
        $crud->displayMessage('Server updated successfully', 'success', '../../all-server.php');
    } else {
        $crud->displayMessage($updateserver, 'error', '../../edit-server.php?server_id=' . $server_id);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'deleteserver') {
    $server_id = $_GET['server_id'];

    $checkServer = $crud->select('servers', 'server_id,server_img', null, "`server_id`=?", array($server_id));
    if (is_array($checkServer)) {
        $old_image = $checkServer['server_img'];
        $old_img_path = '../../upload-img/server-img/' . $old_image;
        if (file_exists($old_img_path)) {
            unlink($old_img_path);

            $deleteserver = $crud->delete('servers', "`server_id`=?", array($server_id));
            if ($deleteserver) {
                $crud->displayMessage("Server Deleted Successfully", 'success', '../../all-server.php');
            } else {
                $crud->displayMessage($deleteserver, 'error', '../../all-server.php');
            }
        }
    } else {
        $crud->displayMessage("Server not found", 'error', '../../all-server.php');
    }
}
