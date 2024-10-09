<?php
session_start();
require 'db_connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a SQL query to check if the user exists
    $sql = "SELECT * FROM users WHERE email = ? AND (role = 'admin' OR role = 'instructor') LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Compare the plain text password directly
        if ($password === $user['password']) { // Direct string comparison
            // Store user data in session variables
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];  // Store role in session

            // Redirect users based on their role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Admin panel
            } elseif ($user['role'] === 'instructor') {
                header("Location: instructor_dashboard.php"); // Instructor panel
            } else {
                header("Location: index.php"); // Regular users
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found or unauthorized.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
