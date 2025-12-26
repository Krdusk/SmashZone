<?php 
session_start();
include 'db.php'; 

// 1. SECURITY: If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['uid'])) {
    header("Location: index.html");
    exit();
}

// 2. SYNC DATA: Get the user's first name for a personalized greeting
$display_name = isset($_SESSION['name']) ? explode(' ', $_SESSION['name'])[0] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmashZone - Elite Badminton Booking</title>
    <style>
        :root {
            --primary: #27ae60;
            --dark: #2c3e50;
            --light: #f4f7f6;
        }

        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: var(--light); }

        /* Navigation */
        nav {
            background: var(--dark);
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .logo { font-size: 1.8rem; font-weight: bold; color: var(--primary); }
        .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; }
        .user-welcome { color: var(--primary); font-weight: bold; margin-right: 10px; }

        /* Slideshow Container */
        .slideshow-container {
            max-width: 100%;
            position: relative;
            height: 500px;
            overflow: hidden;
            background: #000;
        }

        .slide {
            display: none;
            height: 100%;
            text-align: center;
            padding: 100px 20px;
            box-sizing: border-box;
            color: white;
            background-size: cover;
            background-position: center;
            animation: fade 1.5s;
        }

        /* Slide Content Overlay */
        .slide-content {
            background: rgba(0, 0, 0, 0.6);
            display: inline-block;
            padding: 30px;
            border-radius: 15px;
            margin-top: 50px;
        }

        @keyframes fade { from {opacity: .4} to {opacity: 1} }

        /* Features Section */
        .features {
            padding: 60px 50px;
            text-align: center;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: white; padding: 40px; border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s;
        }

        .feature-card:hover { transform: translateY(-10px); }
        .feature-card h3 { color: var(--dark); margin-bottom: 15px; }

        .btn {
            display: inline-block; padding: 12px 25px; background: var(--primary);
            color: white; text-decoration: none; border-radius: 5px;
            font-weight: bold; margin-top: 15px;
        }
        .btn:hover { background: #219150; }
    </style>
</head>
<body>

<nav>
    <div class="logo">🏸 SmashZone</div>
    <div class="nav-links">
        <span class="user-welcome">Hello, <?php echo htmlspecialchars($display_name); ?>!</span>
        <a href="dashboard.php">📊 Dashboard</a>
        <a href="transactions.php">💳 Payments</a>
        <a href="logout.php" style="color: #ff7675;">🚪 Logout</a>
    </div>
</nav>

<div class="slideshow-container">
    <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1626225967045-2c3cb0822168?q=80&w=2070');">
        <div class="slide-content">
            <h1>Professional Court Booking</h1>
            <p>Reserve your favorite court in seconds with our real-time availability system.</p>
        </div>
    </div>

    <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1521537634581-0dced2fee2ef?q=80&w=2070');">
        <div class="slide-content">
            <h1>Thrilling Tournaments</h1>
            <p>Join local championships and climb the SmashZone leaderboard.</p>
        </div>
    </div>

    <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=2070');">
        <div class="slide-content">
            <h1>Secure Payments</h1>
            <p>Experience hassle-free transactions with our encrypted payment gateway.</p>
        </div>
    </div>
</div>

<div class="features">
    <h2>Explore Our Features</h2>
    <div class="feature-grid">
        <div class="feature-card">
            <h3>Court Booking</h3>
            <p>Select time slots, check court availability, and manage your schedules.</p>
            <a href="dashboard.php" class="btn">Book Now</a>
        </div>

        <div class="feature-card">
            <h3>Tournament Hub</h3>
            <p>Stay updated on upcoming events and register to compete for glory.</p>
            <a href="tournaments.php" class="btn">Join Event</a>
        </div>

        <div class="feature-card">
            <h3>Payment Records</h3>
            <p>Access your full transaction history and digital receipts anytime.</p>
            <a href="transactions.php" class="btn">View History</a>
        </div>
    </div>
</div>

<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("slide");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        slides[slideIndex-1].style.display = "block";  
        setTimeout(showSlides, 4000); 
    }
</script>

</body>
</html>