<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BookStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assests/css/a.css">
</head>
<body>
    
    <div class="overlay" id="overlay"></div>

    <div class="wrapper">
        
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="https://via.placeholder.com/40" alt="Logo">
                    <div class="logo-text">
                        <h3>BookStore</h3>
                        <small>Admin Panel</small>
                    </div>
                </div>
                <button id="close-sidebar"><i class="fas fa-times"></i></button>
            </div>

            <ul class="components">
                <li class="active"><a href="/dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="/admin/adminPages/book.php"><i class="fas fa-book"></i> Books</a></li>
                <li><a href="/admin/adminPages/addBook.php"><i class="fas fa-plus-circle"></i> Add Book</a></li>
                <li><a href="/admin/adminPages/categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="/admin/adminPages/dailyDeal.php"><i class="fas fa-clock"></i> Daily Deal</a></li>
                <li><a href="/admin/adminPages/order.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="/moderators.html"><i class="fas fa-users-cog"></i> Moderators</a></li>
                <li><a href="/admin/adminPages/addWriter.php">Manage Writer</a></li>
            </ul>
        </nav>