<?php

$rootPath = dirname(__DIR__, 3);

require_once $rootPath . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

//mail config
define('MAIL_HOST', $_ENV['MAIL_HOST']);
define('MAIL_USER', $_ENV['MAIL_USER']);
define('MAIL_PASS', $_ENV['MAIL_PASS']);
define('MAIL_NAME', $_ENV['MAIL_NAME']);
define('MAIL_PORT', $_ENV['MAIL_PORT']);
define('MAIL_SMTP_SECURE', $_ENV['MAIL_SMTP_SECURE']);

define('MAIL_SUPPORT', $_ENV['MAIL_SUPPORT']);

// Include the Prepare_crud class file
require_once 'prepare-crud.php';

// Instantiate the Prepare_crud class
$crud = new Prepare_crud(DB_HOST, DB_USER, DB_PASS, DB_NAME);


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set(isset($_SESSION['timezone']) ? $_SESSION['timezone'] : 'UTC');

$address = $_ENV['APP_URL'] . '/admin/upload-img/server-img/';
$Site = $_ENV['APP_URL'];
$site_2 = $_ENV['APP_URL'];
