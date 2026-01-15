<?php
require __DIR__."/../../config/config.php";
header('Content-Type: application/json');
postRequest();
$response=register($connection,'writer');
echo json_encode($response);
exit;
?>