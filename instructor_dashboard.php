<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Check if the user has the right role
if ($_SESSION['user_role'] !== 'instructor') {
    echo "Access denied. Only instructors can access this page.";
    exit();
}

// Instructor panel content starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?> (Instructor)</h1>
        <nav>
            <ul>
                <li><a href="view_enrollments.php">View Enrollments</a></li>
                
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Instructor Dashboard</h2>
        <p>Here you can see all the enrollments done.</p>
    </main>
</body>
</html>
