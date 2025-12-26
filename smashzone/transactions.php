<?php 
session_start();
include 'db.php'; 
if (!isset($_SESSION['uid'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Payments - SmashZone</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 12px; max-width: 900px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="card">
        <a href="dashboard.php" style="text-decoration:none;">← Back to Dashboard</a>
        <h2>💳 Transaction History</h2>
        <table>
            <thead>
                <tr><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php
                $uid = $_SESSION['uid'];
                $res = $conn->query("SELECT * FROM transactions WHERE user_id = $uid ORDER BY created_at DESC");
                while($row = $res->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['created_at']}</td>
                            <td>PHP ".number_format($row['amount'], 2)."</td>
                            <td>{$row['payment_method']}</td>
                            <td style='color:green; font-weight:bold;'>{$row['status']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>