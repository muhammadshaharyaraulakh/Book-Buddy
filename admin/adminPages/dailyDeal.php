<?php 
require __DIR__."/../../config/config.php";
require __DIR__."/../../includes/dashboardHeader.php";

$fetch = $connection->prepare("
    SELECT * FROM book 
    WHERE Discount_Percentage IS NULL 
       OR Discount_Percentage = 0
");

$fetch->execute();
$result=$fetch->fetchAll(PDO::FETCH_OBJ);

$fetchDeals = $connection->prepare("
    SELECT 
        b.*,
        d.id AS deal_id,
        d.discount_percentage,
        d.start_date,
        d.duration_days,
        DATE_ADD(d.start_date, INTERVAL d.duration_days DAY) AS end_date
    FROM book b
    INNER JOIN deals d 
        ON b.id = d.book_id
       AND CURRENT_DATE < DATE_ADD(d.start_date, INTERVAL d.duration_days DAY)
");
$fetchDeals->execute();
$books = $fetchDeals->fetchAll(PDO::FETCH_OBJ);


?>

<div id="content">
    
    <div class="top-navbar">
        <div class="nav-left">
            <button type="button" id="sidebarCollapse" class="menu-btn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">Weekly Deal Manager</div>
        </div>
        <div class="nav-right">
            <div class="profile-preview">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <span>Admin</span>
            </div>
        </div>
    </div>


    <!-- ======================= NEW PAGE WRAPPER ======================= -->
    <div class="deal-page">

        <!-- ⭐ FORM CENTERED + MAX WIDTH ⭐ -->
        <div class="form-wrapper">
            <div class="form-container">
                <h4 class="form-title">Set New Deal</h4>

                <form method="post" action="/admin/handlers/deals.php">
                    <div class="form-group">
                        <label>Select Book</label>
                        <div class="input-wrapper">
                            
                            <select name="id">
                                <?php foreach($result as $book): ?>
                                    <option value="<?= $book->id ?>"><?= $book->title ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Discounted Percentage</label>
                        <div class="input-wrapper">
                            
                            <input type="number" name="percentage" placeholder="70%">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Duration Days</label>
                        <div class="input-wrapper">
                            
                            <input type="number" name="days" placeholder="7">

                        </div>
                    </div>
                    <?php if(count($books)==6) :?>
                    <button type="submit" class="btn-submit orange" disabled>
                        Activate Deal
                    </button>
                    <?php else: ?>
                        <button type="submit" class="btn-submit orange">
                        Activate Deal
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>


        <!-- ⭐ 4 CARDS IN RESPONSIVE GRID ⭐ -->
        <div class="deals-grid">
        <?php foreach($books as $book): ?>
        <div class="deal-preview-card">
                <h4 class="form-title">Currently Active</h4>
                <div class="deal-visual">
                    <img src="/images/<?= $book->coverImage ?>" alt="Book Cover">
                    <div class="deal-badge">-<?= $book->discount_percentage ?></div>
                </div>
                <div class="deal-info">
                    <h3><?= $book->title ?></h3>
                    <div class="price-box">
                        <span class="old-price">$<?= $book->Original_Price ?></span>
                        <span class="new-price">$<?= $book->Discount_Price ?></span>
                    </div>
                    <div class="countdown">
                        <i class="fas fa-clock"></i> Ends in: <strong><?= $book-> end_date ?></strong>
                    </div>
                    <form action="/admin/handlers/deleteDeal.php" method="post">
                        <input type="hidden" name="bookId" value="<?= $book->id ?>">
                        <input hidden name="id" value="<?= $book->deal_id ?>">
                        <button class="btn btn-danger">End Deal</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

    </div><!-- /deal-page -->

</div><!-- /content -->

<script src="/assests/js/admin.js"></script>
</body>
</html>
