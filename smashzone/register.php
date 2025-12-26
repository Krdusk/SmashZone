<?php
// Fix the path: if register.php is in 'auth/' folder, 
// and db.php is in the main 'smashzone/' folder, '../db.php' is correct.
// However, ensure db.php actually exists in the parent folder.
include '../db.php';

// Check if the connection variable $conn exists from db.php
if (!isset($conn)) {
    die("Database connection variable '$conn' is not defined. Check your db.php file.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    // Hash the password for security
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Default role for new registrations
    $role = 'user'; 

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $password, $role);

    if ($stmt->execute()) {
        // Success: Redirect to login page
        header("Location: ../index.html?success=registered");
        exit();
    } else {
        echo "Error during registration: " . $stmt->error;
    }
    
    $stmt->close();
}
?>