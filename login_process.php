<?php
session_start(); // Start the session
require 'db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user credentials in the database
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Set session variables
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        // Redirect to the account details page or home page
        header("Location: index.php");
        exit();
    } else {
        // Redirect back to the login page with an error
        header("Location: login.html?error=Invalid credentials");
        exit();
    }
}
