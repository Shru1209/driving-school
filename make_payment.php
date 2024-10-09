<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

require 'db_connection.php'; // Include database connection

// Check if enrollment ID is provided in the POST request
if (!isset($_POST['enrollment_id'])) {
    header("Location: account_details.php"); // Redirect to account if enrollment ID is missing
    exit();
}

// Fetch enrollment ID
$enrollment_id = $_POST['enrollment_id'];

// If the form has been submitted, process the payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_payment'])) {
    // Simulate payment processing (here we can integrate an actual payment gateway)
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Here you would typically send this data to a payment gateway (like Stripe, PayPal, etc.)
    // For this example, we'll assume the payment is always successful.

    // Update payment status in the database
    $payment_status = 'Paid'; // Update status to 'Paid'

    // SQL query to update payment status
    $sql = "UPDATE enrollments SET payment_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $payment_status, $enrollment_id);

    if ($stmt->execute()) {
        // Redirect back to account details page with a success message
        header("Location: account_details.php?message=Payment+successful");
    } else {
        // Handle any errors
        echo "Error updating payment status.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit();
}

// Fetch the enrollment details
$sql_enrollment = "SELECT course, amount FROM enrollments WHERE id = ?";
$stmt = $conn->prepare($sql_enrollment);
$stmt->bind_param("i", $enrollment_id);
$stmt->execute();
$result = $stmt->get_result();
$enrollment = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 50px auto;
            padding: 20px;
            max-width: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            color: #555;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Make Payment</h1>
        <p><strong>Course Name:</strong> <?php echo htmlspecialchars($enrollment['course']); ?></p>
        <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($enrollment['amount']); ?></p>

        <!-- Payment Form -->
        <form method="POST" action="">
            <input type="hidden" name="enrollment_id" value="<?php echo htmlspecialchars($enrollment_id); ?>">
            
            <label for="card_number">Card Number</label>
            <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>

            <label for="expiry_date">Expiry Date</label>
            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>

            <label for="cvv">CVV</label>
            <input type="number" id="cvv" name="cvv" placeholder="123" required>

            <button type="submit" name="process_payment">Complete Payment</button>
        </form>
    </div>
</body>
</html>
