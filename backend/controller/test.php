<?php

include_once '../controller/config.php';
require_once '../controller/user-crud.php';
use App\Auth\UserAuth;
include_once '../mail/mailer.php';


$sendMail = sendMail('sameedweb@gmail.com','nothing','Password REset');

?>