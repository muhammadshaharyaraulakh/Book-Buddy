<?php
$user_id = $_SESSION['id'];

// ------------------------
// FETCH CART ITEMS
// ------------------------
$stmt = $connection->prepare("
    SELECT 
        c.id AS cart_id,
        c.quantity,
        b.*,
        cat.title AS category_name
    FROM cart c
    JOIN book b ON c.book_id = b.id
    LEFT JOIN categories cat ON b.category_id = cat.id
    WHERE c.user_id = :uid
    ORDER BY c.created_at DESC
");
$stmt->execute([':uid' => $user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_OBJ);

// ------------------------
// FETCH USER COUPON (if any)
// ------------------------
$couponStmt = $connection->prepare("
    SELECT cc.coupon_discount, cu.code AS coupon_code
    FROM cart_coupon cc
    JOIN coupons cu ON cc.coupon_id = cu.id
    WHERE cc.user_id = :uid AND cc.status='applied' LIMIT 1
");
$couponStmt->execute([':uid' => $user_id]);
$couponRow = $couponStmt->fetch(PDO::FETCH_OBJ);
$couponPercentage = $couponRow ? (int)$couponRow->coupon_discount : 0;

// ------------------------
// CALCULATE TOTALS
// ------------------------
$allTotal = 0;
$shipping = 5;

foreach ($cartItems as $item) {
    $price = ($item->Discount_Percentage === NULL || $item->Discount_Percentage == 0)
        ? $item->Original_Price
        : $item->Discount_Price;

    $allTotal += $price * $item->quantity;
}

// Apply coupon
$couponAmount = round(($allTotal * $couponPercentage) / 100, 2);
$total = round($allTotal - $couponAmount + $shipping, 2);
$allTotal = round($allTotal, 2);?>