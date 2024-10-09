<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Check if the user has the right role
if ($_SESSION['user_role'] !== 'admin') {
    echo "Access denied. Only admins can access this page.";
    exit();
}

// Admin panel content starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?> (Admin)</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <!-- Changed from 'Manage Courses' to 'Manage Enrollments' -->
                <li><a href="manage_enrollments.php">Manage Enrollments</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Admin Dashboard</h2>
        <p>Here you can manage users, instructors, and enrollments.</p>
    </main>
</body>
</html>
