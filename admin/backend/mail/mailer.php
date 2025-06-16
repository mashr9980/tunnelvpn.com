<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
require_once __DIR__ . '/../controller/config.php';

function sendMail($email, $subject, $reset_link = null, $message = null, $name = null, $toMail = null, $verify = null)
{
    $mail = new PHPMailer(true);

    try {
        if ($reset_link != null) {
            if ($verify != null) {
                $template = file_get_contents(__DIR__ . '/email-verify.html');
                // Replace placeholders in the template
                $body = str_replace('{{verification_link}}', $reset_link, $template);
                $body = str_replace('{{subject}}', $subject, $body);
                $body = str_replace('{{name}}', $name, $body);
            } else {
                // Load the HTML template
                $template = file_get_contents(__DIR__ . '/email-template.html');
                // Replace placeholders in the template
                $body = str_replace('{{reset_link}}', $reset_link, $template);
            }
        } else {
            $template = file_get_contents(__DIR__ . '/email-temp.html');
            $body = str_replace('{{name}}', $name, $template);
            $body = str_replace('{{email}}', $toMail, $body);
            $body = str_replace('{{message}}', $message, $body);
        }

        // Server settings
        $mail->isSMTP();
        $mail->Host = MAIL_HOST; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER; // SMTP username
        $mail->Password = MAIL_PASS; // SMTP password
        $mail->SMTPSecure = MAIL_SMTP_SECURE;
        $mail->Port = MAIL_PORT;

        // Recipients
        $mail->setFrom(MAIL_USER, MAIL_NAME);
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Fallback text version

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
