<?php include '../db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Courts</h2>
<a href="dashboard.php">Back</a>

<ul>
<?php
$courts = $conn->query("SELECT * FROM courts");
while ($c = $courts->fetch_assoc()) {
    echo "<li>{$c['name']} - {$c['status']}</li>";
}
?>
</ul>

</body>
</html>
