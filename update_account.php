<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html");
    exit();
}

require 'db_connection.php'; // Include database connection

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $new_mobile_no = trim($_POST['mobile_no']);
    $new_birthdate = trim($_POST['birthdate']);
    $current_email = $_SESSION['user_email'];

    // Update user's details in the database
    $sql = "UPDATE users SET name = ?, email = ?, mobile_no = ?, birthdate = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $new_name, $new_email, $new_mobile_no, $new_birthdate, $current_email);

    if ($stmt->execute()) {
        // Update successful, update session variables
        $_SESSION['user_name'] = $new_name;
        $_SESSION['user_email'] = $new_email;

        // Redirect back to the account details page with success message
        header("Location: account_details.php?update=success");
    } else {
        // Update failed, redirect with error message
        header("Location: account_details.php?update=error");
    }

    $stmt->close();
}

$conn->close(); // Close the database connection
?>
