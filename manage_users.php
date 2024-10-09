<?php
session_start();

// Check if the user is logged in and has the right role
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.html"); // Redirect to login if not logged in or not admin
    exit();
}

// Include database connection
require 'db_connection.php'; // Ensure this points to your database connection file

// Query to fetch users
$sql = "SELECT id, email, name, role FROM users"; // Adjust column names based on your database structure
$result = $conn->query($sql); // Execute the query

// Check for any errors in the query execution
if ($conn->error) {
    die("Query failed: " . $conn->error); // Debugging error in case the query fails
}

// Update user role if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Validate the new role
    $valid_roles = ['admin', 'instructor', 'user']; // Adjust based on your role structure
    if (in_array($new_role, $valid_roles)) {
        // Update the role in the database
        $update_sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $new_role, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('User role updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update user role. No rows affected.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Invalid role selected.');</script>";
    }
}

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background: #35424a;
    color: #ffffff;
    padding: 10px 20px;
    text-align: center;
}

nav {
    margin-top: 10px;
}

nav ul {
    list-style: none;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: #ffffff;
    text-decoration: none;
}

h1, h2 {
    margin: 20px 0;
}

main {
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #dddddd;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #35424a;
    color: #ffffff;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #ddd;
}

.no-data {
    text-align: center;
    color: #888;
}

button {
    background-color: #35424a;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #2c3e50;
}

a {
    color: #35424a;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Admin)</h1>
        <nav>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>User List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are users to display
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td>";
                        // Form to update user role
                        echo "<form method='POST' action=''>"; // Form for updating role
                        echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<select name='new_role'>";
                        echo "<option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>";
                        echo "<option value='instructor' " . ($row['role'] == 'instructor' ? 'selected' : '') . ">Instructor</option>";
                        echo "<option value='user' " . ($row['role'] == 'user' ? 'selected' : '') . ">User</option>";
                        echo "</select>";
                        echo "<button type='submit' name='update_role'>Update Role</button>"; // Update button
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='no-data'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
