<?php 
session_start();
include 'db.php'; 

// Security: Only allow Admin role
if (!isset($_SESSION['uid']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - SmashZone</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; display: flex; margin: 0; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; padding: 20px; }
        .sidebar a { color: #bdc3c7; text-decoration: none; display: block; padding: 10px; margin: 5px 0; border-radius: 5px; }
        .sidebar a:hover { background: #34495e; color: #27ae60; }
        .content { flex: 1; padding: 40px; }
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-card h3 { margin: 0; color: #7f8c8d; font-size: 0.9rem; }
        .stat-card p { font-size: 1.8rem; font-weight: bold; margin: 10px 0 0; color: #2c3e50; }
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #27ae60; color: white; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🛠 Admin</h2>
        <a href="admin_panel.php">Dashboard Overview</a>
        <a href="dashboard.php">View as User</a>
        <a href="logout.php" style="color:#ff7675;">Logout</a>
    </div>

    <div class="content">
        <h1>Overview</h1>
        <div class="stat-grid">
            <div class="stat-card">
                <h3>Total Players</h3>
                <p><?php echo $conn->query("SELECT count(*) FROM users WHERE role='user'")->fetch_row()[0]; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <p><?php echo $conn->query("SELECT count(*) FROM bookings")->fetch_row()[0]; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <p>RM <?php echo number_format($conn->query("SELECT SUM(amount) FROM transactions")->fetch_row()[0], 2); ?></p>
            </div>
        </div>

        <h2>Recent Transactions</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
            </tr>
            <?php
            $res = $conn->query("SELECT users.fullname, transactions.amount, transactions.payment_method, transactions.created_at 
                                 FROM transactions JOIN users ON transactions.user_id = users.id 
                                 ORDER BY created_at DESC");
            while($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['fullname']}</td>
                        <td>RM {$row['amount']}</td>
                        <td>{$row['payment_method']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>