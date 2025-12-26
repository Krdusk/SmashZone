<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    $bid = $_POST['booking_id'];
    $uid = $_SESSION['uid'];

    // Securely delete only if the booking belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $bid, $uid);
    $stmt->execute();
}
header("Location: dashboard.php");
exit();
?>