<?php

session_start();
include_once '../controller/config.php';


if (isset($_POST['createDedserver'])) {
    $data = $_POST;
    unset($data['createDedserver']);
    unset($data['user_id']);

    $user_id = $_POST['user_id'];

    $dedicated = $crud->select('dedicated_ip', 'id,user_id,city,country', null, "`user_id`=?", array($user_id));
    if (!is_array($dedicated)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage('Invalid User', 'error', '../../add-dedicated-server.php?user_id=' . $user_id);
        exit;
    }

    $requiredfields = array('server_name', 'server_city', 'server_address', 'server_config','longitude','latitude');
    $checkdata = $crud->validateMissing($data, $requiredfields);
    if (!empty($checkdata)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage($checkdata, 'error', '../../add-dedicated-server.php?user_id=' . $user_id);
        exit;
    }

    if (isset($_FILES['server_img'])) {
        $upload = '../../upload-img/dedicated-server/';
        $fileupload = $crud->uploadImages($_FILES['server_img'], $upload, 52428800, 1);
        if (is_array($fileupload)) {
            $data['server_img'] = $fileupload['newfileName'];
        } else {
            $_SESSION['oldData'] = $data;
            $crud->displayMessage($fileupload, 'error', '../../add-dedicated-server.php?user_id=' . $user_id);
            exit;
        }
    }

    $data['dedicated_ip_id'] = $dedicated['id'];

    $addserver = $crud->insert('dedicated_servers', $data);
    if ($addserver) {
        $crud->displayMessage('Dedicated Server added successfully', 'success', '../../all-dedicated-servers.php?user_id=' . $user_id);
    } else {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage($addserver, 'info', '../../add-dedicated-server.php?user_id=' . $user_id);
    }
}

if (isset($_POST['updateDedserver'])) {
    $data = $_POST;
    unset($data['updateDedserver']);
    unset($data['id']);
    $id = $_POST['id'];

    $requiredfields = array('server_name', 'server_city', 'server_address', 'server_config','longitude','latitude');
    $checkdata = $crud->validateMissing($data, $requiredfields);
    if (!empty($checkdata)) {
        $crud->displayMessage($checkdata, 'error', '../../edit-dedicated-server.php?id=' . $id);
        exit;
    }

    if (isset($_FILES['new_server_img']) && $_FILES['new_server_img']['error'] == UPLOAD_ERR_OK) {
        $upload = '../../upload-img/dedicated-server/';
        $fileupload = $crud->uploadImages($_FILES['new_server_img'], $upload, 52428800, 1);
        if (is_array($fileupload)) {
            $data['server_img'] = $fileupload['newfileName'];

            $old_image = $data['old_server_img'];
            $old_img_path = '../../upload-img/dedicated-server/' . $old_image;
            if (file_exists($old_img_path)) {
                unlink($old_img_path);
            }
        } else {
            $crud->displayMessage($fileupload, 'error', '../../edit-dedicated-server.php?id=' . $id);
            exit;
        }
    }

    unset($data['old_server_img']);

    $updateserver = $crud->update('dedicated_servers', $data, "`id` = $id");
    if ($updateserver) {
        $crud->displayMessage('Dedicated Server updated successfully', 'success', '../../all-dedicated-servers.php');
    } else {
        $crud->displayMessage($updateserver, 'error', '../../edit-dedicated-server.php?id=' . $id);
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dedicated = $crud->select('dedicated_servers', 'id,server_img', null, "`id`=?", array($id));
    if (is_array($dedicated)) {
        $old_image = $dedicated['server_img'];
        $old_img_path = '../../upload-img/dedicated-server/' . $old_image;
        if (file_exists($old_img_path)) {
            unlink($old_img_path);
        }
        $deleteserver = $crud->delete('dedicated_servers', "`id`=?", array($id));
        if ($deleteserver) {
            $crud->displayMessage("Dedicated Server Deleted Successfully", 'success', '../../all-dedicated-servers.php');
        } else {
            $crud->displayMessage($deleteserver, 'error', '../../all-dedicated-servers.php');
        }
    } else {
        $crud->displayMessage("Dedicated Server not found", 'error', '../../all-dedicated-servers.php');
    }
}
