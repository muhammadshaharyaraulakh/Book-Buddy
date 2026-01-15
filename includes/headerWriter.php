<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BookStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assests/css/admin.css">
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
                        <small>Writer Panel</small>
                    </div>
                </div>
                <button id="close-sidebar"><i class="fas fa-times"></i></button>
            </div>

            <ul class="components">
                <li class="active"><a href="/dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="/writer/profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="/writer/Blogs.php"><i class="fas fa-blog"></i> Blogs</a></li>
            </ul>
        </nav>