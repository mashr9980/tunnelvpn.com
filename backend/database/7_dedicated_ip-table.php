<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE dedicated_ip (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    city VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

";
$query = mysqli_query($conn, $usertable);
if ($query) {
    echo 'Table Created Successfully';
} else {
    echo 'Error Creating Table' . mysqli_error($conn);
}
