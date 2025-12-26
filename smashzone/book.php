<?php
session_start();
include 'db.php'; // FIXED: Changed from ../db.php to db.php

if (!isset($_SESSION['uid'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION['uid'];
    $court = $_POST['court'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Securely check if slot is taken
    $check = $conn->prepare("SELECT id FROM bookings WHERE court_id = ? AND booking_date = ? AND time_slot = ?");
    $check->bind_param("iss", $court, $date, $time);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo "<script>alert('This slot is already booked!'); window.location='dashboard.php';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, court_id, booking_date, time_slot) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $uid, $court, $date, $time);
        
        if ($stmt->execute()) {
            // Optional: Insert default transaction of RM 20.00 for the record
            $conn->query("INSERT INTO transactions (user_id, amount, payment_method) VALUES ($uid, 20.00, 'Online Banking')");
            header("Location: dashboard.php");
        }
    }
}
?>