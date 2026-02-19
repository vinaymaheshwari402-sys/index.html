<?php
require 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    // 1. Hash the password (for security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 2. Insert user into the database
    $sql = "INSERT INTO users (full_name, mobile_number, password_hash) VALUES (?, ?, ?)";
    $stmt= $pdo->prepare($sql);
    
    try {
        $stmt->execute([$full_name, $mobile, $hashed_password]);
        echo "Registration successful!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "This mobile number is already registered.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
