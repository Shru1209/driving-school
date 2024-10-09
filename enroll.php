<?php
session_start(); // Start the session
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect if not logged in
    exit();
}

// Define course costs (you can customize these values)
$course_costs = [
    'basic-driving' => 2000.00, // Example costs
    'advanced-driving' => 3000.00,
    'defensive-driving' => 2500.00,
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Enroll in a Course</title>
</head>
<body>
    <header>
        <div class="logo">Bahekar Driving Academy</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact Us</a></li>
                <li>Welcome, <a><?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1 style="color:black;">Enroll in a Driving Course</h1>
        <p>Complete the form below to enroll in your desired course.</p>

        <form action="process_enrollment.php" method="POST">
            <label for="course">Choose a Course:</label>
            <select id="course" name="course" required>
                <option value="">Select a course</option>
                <option value="basic-driving">Basic Driving - ₹2000</option>
                <option value="advanced-driving">Advanced Driving - ₹3000</option>
                <option value="defensive-driving">Defensive Driving - ₹2500</option>
            </select>

            <label for="date">Preferred Start Date:</label>
            <input type="date" id="date" name="start_date" required>

            <label for="time">Preferred Time:</label>
            <input type="time" id="time" name="preferred_time" required>

            <input type="hidden" name="course_cost" value="">
            <input type="hidden" name="course_name" value="">

            <button type="submit">Enroll Now</button>
        </form>

    </main>

    <footer>
        <div class="footer-links">
         
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
        <div class="contact-info">
            <p>Address: Bahekar  Driving Academy, Boisar. </p>

            <p>Phone: (123) 456-7890</p>
            <p>Email: bahekardrivingacademy@gmail.com</p>
        </div>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
        </div>
    </footer>

    <script>
        // JavaScript to set hidden input values based on selected course
        document.getElementById('course').addEventListener('change', function() {
            var selectedCourse = this.value;
            var courseCosts = <?php echo json_encode($course_costs); ?>; // Convert PHP array to JS object

            // Update hidden fields based on selected course
            if (selectedCourse) {
                document.querySelector('input[name="course_name"]').value = selectedCourse;
                document.querySelector('input[name="course_cost"]').value = courseCosts[selectedCourse].toFixed(2); // Set cost to 2 decimal points
            } else {
                document.querySelector('input[name="course_name"]').value = '';
                document.querySelector('input[name="course_cost"]').value = '';
            }
        });
    </script>
</body>
</html>
