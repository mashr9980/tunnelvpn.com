<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE promo_codes (
    promo_id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL UNIQUE,
    expiration_date DATETIME NOT NULL,
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
