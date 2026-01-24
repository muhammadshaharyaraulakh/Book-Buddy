<?php
session_start();
require_once __DIR__ . "/../config/config.php";

header('Content-Type: application/json');

$response = [
    "status"  => "error",
    "message" => "Unexpected error occurred",
    "field"   => "general"
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = "Invalid request";
    echo json_encode($response);
    exit;
}

try {

    // --- AUTH CHECK ---
    if (!isset($_SESSION['id'])) {
        throw new Exception("Please login to add address");
    }

    $user_id = $_SESSION['id'];

    // --- INPUTS (FROM SELECTS + TEXTAREA) ---
    $province = trim($_POST['province'] ?? '');
    $city     = trim($_POST['city'] ?? '');
    $postcode = trim($_POST['postcode'] ?? '');
    $address  = trim($_POST['address'] ?? '');
     $contact  = trim($_POST['contact'] ?? '');

    // --- VALIDATION (ALL REQUIRED) ---
    if ($province === '') {
        throw new Exception("Please select province");
    }

    if ($city === '') {
        throw new Exception("Please select city");
    }

    if ($postcode === '') {
        throw new Exception("Please select postal code");
    }

    if ($address === '') {
        throw new Exception("Address is required");
    }
    if($contact ===''){
        throw new Exception("Contact is empty");
        
    }
    if(strlen($contact)!==11){
        throw new Exception("Contact will be of 11 Words");
        
    }
    // --- INSERT ADDRESS ---
    $stmt = $connection->prepare(
        "INSERT INTO user_address
         (user_id, province, city, postcode, address,contact)
         VALUES (:uid, :province, :city, :postcode, :address,:contact)"
    );

    $stmt->execute([
        ':uid'      => $user_id,
        ':province' => $province,
        ':city'     => $city,
        ':postcode' => $postcode,
        ':address'  => $address,
        ':contact'  => $contact
        ]);

    // --- SUCCESS ---
    $response = [
        "status"  => "success",
        "message" => "Address added successfully"
    ];

} catch (Exception $e) {

    $response['status']  = "error";
    $response['message'] = $e->getMessage();
    $response['field']   = "general";
}

echo json_encode($response);
exit;
