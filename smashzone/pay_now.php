<?php
session_start();
include 'db.php';

if (!isset($_GET['id']) || !isset($_SESSION['uid'])) {
    header("Location: dashboard.php");
    exit();
}

$booking_id = $_GET['id'];
$fee = 250.00; // Updated fee to PHP
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment - SmashZone</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .pay-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .price { font-size: 2.5rem; color: #27ae60; font-weight: bold; margin: 20px 0; }
        .btn-confirm { background: #27ae60; color: white; border: none; width: 100%; padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="pay-card">
        <h2>Checkout</h2>
        <p>Booking ID: #<?php echo $booking_id; ?></p>
        <div class="price">PHP <?php echo number_format($fee, 2); ?></div>
        
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="hidden" name="amount" value="<?php echo $fee; ?>">
            
            <select name="method" required style="width:100%; padding:10px; margin-bottom: 20px;">
                <option value="GCash">GCash</option>
                <option value="Maya">Maya</option>
                <option value="Debit/Credit">Debit/Credit Card</option>
            </select>
            
            <button type="submit" class="btn-confirm">Confirm Payment</button>
        </form>
        <br>
        <a href="dashboard.php" style="color:#7f8c8d; text-decoration:none;">Cancel</a>
    </div>
</body>
</html>