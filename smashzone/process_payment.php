<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['uid'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];

    // 1. Mark booking as paid
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = 'completed' WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);
    
    if ($stmt->execute()) {
        // 2. Add to transaction history in PHP
        $trans = $conn->prepare("INSERT INTO transactions (user_id, amount, payment_method, status) VALUES (?, ?, ?, 'completed')");
        $trans->bind_param("ids", $user_id, $amount, $method);
        $trans->execute();
        
        header("Location: transactions.php");
        exit();
    }
}
?>