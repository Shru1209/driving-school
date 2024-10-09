<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Get course details from the URL query parameters
$course_name = urldecode($_GET['course']);
$start_date = urldecode($_GET['date']);
$preferred_time = urldecode($_GET['time']);
$course_cost = urldecode($_GET['cost']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS -->
    <title>Enrollment Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            margin-top: 50px;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 18px;
            margin: 10px 0;
        }

        .details {
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            max-width: 600px;
            background-color: #fff;
        }

        .cta-buttons {
            margin-top: 30px;
        }

        .cta-buttons a {
            text-decoration: none;
            color: #fff;
            padding: 10px 25px;
            margin: 0 10px;
            border-radius: 5px;
            background-color: #007bff;
            transition: background-color 0.3s;
        }

        .cta-buttons a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h2>Your Academy Logo</h2>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="account_details.php">Your Account</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="success-icon">✅</div> <!-- Use an icon for visual appeal -->
        <h1>Enrollment Successful!</h1>
        <p>Thank you for enrolling in <strong><?php echo htmlspecialchars($course_name); ?></strong>!</p>
        <p>Your course details are as follows:</p>

        <div class="details">
            <p><strong>Course Name:</strong> <?php echo htmlspecialchars($course_name); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($start_date); ?></p>
            <p><strong>Preferred Time:</strong> <?php echo htmlspecialchars($preferred_time); ?></p>
            <p><strong>Total Cost:</strong> ₹<?php echo htmlspecialchars($course_cost); ?></p>
        </div>

        <div class="cta-buttons">
            <a href="account_details.php">Go to Your Account</a>
            <a href="courses.php">Enroll in Another Course</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Your Academy. All rights reserved.</p>
    </footer>
</body>
</html>
