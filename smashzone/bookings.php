<?php include '../db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>All Bookings</h2>
<a href="dashboard.php">Back</a>

<table>
<tr>
<th>User</th>
<th>Court</th>
<th>Date</th>
<th>Time</th>
<th>Payment</th>
</tr>

<?php
$result = $conn->query("
SELECT users.fullname, courts.name, booking_date, time_slot, payment_status
FROM bookings
JOIN users ON bookings.user_id = users.id
JOIN courts ON bookings.court_id = courts.id
");

while ($b = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$b['fullname']}</td>
    <td>{$b['name']}</td>
    <td>{$b['booking_date']}</td>
    <td>{$b['time_slot']}</td>
    <td>{$b['payment_status']}</td>
    </tr>";
}
?>
</table>

</body>
</html>
