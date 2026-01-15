<?php
require __DIR__ . "/../../config/config.php";
header('Content-Type: application/json');

$response = [
    "status" => "error",
    "message" => "Unexpected Error Occurred",
    "field" => "general"
];

try {

    $id = filter_input(INPUT_POST,'book_id',FILTER_VALIDATE_INT) 
   ?? filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);

    $discount = filter_input(INPUT_POST, 'discount', FILTER_VALIDATE_INT);

    if(!$id){
        throw new Exception("Invalid book id");
    }

    if($discount < 0 || $discount > 50){
        throw new Exception("Discount must be between 0 and 50%");
    }

    // Check if book exists
    $fetch = $connection->prepare("SELECT id FROM book WHERE id=:id LIMIT 1");
    $fetch->execute([':id' => $id]);

    if(!$fetch->fetch(PDO::FETCH_OBJ)){
        throw new Exception("Book not found");
    }

    $update = $connection->prepare("
        UPDATE book 
        SET Discount_Percentage = :discount
        WHERE id = :id
    ");
    
    $update->execute([
        ':discount' => $discount,
        ':id' => $id
    ]);

    $response = [
        "status" => "success",
        "message" => "Discount applied successfully"
    ];

} catch (PDOException $e) {
    $response['message'] = "DB Error: " . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    $response['message'] = htmlspecialchars($e->getMessage());
}

echo json_encode($response);
exit;
