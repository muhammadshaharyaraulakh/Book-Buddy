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
    $book_id=$_POST['bookId'];
    $discount = NULL;

    // --- VALIDATION ---
    if (empty($id)) {
        $response['field'] = 'id';
        throw new Exception("Please select a book");
    }

    // Reset discount in book table
    $update = $connection->prepare("
        UPDATE book 
        SET Discount_Percentage = :discount
        WHERE id = :book_id
    ");
    $update->execute([
        ':discount' => $discount,
        ':book_id' => $book_id
    ]);

    // Delete deal from deals table
    $delete = $connection->prepare("DELETE FROM deals WHERE book_id = :book_id AND id=:id");
    $result = $delete->execute([
        ':book_id' => $book_id,
        ':id'=>$id
    ]);

    $response = [
        "status" => "success",
        "message" => "Removed from deal successfully",
        "field" => "general"
    ];

} catch (PDOException $e) {

    $response['status']  = "error";
    $response['message'] = "Database Error: " . htmlspecialchars($e->getMessage());

} catch (Exception $e) {

    $response['status']  = "error";
    $response['message'] = htmlspecialchars($e->getMessage());
}

echo json_encode($response);
exit;
