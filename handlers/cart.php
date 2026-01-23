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
        throw new Exception("Please login to add items to cart");
    }

    $user_id  = $_SESSION['id'];
    $book_id  = $_POST['bookId'] ?? '';
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $MAX_LIMIT = 10;

    // --- VALIDATION (LOGIC UNCHANGED) ---
    if (empty($book_id)) {
        throw new Exception("Invalid item");
    }

    if ($quantity <= 0) {
        throw new Exception("Quantity must be at least 1");
    }

    if ($quantity > $MAX_LIMIT) {
        throw new Exception("You cannot add more than 10 items");
    }

    // --- CHECK EXISTING CART ITEM ---
    $checkStmt = $connection->prepare(
        "SELECT id, quantity FROM cart WHERE user_id = :uid AND book_id = :bid"
    );
    $checkStmt->execute([
        ':uid' => $user_id,
        ':bid' => $book_id
    ]);

    $existingCartItem = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingCartItem) {
        // SCENARIO A: UPDATE
        $newTotalQuantity = $existingCartItem['quantity'] + $quantity;

        if ($newTotalQuantity > $MAX_LIMIT) {
            throw new Exception(
                "You already have {$existingCartItem['quantity']} in cart. Total cannot exceed 10."
            );
        }

        $updateStmt = $connection->prepare(
            "UPDATE cart SET quantity = :qty, updated_at = NOW() WHERE id = :id"
        );
        $updateStmt->execute([
            ':qty' => $newTotalQuantity,
            ':id'  => $existingCartItem['id']
        ]);

    } else {
        // SCENARIO B: INSERT
        $insertStmt = $connection->prepare(
            "INSERT INTO cart (user_id, book_id, quantity) VALUES (:uid, :bid, :qty)"
        );
        $insertStmt->execute([
            ':uid' => $user_id,
            ':bid' => $book_id,
            ':qty' => $quantity
        ]);
    }

    // --- SUCCESS ---
    $response = [
        "status"  => "success",
        "message" => "Item added to cart"
    ];

} catch (Exception $e) {
    $response['status']  = "error";
    $response['message'] = $e->getMessage();
    $response['field']   = "general";
}

echo json_encode($response);
exit;
