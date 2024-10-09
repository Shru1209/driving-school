<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = htmlspecialchars($_POST['name']); // Sanitize user input
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Process the form (You can store it in a database or perform other actions here)

    // Redirect to thank you page
    header("Location: thank_you.php"); // Redirect to the thank you page
    exit();
}
?>
