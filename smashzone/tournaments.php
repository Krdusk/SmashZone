<?php 
session_start();
include 'db.php'; 

// Redirect if not logged in
if (!isset($_SESSION['uid'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments - SmashZone</title>
    <style>
        :root {
            --primary-green: #27ae60;
            --dark-blue: #2c3e50;
            --accent-gold: #f1c40f;
            --light-bg: #f4f7f6;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: var(--light-bg); 
            margin: 0; 
            padding: 0;
        }

        header {
            background: var(--dark-blue);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1000px;
            margin: -30px auto 50px auto;
            padding: 0 20px;
        }

        .nav-back {
            display: inline-block;
            margin-bottom: 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            background: rgba(255,255,255,0.1);
            padding: 8px 15px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .nav-back:hover { background: var(--primary-green); }

        .tournament-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .tournament-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            border-top: 5px solid var(--primary-green);
        }

        .tournament-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .card-body { padding: 25px; }

        .date-badge {
            display: inline-block;
            background: #e8f5e9;
            color: var(--primary-green);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tournament-name {
            font-size: 1.4rem;
            color: var(--dark-blue);
            margin: 10px 0;
            display: block;
        }

        .description {
            color: #7f8c8d;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .join-btn {
            display: block;
            width: 100%;
            text-align: center;
            background: var(--primary-green);
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .join-btn:hover { background: #219150; }

        .empty-state {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            color: #95a5a6;
        }
    </style>
</head>
<body>

    <header>
        <a href="dashboard.php" class="nav-back">← Back to Dashboard</a>
        <h1>🏆 SmashZone Tournaments</h1>
        <p>Challenge the best. Claim the trophy.</p>
    </header>

    <div class="container">
        <div class="tournament-grid">
        <?php
        $t = $conn->query("SELECT * FROM tournaments ORDER BY event_date ASC");
        
        if ($t->num_rows > 0) {
            while ($row = $t->fetch_assoc()) {
                // Formatting the date nicely
                $date = date('M d, Y', strtotime($row['event_date']));
                ?>
                <div class="tournament-card">
                    <div class="card-body">
                        <span class="date-badge">📅 <?php echo $date; ?></span>
                        <b class="tournament-name"><?php echo htmlspecialchars($row['name']); ?></b>
                        <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                        <a href="#" class="join-btn" onclick="alert('Registration for <?php echo htmlspecialchars($row['name']); ?> is coming soon!')">Register Now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='empty-state'><h3>No upcoming tournaments. Check back later!</h3></div>";
        }
        ?>
        </div>
    </div>

</body>
</html>