<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../includes/header.php";

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
$allTotal = round($allTotal, 2);
?>

<link rel="stylesheet" href="/assests/css/filter.css">

<section class="cart-item page">
    <h2>Book Cart</h2>
    <div class="product-table">
        <table cellspacing="0">
            <tr class="heading">
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>

            <?php foreach ($cartItems as $item): ?>
                <?php
                    $price = ($item->Discount_Percentage === NULL) ? $item->Original_Price : $item->Discount_Price;
                    $lineTotal = $price * $item->quantity;
                ?>
                <tr class="data">
                    <td>
                        <img src="/images/<?= htmlspecialchars($item->coverImage) ?>" alt="">
                    </td>
                    <td><?= htmlspecialchars($item->title) ?></td>
                    <td><?= htmlspecialchars($price) ?> $</td>
                    <td>
                        <div class="input-group">
                            <div class="quantity">
                                <input
                                    type="text"
                                    value="<?= (int)$item->quantity ?>"
                                    class="quantity-field"
                                    style="width: 4.5rem"
                                    readonly
                                />
                            </div>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($lineTotal) ?> $</td>
                    <td><i class="fa-solid fa-pencil"></i></td>
                    <td><button class="btn">Update</button></td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</section>

<section class="discount-summary">
    <div class="discount-section">
        <h4>Discount Coupon</h4>
        <form action="/handlers/coupon.php" method="post">
            <div class="discount-form">
                <input type="text" placeholder="Enter Coupon Code" name="coupon" style="text-transform: uppercase;">
                <button>Apply Coupon</button>
            </div>
            <?php if($couponRow): ?>
                <p>Applied Coupon: <strong><?= htmlspecialchars($couponRow->coupon_code) ?> (<?= $couponPercentage ?>%)</strong></p>
            <?php endif; ?>
        </form>
    </div>

    <div class="summary-section">
        <h4>Cart Subtotal</h4>
        <div class="order-detail-table">
            <table>
                <tr>
                    <td>Order Subtotal</td>
                    <td><?= htmlspecialchars($allTotal) ?>$</td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td><?= $shipping ?>$</td>
                </tr>
                <tr>
                    <td>Coupon</td>
                    <td><?= htmlspecialchars($couponAmount) ?>$</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?= htmlspecialchars($total) ?>$</td>
                </tr>
            </table>
            <button><a href="checkout.html">Proceed To Checkout</a></button>
        </div>
    </div>
</section>

<?php 
require __DIR__."/../includes/footer.php";
?>
