<?php
session_start();
include 'db.php';

// --- REGISTRATION LOGIC ---
if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $password, $role);

    if ($stmt->execute()) {
        header("Location: index.html?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }
}

// --- LOGIN LOGIC ---
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['uid'] = $user['id'];
        $_SESSION['name'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin_panel.php");
        } else {
            // REDIRECT TO THE SECURE HOME PHP PAGE
            header("Location: home.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid email or password'); window.location='index.html';</script>";
    }
}
?>