USE BookBuddy;
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL, 
    username VARCHAR(50) NOT NULL,     
    email VARCHAR(150) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL,     
    profileImage VARCHAR(255) DEFAULT NULL,   
    role ENUM('user','writer','moderator','admin') DEFAULT 'user', 
    subscribed ENUM('subscribed','unsubscribed') DEFAULT 'unsubscribed';,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
UPDATE user 
SET profileImage = 'man1.png'
WHERE username = 'writer1';
SELECT * FROM user;
INSERT INTO user (
    fullname,
    username,
    email,
    password,
    role,
    subscribed
) VALUES (
    'Demo Writer',
    'writer1',
    'writer1@example.com',
    '$2y$10$zPzTgM4fLf9j5dJhNLQWruk5cnu8YzuhLxBFLRs1urWnJkW7FX246',
    'writer',
    'unsubscribed'
);

SELECT *
FROM book b
WHERE b.Discount_Percentage IS NOT NULL
  AND b.id NOT IN (
      SELECT book_id 
      FROM deals
  );


CREATE TABLE Subscribe{
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL
    status ENUM('unsubscribed' 'subscribe');
}
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * FROM categories;

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
SELECT * FROM book;

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

SELECT * FROM deals;
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




INSERT INTO posts (
    title,
    para_1,
    para_2,
    para_3,
    thumbnail,
    author_id
) VALUES
(
    'Why Daily Reading Improves Your Mind',
    'Reading every day helps strengthen focus and improves memory by constantly engaging the brain.',
    'Book reading also reduces stress and allows the mind to relax by entering different fictional or informational worlds.',
    'Making reading a daily habit can slowly improve thinking skills, vocabulary, and emotional understanding.',
    'news-1.avif',
    4
),
(
    'Benefits of Reading Before Sleeping',
    'Spending a few minutes reading before sleep helps calm the brain after a long busy day.',
    'Unlike mobile screens, books do not disturb your natural sleep cycle and help you fall asleep peacefully.',
    'A consistent bedtime reading habit can improve sleep quality and mental clarity the next morning.',
    'news-2.webp',
    4
),
(
    'How Books Help Build Strong Vocabulary',
    'Books expose readers to new words that are not normally used in daily conversation.',
    'When these words are seen in different contexts repeatedly, they become part of natural language use.',
    'Over time, reading improves communication skills, confidence, and academic or professional writing abilities.',
    'news-3.jpg',
    4
),
(
    'Reading vs Watching: Which is Better for Learning?',
    'Watching videos is easy, but reading forces the brain to actively imagine, think, and analyze information.',
    'Books help develop deeper understanding because the reader controls the pace of learning.',
    'Both are useful, but reading is more powerful for long-term knowledge and critical thinking skills.',
    'news-4.jpg',
    4
);
