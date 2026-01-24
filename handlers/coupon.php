<?php
session_start();
require_once __DIR__ . "/../config/config.php";

header('Content-Type: application/json');

$response = [
    "status"  => "error",
    "message" => "Something went wrong"
];

try {

    // 🔐 Auth check
    if (!isset($_SESSION['id'])) {
        throw new Exception("Please login first");
    }

    $user_id = $_SESSION['id'];
    $code = strtoupper(trim($_POST['coupon'] ?? ''));

    // 1️⃣ Validate input
    if (empty($code)) {
        throw new Exception("Please enter a coupon code");
    }

    // 2️⃣ Check if coupon exists and is active
    $couponStmt = $connection->prepare("
        SELECT id, discount_percentage 
        FROM coupons 
        WHERE code = :code 
        AND status = 'active'
        LIMIT 1
    ");
    $couponStmt->execute([':code' => $code]);
    $coupon = $couponStmt->fetch(PDO::FETCH_OBJ);

    if (!$coupon) {
        throw new Exception("Invalid coupon code");
    }

    // 3️⃣ Check if cart has items
    $cartCheck = $connection->prepare("
        SELECT COUNT(*) AS count
        FROM cart
        WHERE user_id = :uid
    ");
    $cartCheck->execute([':uid' => $user_id]);
    $cartCount = $cartCheck->fetch(PDO::FETCH_OBJ)->count;

    if ($cartCount == 0) {
        throw new Exception("Cart is empty");
    }

    // 4️⃣ Check if user already has a coupon applied
    $userCouponCheck = $connection->prepare("
        SELECT id, status 
        FROM cart_coupon
        WHERE user_id = :uid
        LIMIT 1
    ");
    $userCouponCheck->execute([':uid' => $user_id]);
    $existing = $userCouponCheck->fetch(PDO::FETCH_OBJ);

    if ($existing && $existing->status === 'applied') {
        throw new Exception("Coupon already applied");
    }

    // 5️⃣ Apply coupon
    if ($existing) {
        // Update existing row
        $applyStmt = $connection->prepare("
            UPDATE cart_coupon
            SET coupon_id = :coupon_id,
                coupon_discount = :discount,
                status = 'applied',
                created_at = NOW()
            WHERE id = :id
        ");
        $applyStmt->execute([
            ':coupon_id' => $coupon->id,
            ':discount'  => $coupon->discount_percentage,
            ':id'        => $existing->id
        ]);
    } else {
        // Insert new row
        $applyStmt = $connection->prepare("
            INSERT INTO cart_coupon (user_id, coupon_id, coupon_discount, status)
            VALUES (:uid, :coupon_id, :discount, 'applied')
        ");
        $applyStmt->execute([
            ':uid'       => $user_id,
            ':coupon_id' => $coupon->id,
            ':discount'  => $coupon->discount_percentage
        ]);
    }

    $response = [
        "status"  => "success",
        "message" => "Coupon applied successfully ({$coupon->discount_percentage}% off)"
    ];

} catch (Exception $e) {
    $response['status']  = "error";
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;