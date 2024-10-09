<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
require 'db_connection.php'; // Make sure the path is correct

// Capture enrollment details from form submission
$course_name = $_POST['course'];
$start_date = $_POST['start_date'];
$preferred_time = $_POST['preferred_time'];
$course_cost = $_POST['course_cost'];
$user_email = $_SESSION['user_email']; // Get user's email from session
$enrollment_date = date('Y-m-d'); // Current date

// Prepare SQL statement to insert the enrollment into the database
$sql = "INSERT INTO enrollments (user_email, course, start_date, preferred_time, enrollment_date, amount) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $user_email, $course_name, $start_date, $preferred_time, $enrollment_date, $course_cost);

// Execute the SQL statement and check for success
if ($stmt->execute()) {
    // Enrollment successful, redirect to success page with course details
    $stmt->close();
    $conn->close();
    header("Location: enrollment_success.php?course=" . urlencode($course_name) . "&date=" . urlencode($start_date) . "&time=" . urlencode($preferred_time) . "&cost=" . urlencode($course_cost));
    exit();
} else {
    echo "There was an issue recording your enrollment. Please try again or contact support.";
    $stmt->close();
    $conn->close();
    exit();
}
