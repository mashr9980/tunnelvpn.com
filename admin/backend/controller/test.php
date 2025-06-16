<?php
include_once 'config.php';

include_once '../mail/mailer.php';

$mail = sendMail('tecclubb@gmail.com', 'link', 'Password Reset');
if($mail){
    echo "Mail sent successfully";
}else{
    echo "Error sending mail";
}
