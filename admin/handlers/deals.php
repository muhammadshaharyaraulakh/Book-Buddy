<?php
require __DIR__ . "/../../config/config.php";
header('Content-Type: application/json');

$response = [
    "status" => "error",
    "message" => "Unexpected Error Occurred",
    "field" => "general"
];

try {

    $id = $_POST['id'] ?? null;
    $percentage = $_POST['percentage'] ?? null;
    $duration = $_POST['days'] ?? null;

    // --- VALIDATION ---

    if (empty($id)) {
        $response['field'] = 'id';
        throw new Exception("Please select a book");
    }

    if (!is_numeric($percentage) || $percentage <= 0 || $percentage > 70) {
        $response['field'] = 'percentage';
        throw new Exception("Please add a valid discount percentage (1–70)");
    }

    if (!is_numeric($duration) || $duration <= 0 || $duration > 7) {
        $response['field'] = 'days';
        throw new Exception("Please add a valid duration (1–7 days)");
    }


    // --- INSERT ---
    $insert = $connection->prepare("
        INSERT INTO deals (book_id, discount_percentage, duration_days) 
        VALUES (:id, :discount, :days)
    ");

    $result = $insert->execute([
        ':id' => $id,
        ':discount' => $percentage,
        ':days' => $duration
    ]);
      
    if ($result) {
        $update = $connection->prepare("
    UPDATE book 
    SET Discount_Percentage = :discount
    WHERE id = :id
");
$update->execute([
   ':discount' => $percentage,
   ':id' => $id
]);
        $response = [
            "status" => "success",
            "message" => "Deal added successfully",
            "field" => "general"
        ];
    }

} catch (PDOException $e) {

    $response['status']  = "error";
    $response['message'] = "Database Error: " . htmlspecialchars($e->getMessage());

} catch (Exception $e) {

    $response['status']  = "error";
    $response['message'] = htmlspecialchars($e->getMessage());
}

echo json_encode($response);
exit;
