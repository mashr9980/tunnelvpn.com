<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Access-Control-Allow-Origin,Content-Type');

include_once  '../controller/config.php';
include_once  '../mail/mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $name = trim($data['name']);
    $email = trim($data['email']);
    $subject = trim($data['subject']);
    $comments = trim($data['comments']);

    if (empty($name) || empty($email) || empty($subject) || empty($comments)) {
        echo json_encode(['status' => false, 'message' => 'Please fill all the fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'message' => 'Please enter a valid email address.']);
        exit;
    }

    $to = MAIL_SUPPORT; // Change to your email

    if (sendMail($to, null, 'Contact Support', $comments, $name, $email)) {
        echo json_encode(['status' => true, 'message' => 'Thank you for contacting us We will get back to you as soon as possible.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Something went wrong. Please try again later.']);
    }
}
