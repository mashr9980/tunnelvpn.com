<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE dedicated_servers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dedicated_ip_id INT NOT NULL,
    server_name VARCHAR(255) NOT NULL,
    server_img VARCHAR(255) NOT NULL,
    server_config VARCHAR(255) NOT NULL,
    server_address VARCHAR(255) NOT NULL,
    server_city VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dedicated_ip_id) REFERENCES dedicated_ip(id) ON DELETE CASCADE
);
";
$query = mysqli_query($conn, $usertable);
if ($query) {
    echo 'Table Created Successfully';
} else {
    echo 'Error Creating Table' . mysqli_error($conn);
}
