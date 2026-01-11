<?php
require __DIR__."/../../config/config.php";
header('Content-Type: application/json');
postRequest();
$response=register($connection,'user');
echo json_encode($response);
exit;
?>