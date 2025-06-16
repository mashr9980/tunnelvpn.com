<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');
$log_file = 'api_access.log';
$log_entry = date('Y-m-d H:i:s') . " - " . $_SERVER['REMOTE_ADDR'] . " - " . $_SERVER['REQUEST_URI'] . "\n";
file_put_contents($log_file, $log_entry, FILE_APPEND);
include_once '../controller/config.php';
if (isset($_GET['action']) && $_GET['action'] == 'getServers') {
    $getServers = $crud->select('servers', '*');
    $servers = [];
    if (is_array($getServers)) {
        $serverList = isset($getServers[0]) ? $getServers : [$getServers];
        foreach ($serverList as $server) {
            // Fetch sub_servers for the current server
            $subServers = $crud->select('sub_servers', '*', null, "`server_id`=?", [$server['server_id']]);
            $subServerList = is_array($subServers) ? (isset($subServers[0]) ? $subServers : [$subServers]) : [];
            // Add server details to the array
            $servers[] = [
                "server_id" => $server['server_id'],
                "server_name" => $server['server_name'],
                "server_img" => 'https://account.tunnelvpn.com/admin/upload-img/server-img/'. $server['server_img'],
                "status" => $server['status'],
                "created_at" => $server['created_at'],
                "updated_at" => $server['updated_at'],
                "sub_servers" => $subServerList
            ];
        }
        
        // Sort servers alphabetically by server_name
        usort($servers, function($a, $b) {
            return strcasecmp($a['server_name'], $b['server_name']);
        });
        
        // print_r($servers);
        echo json_encode(array('status' => true, 'servers' => $servers), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array('status' => false, 'message' => 'No servers found'), JSON_PRETTY_PRINT || JSON_UNESCAPED_UNICODE);
    }
}