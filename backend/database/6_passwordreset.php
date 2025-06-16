<?php
include_once '../controller/config.php';

$usertable = "CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
";
$query = mysqli_query($conn, $usertable);
if ($query) {
    echo 'Table Created Successfully';
} else {
    echo 'Error Creating Table' . mysqli_error($conn);
}
