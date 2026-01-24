<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../includes/header.php";
require __DIR__."/../handlers/cartDetails.php";
?>
<link rel="stylesheet" href="/assests/css/filter.css">

      <section class="checkout-section page">
        <h2>Checkout</h2>
        <div class="main">
          <div class="checkout-form">
            <h4>Billing & Shipping Address</h4>
            <form action="" method="post">
        <div class="form-container">
            
            <div class="form-control Country-field">
                <select id="province" class="select-box" style="border: 1px solid #f0f0f0;padding: 5px 10px;height: 45px;border-radius: 5px;width: 100%; outline: none;">
                    <option value="">Select Province</option>
                    <option value="PB">Punjab</option>
                    <option value="SD">Sindh</option>
                    <option value="KP">KPK</option>
                    <option value="BA">Balochistan</option>
                    <option value="IS">Islamabad</option>
                </select>
            </div>

            <div class="input-field" style="margin-top: 10px;">
                <select id="city" style="border: 1px solid #f0f0f0;padding: 5px 10px;height: 45px;border-radius: 5px;width: 100%; outline: none;" disabled>
                    <option value="">Select City</option>
                </select>
            </div>

            <div class="input-field" style="margin-top: 10px;">
                <select id="postcode" style="border: 1px solid #f0f0f0;padding: 5px 10px;height: 45px;border-radius: 5px;width: 100%; outline: none;" disabled>
                    <option value="">Select Postcode</option>
                </select>
            </div>

            <button type="button" style="margin-top: 15px; padding: 10px 20px;">Add Address</button>
        </div>
    </form>
          </div>
          <div class="your-order">
            <h4>Your Order</h4>
            <div class="order-table">
              <table cellspacing="0">
                <tr class="heading">
                  <th>Image</th>
                  <th> Name</th>
                  <th>Total</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                  <?php
                    $price = ($item->Discount_Percentage === NULL) ? $item->Original_Price : $item->Discount_Price;
                    $lineTotal = $price * $item->quantity;
                ?>
                <tr>
                  <td>
                    <img src="/images/<?= htmlspecialchars($item->coverImage) ?>" alt="img">
                  </td>
                  <td><?= htmlspecialchars($item->title) ?></td>
                   <td><?= htmlspecialchars($lineTotal) ?> $</td>
                </tr>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>
      </section>
      <section class="detail-payment">
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
            <button><a href="/pages/checkout.php">Proceed To Checkout</a></button>
        </div>
    </div>
        <div class="payment-section">
          <h4>Payment Method</h4>
          <div class="payment-form">
            <div class="payment-option">
              <select>
                <option>Paytm</option>
                <option>Credit Card</option>
                <option>Debit Card</option>
                <option>Cash On Delivery</option>
              </select>
            </div>
            <div class="card-name">
              <input type="text" placeholder="Card Holder Name">
            </div>
            <div class="card-no">
              <input type="text" placeholder="Card Number">
            </div>
            <div class="card-meta">
              <input type="text" placeholder="MM/YY" onfocus="(this.type='month')">
              <input type="text" placeholder="CVV">
              <input type="text" placeholder="Postal">
            </div>
            <button>Place Order Now</button>
          </div>
        </div>
      </section>
<?php
require __DIR__."/../includes/footer.php";
?>