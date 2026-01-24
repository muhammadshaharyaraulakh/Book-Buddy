USE BookBuddy;
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL, 
    username VARCHAR(50) NOT NULL,     
    email VARCHAR(150) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL,     
    profileImage VARCHAR(255) DEFAULT NULL,   
    role ENUM('user','writer','moderator','admin') DEFAULT 'user', 
    subscribed ENUM('subscribed','unsubscribed') DEFAULT 'unsubscribed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * FROM categories;
SELECT b.*
FROM book b
JOIN categories c 
  ON b.category_id = c.id
WHERE c.title = 'Featured Books';

CREATE TABLE book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    ISBN VARCHAR(20) DEFAULT NULL,
    publishDate DATE,
    Publisher VARCHAR(255) NOT NULL,
    Original_Price INT NOT NULL,
    Discount_Percentage INT,
    Discount_Price INT 
    AS (ROUND(Original_Price * (100 - IFNULL(Discount_Percentage,0)) / 100)) 
    STORED,
    Stock INT NOT NULL,
    description_para_1 TEXT NOT NULL,
    description_para_2 TEXT,
    coverImage VARCHAR(255) NOT NULL,
    category_id INT,
    totalSales INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
SELECT * FROM book; WHERE  category_id='3';

CREATE TABLE deals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    discount_percentage INT NOT NULL,
    start_date DATE NOT NULL DEFAULT (CURRENT_DATE),
    duration_days INT NOT NULL,
    end_date DATE 
GENERATED ALWAYS AS (DATE_ADD(start_date, INTERVAL duration_days DAY)),
    FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE
);


CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    ratings INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    para_1 TEXT NOT NULL, 
    para_2 TEXT NOT NULL, 
    para_3 TEXT NOT NULL,     
    thumbnail VARCHAR(255) NOT NULL,
    author_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES user(id) ON DELETE CASCADE
);

INSERT INTO reviews (body, book_id, user_id, ratings) VALUES
-- Book 1
('Great book, very easy to read.', 1, 1, 5),
('Helpful and informative.', 1, 2, 4),
('Good content overall.', 1, 3, 4),
('Worth reading.', 1, 4, 4),
('Enjoyed this book.', 1, 5, 5),
('Simple and clear.', 1, 6, 4),
('Average but useful.', 1, 7, 3),
('Well written.', 1, 8, 4),
('Nice experience.', 1, 9, 4),
('Decent book.', 1, 10, 3),

-- Book 2
('Interesting and engaging.', 2, 1, 5),
('Good storytelling.', 2, 2, 4),
('Enjoyable read.', 2, 3, 4),
('Loved the writing.', 2, 4, 5),
('Nice concepts.', 2, 5, 4),
('Pretty good.', 2, 6, 4),
('Could be better.', 2, 7, 3),
('Fun to read.', 2, 8, 5),
('Recommended.', 2, 9, 5),
('Good effort.', 2, 10, 4),

-- Book 3
('Very informative.', 3, 1, 4),
('Easy explanations.', 3, 2, 4),
('Helpful content.', 3, 3, 4),
('Well structured.', 3, 4, 5),
('Clear and simple.', 3, 5, 4),
('Good for beginners.', 3, 6, 4),
('Average read.', 3, 7, 3),
('Nicely explained.', 3, 8, 5),
('Worth the time.', 3, 9, 4),
('Solid book.', 3, 10, 4),

-- Book 4
('Excellent book.', 4, 1, 5),
('Loved the details.', 4, 2, 5),
('Good but long.', 4, 3, 3),
('Very educational.', 4, 4, 4),
('Highly recommended.', 4, 5, 5),
('Simple language.', 4, 6, 4),
('Needs improvement.', 4, 7, 3),
('Great explanations.', 4, 8, 5),
('Engaging content.', 4, 9, 4),
('Nice read.', 4, 10, 4),

-- Book 5
('Impressive work.', 5, 1, 5),
('Helpful guide.', 5, 2, 4),
('Easy to follow.', 5, 3, 4),
('Some repetition.', 5, 4, 3),
('Good insights.', 5, 5, 4),
('Beginner friendly.', 5, 6, 4),
('Average quality.', 5, 7, 3),
('Loved examples.', 5, 8, 5),
('Well written.', 5, 9, 4),
('Decent book.', 5, 10, 3),

-- Book 6
('Excellent resource.', 6, 1, 5),
('Very useful.', 6, 2, 4),
('Clear concepts.', 6, 3, 4),
('Could be shorter.', 6, 4, 3),
('Nice learning book.', 6, 5, 4),
('Well organized.', 6, 6, 4),
('Not very engaging.', 6, 7, 2),
('Loved the clarity.', 6, 8, 5),
('Highly recommended.', 6, 9, 5),
('Good overall.', 6, 10, 4);


CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE
);
CREATE TABLE coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,        -- coupon code
    discount_percentage INT NOT NULL CHECK (discount_percentage BETWEEN 1 AND 100), 
    status ENUM('active', 'disabled') DEFAULT 'active', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart_coupon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,                    -- which user applied this coupon
    coupon_id INT NOT NULL,                  -- FK to coupons table
    coupon_discount INT NOT NULL,            -- discount percentage at time of apply
    status ENUM('applied','notApplied') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
);

INSERT INTO coupons (code, discount_percentage)
VALUES
('SAVE10', 10),
('BOOK20', 20),
('NEW30', 30);

CREATE TABLE user_address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    province VARCHAR(50) NOT NULL,
    city VARCHAR(100) NOT NULL,
    postcode VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    contact VARCHAR(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES user(id)
        ON DELETE CASCADE
);

