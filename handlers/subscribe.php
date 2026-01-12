<?php
require __DIR__."/../config/config.php";
header('Content-Type: application/json');

$response = [
    "status" => "error",
    "message" => "Unexpected Error Occurred",
    "field" => "general"
];

try {
    $gmail = trim($_POST['email'] ?? '');

    if (empty($gmail) || $_SESSION['email'] !== $gmail) {
        throw new Exception("Enter a valid Gmail");
    }

    $check = $connection->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
    $check->execute([':email' => $gmail]);
    $result = $check->fetch(PDO::FETCH_OBJ);

    if (!$result) {
        throw new Exception("Gmail does not exist. Please register an account.");
    } elseif ($result->subscribed === "subscribed") {
        throw new Exception("You have already subscribed to the newsletter.");
    } else {
        // Correct UPDATE query
        $update = $connection->prepare("
            UPDATE user 
            SET subscribed = 'subscribed' 
            WHERE email = :email
        ");
        $update->execute([':email' => $gmail]);

        $response = [
            "status" => "success",
            "message" => "Subscribed successfully",
            "field" => "general"
        ];
    }

} catch (PDOException $e) {
    $response['status'] = "error";
    $response['message'] = "Database Error: " . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    $response['status'] = "error";
    $response['message'] = htmlspecialchars($e->getMessage());
}

echo json_encode($response);
exit;
?>
