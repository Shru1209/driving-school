<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: linear-gradient(to right, #e3f2fd, #bbdefb); /* Gradient background */
            height: 100vh; /* Full height of the viewport */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center content vertically and horizontally */
        }

        h1 {
            color: #35424a;
            font-size: 2.5em; /* Larger title */
            margin-bottom: 20px; /* Space below title */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle shadow for text */
        }

        p {
            color: #333;
            font-size: 1.2em; /* Slightly larger paragraph text */
            margin-bottom: 30px; /* Space below paragraph */
        }

        a {
            text-decoration: none;
            color: white; /* White text for button */
            background-color: #35424a; /* Dark background for button */
            padding: 10px 20px; /* Padding around button */
            border-radius: 5px; /* Rounded corners */
            font-size: 1em; /* Button text size */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        a:hover {
            background-color: #2c3e50; /* Darker color on hover */
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2em; /* Responsive font size for smaller screens */
            }

            p {
                font-size: 1em; /* Responsive font size for smaller screens */
            }

            a {
                padding: 8px 16px; /* Smaller padding for smaller screens */
            }
        }
    </style>
</head>
<body>
    <h1>Thank You!</h1>
    <p>Your message has been sent successfully. We will get back to you shortly.</p>
    <a href="index.php">Go Back to Home</a>
</body>
</html>
