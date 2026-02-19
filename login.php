<?php
session_start(); // Start a session to keep the user logged in
require 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    // 1. Check if the user exists
    $sql = "SELECT * FROM users WHERE mobile_number = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mobile]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Verify the password against the hashed password in the DB
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct!
            
            // 3. Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];

            echo "Login successful! Redirecting to OTP verification...";
            // Here is where you would redirect to your OTP entry page
            // header("Location: otp_verify.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
