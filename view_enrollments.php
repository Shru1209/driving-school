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

// Ensure user_name session variable is set
$user_name = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Instructor'; // Default to 'Instructor' if user_name is not set

// Include database connection
require 'db_connection.php'; // Ensure this points to your database connection file

// Query to fetch enrollments
$sql = "SELECT id, user_email, course, start_date, Preferred_time, amount, status FROM enrollments"; // Use 'status' instead of 'payment_status'
$result = $conn->query($sql); // Execute the query

// Check for any errors in the query execution
if ($conn->error) {
    die("Query failed: " . $conn->error); // Debugging error in case the query fails
}

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enrollments</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px; /* Reduced padding for better layout */
        }

        /* Header Styles */
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px; /* Added rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin-bottom: 10px;
        }

        /* Navigation Styles */
        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px; /* Increased padding for buttons */
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #0056b3;
        }

        /* Main Styles */
        main {
            margin: 20px auto; /* Center the main section */
            max-width: 1200px; /* Maximum width for larger screens */
            padding: 20px; /* Added padding */
            border-radius: 8px; /* Round the corners of the main section */
            background-color: #fff; /* Ensure a background for better visibility */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }

        /* Heading Styles */
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 35px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px; /* Added rounded corners */
            overflow: hidden; /* Prevents overflow from rounded corners */
            table-layout: fixed; /* Ensures consistent column width */
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word; /* Ensures long text wraps within cell */
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td {
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Input and Button Styles */
        select {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 12px;
            background-color: #28a745;
            border: none;
            border-radius: 4px; /* Added rounded corners */
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #218838;
            transform: scale(1.05); /* Slightly enlarges button on hover */
        }

        /* No Data Styles */
        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
        }

        /* Message Styles */
        .message {
            text-align: center;
            margin: 20px 0;
        }

        .message.success {
            color: green; /* Default to green for success */
        }

        .message.error {
            color: red; /* Color for error messages */
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $user_name; ?> (Instructor)</h1>
        <nav>
            <ul>
                <li><a href="instructor_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Enrollments List</h2>
        <table>
            <thead>
                <tr>
                    <th>Enrollment ID</th>
                    <th>User Email</th>
                    <th>Course</th>
                    <th>Start Date</th>
                    <th>Preferred Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are enrollments to display
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Preferred_time']) . "</td>";
                        echo "<td>₹" . htmlspecialchars($row['amount']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>
                                <form action='update_status.php' method='post'>
                                    <input type='hidden' name='enrollment_id' value='" . htmlspecialchars($row['id']) . "' />
                                    <select name='status'>
                                        <option value='Not Yet Started' " . ($row['status'] == 'Not Yet Started' ? 'selected' : '') . ">Not Yet Started</option>
                                        <option value='In Progress' " . ($row['status'] == 'In Progress' ? 'selected' : '') . ">In Progress</option>
                                        <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                    </select>
                                    <button type='submit'>Update</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='no-data'>No enrollments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
