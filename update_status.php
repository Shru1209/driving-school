<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html");
    exit();
}

// Check if the user has the right role
if ($_SESSION['user_role'] !== 'instructor') {
    echo "Access denied.";
    exit();
}

// Include database connection
require 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enrollment_id = $_POST['enrollment_id'];
    $new_status = $_POST['status'];

    // Prepare the SQL update statement
    $stmt = $conn->prepare("UPDATE enrollments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $enrollment_id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the enrollments page
    header("Location: view_enrollments.php");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>
