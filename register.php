<?php
session_start(); // Start the session
require 'db_connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data and trim whitespace
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Validate input (basic validation)
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: register.php?error=All fields are required.");
        exit();
    }

    // Check if the passwords match
    if ($password !== $confirm_password) {
        header("Location: register.php?error=Passwords do not match.");
        exit();
    }

    // Check if the email already exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.php?error=Email is already in use.");
        exit();
    }

    // Store the password directly (IN PLAIN TEXT) in the database
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: login.html?message=Registration successful! Please log in.");
        exit();
    } else {
        // Handle any errors during insertion
        header("Location: register.php?error=Registration failed. Please try again.");
        exit();
    }
}

$conn->close(); // Close the database connection
?>
