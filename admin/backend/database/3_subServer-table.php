<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE sub_servers (
    sub_server_id INT AUTO_INCREMENT PRIMARY KEY,
    server_id INT NOT NULL UNIQUE, -- Ensuring one-to-one relationship
    sub_server_name VARCHAR(255) NOT NULL,
    sub_server_config VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (server_id) REFERENCES servers(server_id) ON DELETE CASCADE
);

";
$query = mysqli_query($conn, $usertable);
if ($query) {
    echo 'Table Created Successfully';
} else {
    echo 'Error Creating Table' . mysqli_error($conn);
}
