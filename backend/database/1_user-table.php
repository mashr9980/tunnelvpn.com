<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    registration_date DATETIME NOT NULL,
    last_login DATETIME,
    is_verified tinyint(1) DEFAULT 0,
    verification_token varchar(255) DEFAULT NULL,
    remember_token VARCHAR(255) NULL,
    ADD COLUMN google_id VARCHAR(255) DEFAULT NULL,
    ADD COLUMN apple_id VARCHAR(255) DEFAULT NULL,
    ADD COLUMN auth_provider ENUM('google', 'apple', 'local') DEFAULT 'local';
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
