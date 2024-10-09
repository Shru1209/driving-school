<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

require 'db_connection.php'; // Include database connection

// Fetch user details from the database using the session email
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit();
}

// Fetch enrolled courses and payment status
$sql_enrollments = "SELECT id, course, start_date, preferred_time, amount, payment_status FROM enrollments WHERE user_email = ?";
$stmt_enrollments = $conn->prepare($sql_enrollments);
$stmt_enrollments->bind_param("s", $user_email);
$stmt_enrollments->execute();
$result_enrollments = $stmt_enrollments->get_result();

// Fetch completed courses
$sql_completed = "SELECT id, course, start_date, preferred_time, amount, payment_status FROM enrollments WHERE user_email = ? AND status = 'Completed'";
$stmt_completed = $conn->prepare($sql_completed);

if ($stmt_completed) {
    $stmt_completed->bind_param("s", $user_email);
    $stmt_completed->execute();
    $result_completed = $stmt_completed->get_result(); // Fetch result
} else {
    // If the statement failed, handle the error
    echo "Error preparing statement: " . $conn->error;
    $result_completed = null; // Set it to null if there's an error
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Account Details</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4; /* Light background for contrast */
}

header {
    background: #35424a; /* Dark header */
    color: #ffffff; /* White text for contrast */
    padding: 10px 0;
    text-align: center;
}

header .logo {
    font-size: 1.8em;
    font-weight: bold;
}

nav ul {
    list-style: none;
    padding: 0;
}

nav ul li {
    display: inline; /* Horizontal list */
    margin: 0 15px;
}

nav a {
    color: #ffffff; /* White text for links */
    text-decoration: none;
    font-weight: bold;
}

nav a:hover {
    text-decoration: underline; /* Underline on hover */
}

main {
    max-width: 900px;
    margin: 20px auto;
    background: #ffffff; /* White background for content */
    padding: 20px;
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

h2, h3 {
    color: #35424a; /* Dark headings */
    margin-top: 20px; /* Space above headings */
}

.account-details {
    background: #e7f3fe; /* Light blue background for account details */
    border: 1px solid #bcd4e6; /* Border around details */
    border-radius: 8px; /* Rounded corners */
    padding: 15px;
    margin-bottom: 20px;
}

input[type="text"],
input[type="email"],
input[type="date"],
button {
    width: 100%; /* Full width for inputs */
    padding: 10px;
    margin: 10px 0; /* Space between inputs */
    border: 1px solid #ccc; /* Light border */
    border-radius: 5px; /* Rounded corners */
}

button {
    background: #35424a; /* Button background */
    color: white; /* Button text color */
    border: none; /* No border */
    cursor: pointer; /* Pointer cursor */
}

button:hover {
    background: #2c3e50; /* Darker button on hover */
}

table {
    width: 100%;
    border-collapse: collapse; /* Remove double borders */
    margin: 20px 0; /* Space above and below the table */
}

th, td {
    border: 1px solid #dddddd; /* Light gray border */
    text-align: left;
    padding: 8px;
}

th {
    background-color: #35424a; /* Dark background for headers */
    color: white; /* White text for headers */
}

tr:nth-child(even) {
    background-color: #f2f2f2; /* Light gray for alternate rows */
}

footer {
    background: #35424a; /* Dark footer */
    color: white; /* White text */
    text-align: center;
    padding: 10px 0;
    position: relative;
    bottom: 0;
    width: 100%; /* Full width footer */
}

.footer-links a {
    color: white; /* White text for footer links */
    margin: 0 10px;
}

.footer-links a:hover {
    text-decoration: underline; /* Underline on hover */
}

    </style>
</head>
<body>
    <header>
        <div class="logo">Your Academy Logo</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact Us</a></li>
                <li>Welcome, <a href="account_details.php" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($user['name']); ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Your Account Details</h2>

        <!-- Display account details -->
        <div class="account-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user['mobile_no']); ?></p>
            <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($user['birthdate']); ?></p>
        </div>

        <!-- Update form -->
        <h3>Update Account Details</h3>
        <form action="update_account.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="mobile_no">Mobile Number:</label>
            <input type="text" id="mobile_no" name="mobile_no" value="<?php echo htmlspecialchars($user['mobile_no']); ?>" required>

            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>

            <button type="submit">Update Details</button>
        </form>

        <!-- Enrolled Courses -->
        <h3>Your Enrolled Courses</h3>
        <?php if ($result_enrollments->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Start Date</th>
                        <th>Preferred Time</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Action</th> <!-- Action column for payment button -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($enrollment = $result_enrollments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enrollment['course']); ?></td>
                            <td><?php echo htmlspecialchars($enrollment['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($enrollment['preferred_time']); ?></td>
                            <td>₹<?php echo htmlspecialchars($enrollment['amount']); ?></td>
                            <td><?php echo htmlspecialchars($enrollment['payment_status']); ?></td>
                            <td>
                                <?php if ($enrollment['payment_status'] == 'Pending'): ?>
                                    <!-- Display the Make Payment button if payment is pending -->
                                    <form action="make_payment.php" method="POST">
                                        <input type="hidden" name="enrollment_id" value="<?php echo $enrollment['id']; ?>">
                                        <button type="submit">Make Payment</button>
                                    </form>
                                <?php else: ?>
                                    <span>Paid</span> <!-- Display "Paid" if the payment is already done -->
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not enrolled in any courses yet.</p>
        <?php endif; ?>

         <!-- Completed Courses -->
         <h3>Your Completed Courses</h3>
        <?php if ($result_completed->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Start Date</th>
                        <th>Preferred Time</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($completed = $result_completed->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($completed['course']); ?></td>
                            <td><?php echo htmlspecialchars($completed['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($completed['preferred_time']); ?></td>
                            <td>₹<?php echo htmlspecialchars($completed['amount']); ?></td>
                            <td><?php echo htmlspecialchars($completed['payment_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no completed courses yet.</p>
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
