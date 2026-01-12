<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define("SECURE_ACCESS", true);
require_once __DIR__ . "/../function/function.php";
ProtectFile(__FILE__);

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'muhammadshaharyaraulakh@gmail.com');
define('SMTP_PASSWORD', 'sfyw hous shvc bytw');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls');

$host = "localhost";
$dataBase = "BookBuddy";
$db_user = "root";
$db_password = "1234";
$charset = "utf8mb4";

$dataSource = "mysql:host=$host;dbname=$dataBase;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => FALSE
];
try {
    $connection = new PDO($dataSource, $db_user, $db_password, $options);
} catch (PDOException $e) {
    die("Connection failed" . htmlspecialchars($e->getMessage()));
}