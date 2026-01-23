<?php
require_once __DIR__ . "/../config/config.php";

require_once __DIR__ . "/../includes/header.php";
if (isset($_GET)) {
  $id = $_GET['id'];
  if (empty($id)) {
    header('Location :/index.php');
    exit();
  }
  $fetchBookDetail = $connection->prepare('SELECT * FROM book  WHERE id=:id LIMIT 1');
  $fetchBookDetail->execute([
    'id' => $id
  ]);
  $book = $fetchBookDetail->fetch(PDO::FETCH_OBJ);

  $fetchReviews = $connection->prepare('
      SELECT r.*, u.fullname, u.profileImage 
      FROM reviews r 
      JOIN user u ON r.user_id = u.id 
      WHERE r.book_id = :id 
      ORDER BY r.created_at DESC 
      LIMIT 4
  ');
  $fetchReviews->execute(['id' => $id]);
  $reviews = $fetchReviews->fetchAll(PDO::FETCH_OBJ);
$totalReviews = $fetchReviews->rowCount();



  // ... existing code ...

  // Calculate Overall Rating & Total Count
  $avgQuery = $connection->prepare('SELECT AVG(ratings) as avg_rating, COUNT(*) as total FROM reviews WHERE book_id = :id');
  $avgQuery->execute(['id' => $id]);
  $ratingData = $avgQuery->fetch(PDO::FETCH_OBJ);

  // Format rating (e.g., 4.5) or default to 0 if no reviews
  $overallRating = $ratingData->avg_rating ? number_format($ratingData->avg_rating, 1) : '0.0';
  $totalCount = $ratingData->total;

  $onSale = $connection->prepare("SELECT *
FROM book b
WHERE b.Discount_Percentage IS NOT NULL
  AND b.id NOT IN (
      SELECT book_id 
      FROM deals
  );
");
  $onSale->execute();
  $sales = $onSale->fetchAll(PDO::FETCH_OBJ);
}
?>
<link rel="stylesheet" href="/assests/css/filter.css">
<div class="breadcrumb-container">
  <ul class="breadcrumb">
    <li><a href="/index.php">Home</a></li>
    <li><a href="/pages/book-filter.php" style="color: #6c5dd4">Books</a></li>
    <li><a href="#"><?= $book->title ?></a></li>
  </ul>
</div>

<section class="book-overview">
  <div class="img">
    <img src="/images/<?= $book->coverImage ?>" alt="" />
  </div>
  <div class="book-content">
    <h4><?= $book->title ?></h4>
    <div class="meta">
      <div class="review">
        <div class="rating">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <span>4.0</span>
        </div>
        <div class="comment-like">
          <small><img src="../images/comment.png" alt="" /> <span><?= htmlspecialchars($totalReviews) ?></span></small>
        </div>
      </div>
      <div class="social-btn">
        <a href=""><i class="fa-brands fa-facebook-f"></i>Facebook</a>
        <a href=""><i class="fa-brands fa-twitter"></i>Twitter</a>
        <a href=""><i class="fa-brands fa-whatsapp"></i>Whatsapp</a>
        <a href=""><i class="fa-regular fa-envelope"></i>Email</a>
      </div>
    </div>
    <p>
      Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis
      aperiam ipsam nemo, excepturi atque nam recusandae obcaecati cum eius
      harum dolorum, maiores quasi repellat officiis debitis, possimus
      impedit doloremque id?
      <?= $book->description_para_1 ?>
    </p>
    <p>
      <?= $book->description_para_2 ?>
    </p>
    <div class="footer">
      <div class="author-detail">
        <div class="author">
          <small>Written by</small>
          <strong><?= $book->author ?></strong>
        </div>
        <div class="publisher">
          <small>Publisher</small>
          <strong><?= $book->Publisher ?></strong>
        </div>
        <div class="year">
          <small>Year</small>
          <strong><?php
                  $date_string = $book->publishDate;
                  $year = date('Y', strtotime($date_string));
                  echo $year;
                  ?> </strong>
        </div>
      </div>
      <div class="badge">

        <?php
        if ($book->Stock !== '0'): ?>
          <span><i class="fa-solid fa-shield"></i>in stocks</span>
        <?php else: ?>
          <span><i class="fa-solid fa-shield"></i>Out of stocks</span>
        <?php endif; ?>

      </div>
    </div>
    <div class="book-price">
      <div class="price">
        <?php if ($book->Discount_Price !== NULL): ?>
          <strong><?= $book->Discount_Price ?>$</strong>
          <strike><?= $book->Original_Price ?>$</strike>
          <span><?= $book->Discount_Percentage ?>%</span>
        <?php endif; ?>
      </div>
      <form action="/handlers/cart.php" method="post">
      <div class="input-group">
        <input type="number" name="bookId" id="book" value="<?= $book->id ?>" hidden>
        <input type="number" name="userId" id="user" value="<?php $_SESSION['id'] ?>" hidden>
        <div class="quantity">
          <input
            type="button"
            value="-"
            class="button-minus"
            data-field="quantity" />
         <input type="text" value="1" step="1" min="1" name="quantity" class="quantity-field" style="width: 4.5rem" readonly/>
          <input
            type="button"
            value="+"
            class="button-plus"
            data-field="quantity" />
        </div>
        <button class="cartbtn"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</button>
      </form>
      </div>
    </div>
  </div>
</section>
<section class="book-info">
  <div class="detail-customer">
    <div class="tabbtns">
      <button class="tablink" data-btn="detail">Details</button>
      <button class="tablink" data-btn="customer"> Reviews</button>
    </div>
    <div class="book-detail tabcontent" id="detail">
      <div class="detail-line">
        <strong>Book Title</strong><span><?= $book->title ?></span>
      </div>
      <div class="detail-line">
        <strong>Author</strong><span><?= $book->author ?></span>
      </div>
      <div class="detail-line">
        <strong>ISBN</strong><span><?= $book->ISBN ?></span>
      </div>
      <div class="detail-line">
        <strong>Edition Language</strong><span>English</span>
      </div>
      <div class="detail-line">
        <strong>Book Format</strong><span>Paperback</span>
      </div>
      <div class="detail-line">
        <strong>Date Published</strong><span><?= date('F jS Y', strtotime($book->publishDate)) ?></span>
      </div>
      <div class="detail-line">
        <strong>Publisher</strong><span><?= $book->Publisher ?></span>
      </div>
    </div>
    <div class="customer-review tabcontent" id="customer">
      <div class="rating">
        <div class="rating-info">
          <h5>Rating Information</h5>
          <p>Read genuine feedback from our community of book lovers. Discover insights on the storyline, writing style, and character depth to see if this book is your next great read.</p>
        </div>
        <div class="star">
          <small><span><?= $overallRating ?></span>out of 5</small>
          <div class="stars">
            <?php
            // Dynamic Overall Stars
            $roundedRating = round($overallRating);
            for ($i = 1; $i <= 5; $i++) {
              if ($i <= $roundedRating) {
                echo '<i class="fa-solid fa-star"></i>';
              } else {
                echo '<i class="fa-regular fa-star"></i>'; // Empty star
              }
            }
            ?>
          </div>
        </div>
      </div>

      <strong>Showing <?= count($reviews) ?> Reviews</strong>

      <div class="reviewer-container">
        <?php if (count($reviews) > 0): ?>
          <?php foreach ($reviews as $review): ?>
            <div class="review">
              <div class="img-detail">
                <?php if (!empty($review->profileImage)): ?>
                  <img src="/userImages/<?= htmlspecialchars($review->profileImage) ?>" alt="">
                <?php else: ?>
                  <img src="https://ui-avatars.com/api/?name=<?= urlencode($review->fullname) ?>&background=random&color=fff&size=128" alt="<?= $review->fullname ?>">
                <?php endif; ?>

                <div class="name">
                  <h5><?= htmlspecialchars($review->fullname) ?></h5>
                  <small><?= date('M jS, Y', strtotime($review->created_at)) ?></small>
                </div>
              </div>
              <div class="review-footer">
                <p><?= htmlspecialchars($review->body) ?></p>
                <div class="rating-star">
                  <?php
                  // Loop to display stars based on rating number
                  for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $review->ratings) {
                      echo '<i class="fa-solid fa-star"></i>';
                    } else {
                      echo '<i class="fa-regular fa-star"></i>';
                    }
                  }
                  ?>
                  <span><?= $review->ratings ?>.0</span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>

        <button>View More</button>
      </div>
    </div>
  </div>
</section>

<section class="book-sale">
  <div class="heading">
    <h4>Books On Sale</h4>
    <div class="arrowbtn">
      <i id="left" class="fa-solid fa-angle-left"></i>
      <i id="right" class="fa-solid fa-angle-right"></i>
    </div>
  </div>
  <div class="book-container">
    <div class="wrapper">
      <ul class="carousel">
        <?php foreach ($sales as $book): ?>
          <li class="card">
            <div class="img">
              <a href="/pages/book-detail.php?id=<?= $book->id ?>"><img src="/images/<?= $book->coverImage ?>" alt="book" /></a>
              <span class="badge"><?= $book->Discount_Percentage ?></span>
            </div>
            <h5><?= $book->title ?></h5>
            <div class="footer">
              <span class="star"><i class="fa fa-star"></i> 4.7</span>
              <div class="price">
                <span><?= $book->Discount_Price ?></span>
                <span><strike><?= $book->Original_Price ?></strike></span>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="service">
  <div class="service-container">
    <div class="service-card">
      <div class="icon">
        <i class="fa-solid fa-bolt-lightning"></i>
      </div>
      <div class="service-content">
        <h5>Quick Delivery</h5>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Id,
          exercitationem.
        </p>
      </div>
    </div>
    <div class="service-card">
      <div class="icon">
        <i class="fa-solid fa-shield"></i>
      </div>
      <div class="service-content">
        <h5>Secure Payment</h5>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Id,
          exercitationem.
        </p>
      </div>
    </div>
    <div class="service-card">
      <div class="icon">
        <i class="fa-solid fa-thumbs-up"></i>
      </div>
      <div class="service-content">
        <h5>Best Quality</h5>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Id,
          exercitationem.
        </p>
      </div>
    </div>
    <div class="service-card">
      <div class="icon">
        <i class="fa-solid fa-star"></i>
      </div>
      <div class="service-content">
        <h5>Return Guarantee</h5>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Id,
          exercitationem.
        </p>
      </div>
    </div>
  </div>
</section>

<section class="subscription">
  <?php if ($user->subscribed == "unsubscribed" || empty($_SESSION['id'])) : ?>
    <div class="container">
      <h4>
        Subscribe our newsletter for Latest <br />
        books updates
      </h4>
      <form action="/handlers/subscribe.php" method="post">
        <div class="input">
          <input type="text" name="email" placeholder="Type your email here" />
          <button>subscribe</button>
        </div>
      </form>
    </div>
    <div class="circle-1"></div>
    <div class="circle-2"></div>
  <?php else: ?>
    <div class="container">
      <h4>
        You are Subscribe to our newsletter for Latest <br />
        books updates.
      </h4>
      <form action="/handlers/unSubscribe.php" method="post">

        <button class="unsubscribe">UnSubscribe</button>

      </form>
    </div>
    <div class="circle-1"></div>
    <div class="circle-2"></div>
  <?php endif; ?>
</section>



<script>

 document.addEventListener("DOMContentLoaded", () => {
  const wrapper = document.querySelector(".wrapper");
  const carousel = document.querySelector(".carousel");
  const arrowBtns = document.querySelectorAll(".book-sale .arrowbtn i");

  if (!wrapper || !carousel) return;

  const cards = carousel.querySelectorAll(".card");
  if (!cards.length) return;

  let isDragging = false;
  let startX, startScrollLeft;
  let autoPlayInterval;

  const firstCardWidth = cards[0].offsetWidth;

  // Clone cards for infinite scroll
  const cardPerView = Math.max(1, Math.round(carousel.offsetWidth / firstCardWidth));
  const carouselChildren = Array.from(carousel.children);
  carouselChildren.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
  });
  carouselChildren.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
  });

  // Start at the real first card
  carousel.classList.add("no-transition");
  carousel.scrollLeft = carousel.offsetWidth;
  carousel.classList.remove("no-transition");

  // Arrow buttons
  arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      carousel.scrollBy({
        left: btn.id === "left" ? -firstCardWidth : firstCardWidth,
        behavior: "smooth"
      });
    });
  });

  // Drag events
  const dragStart = (e) => {
    isDragging = true;
    startX = e.clientX || e.touches[0].clientX;
    startScrollLeft = carousel.scrollLeft;
    carousel.classList.add("dragging");
  };

  const dragging = (e) => {
    if (!isDragging) return;
    const x = e.clientX || e.touches[0].clientX;
    const walk = x - startX;
    carousel.scrollLeft = startScrollLeft - walk;
  };

  const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
  };

  carousel.addEventListener("mousedown", dragStart);
  carousel.addEventListener("touchstart", dragStart);
  carousel.addEventListener("mousemove", dragging);
  carousel.addEventListener("touchmove", dragging);
  document.addEventListener("mouseup", dragStop);
  document.addEventListener("touchend", dragStop);
  carousel.addEventListener("dragstart", e => e.preventDefault()); // prevent image drag

  // Infinite scroll
  const infiniteScroll = () => {
    if (carousel.scrollLeft <= 0) {
      carousel.classList.add("no-transition");
      carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
      carousel.classList.remove("no-transition");
    } else if (carousel.scrollLeft >= carousel.scrollWidth - carousel.offsetWidth) {
      carousel.classList.add("no-transition");
      carousel.scrollLeft = carousel.offsetWidth;
      carousel.classList.remove("no-transition");
    }
  };
  carousel.addEventListener("scroll", infiniteScroll);

  // Auto-play with smooth scroll
  const startAutoPlay = () => {
    autoPlayInterval = setInterval(() => {
      if (!wrapper.matches(":hover")) {
        carousel.scrollBy({
          left: firstCardWidth,
          behavior: "smooth"
        });
      }
    }, 2500);
  };

  const stopAutoPlay = () => clearInterval(autoPlayInterval);

  wrapper.addEventListener("mouseenter", stopAutoPlay);
  wrapper.addEventListener("mouseleave", startAutoPlay);

  startAutoPlay();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const plusButtons = document.querySelectorAll('.button-plus');
    const minusButtons = document.querySelectorAll('.button-minus');
    const MAX_QUANTITY = 10; // Set limit

    // Handle Plus (+) Button Click
    plusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); 
            
            const container = this.closest('.quantity');
            const input = container.querySelector('.quantity-field');
            let currentVal = parseInt(input.value) || 0;
            
            // Only increment if less than MAX_QUANTITY
            if (currentVal < MAX_QUANTITY) {
                input.value = currentVal + 1;
            } else {
                // Optional: Alert user or just stop
                // alert("Maximum limit is 10 items");
                input.value = MAX_QUANTITY;
            }
        });
    });

    // Handle Minus (-) Button Click
    minusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); 
            
            const container = this.closest('.quantity');
            const input = container.querySelector('.quantity-field');
            let currentVal = parseInt(input.value) || 0;
            
            if (currentVal > 1) {
                input.value = currentVal - 1;
            } else {
                input.value = 1;
            }
        });
    });
});
</script>
<?php
require __DIR__ . "/../includes/footer.php";
?>