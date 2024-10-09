<?php
session_start(); // Start the session

if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
require 'db_connection.php'; // Ensure the path is correct

// Get the logged-in user's email from the session
$user_email = $_SESSION['user_email'];

// Query to get enrolled courses
$sql = "SELECT course, start_date, preferred_time, enrollment_date, amount FROM enrollments WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My Account</title>
</head>
<body>
    <header>
        <div class="logo">Your Academy Logo</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact Us</a></li>
                <li>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>My Account</h1>

        <h2>Enrolled Courses</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Start Date</th>
                        <th>Preferred Time</th>
                        <th>Enrollment Date</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['preferred_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['enrollment_date']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['amount']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not enrolled in any courses yet.</p>
        <?php endif; ?>
        
    </main>

    <footer>
        <div class="footer-links">
            <a href="#">About Us</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
        <div class="contact-info">
            <p>Address: Your Academy Address</p>
            <p>Phone: (123) 456-7890</p>
            <p>Email: info@youracademy.com</p>
        </div>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close(); // Close the database connection
?>
