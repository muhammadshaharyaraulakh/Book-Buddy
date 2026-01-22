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
SELECT * FROM book WHERE  category_id='3';

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

