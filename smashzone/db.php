<?php
$host = "localhost";
$user = "root";
$pass = ""; // Default WAMP password is empty
$dbname = "smashzone";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
