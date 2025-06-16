<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE servers (
    server_id INT AUTO_INCREMENT PRIMARY KEY,
    server_name VARCHAR(255) NOT NULL,
    server_img VARCHAR(255) NOT NULL,
    status ENUM('1', '0') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
";
$query = mysqli_query($conn, $usertable);
if ($query) {
    echo 'Table Created Successfully';
} else {
    echo 'Error Creating Table' . mysqli_error($conn);
}
