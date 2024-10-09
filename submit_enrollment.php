<?php
session_start(); // Start the session
require 'db_connection.php'; // Include the database connection

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect if not logged in
    exit();
}

// Validate form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $_SESSION['user_email'];
    $course = $_POST['course'];
    $start_date = $_POST['date'];
    $preferred_time = $_POST['time'];
    $amount = 0;

    // Define course costs (this should match the values in enroll.php)
    $course_costs = [
        'basic-driving' => 2000.00,
        'advanced-driving' => 3000.00,
        'defensive-driving' => 2500.00,
    ];

    // Get the amount
    $amount = $course_costs[$course] ?? 0;

    // Insert enrollment with pending payment status
    $sql = "INSERT INTO enrollments (user_email, course, start_date, preferred_time, amount, payment_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $payment_status = "Completed"; // Assuming payment was successful
        $stmt->bind_param("ssssss", $user_email, $course, $start_date, $preferred_time, $amount, $payment_status);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to a success page
            header("Location: enrollment_success.php"); 
            exit();
        } else {
            echo "Error: " . $stmt->error; // Display error if insert fails
        }
    } else {
        echo "Error preparing statement: " . $conn->error; // Display error if preparation fails
    }
    
    $stmt->close(); // Close the statement
} else {
    echo "Invalid request."; // Handle invalid request
}

$conn->close(); // Close the database connection
?>
