<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact Us - Driving Academy</title>
    <style>
        * {
            box-sizing: border-box; /* Ensure consistent box sizing */
        }

        html, body {
            height: 100%; /* Ensure body takes up full height */
            margin: 0; /* Remove default margin */
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            display: flex; /* Enable Flexbox on body */
            flex-direction: column; /* Stack children vertically */
            background: url('path/to/your/driving-background.jpg') no-repeat center center fixed; /* Background image */
            background-size: cover; /* Cover entire screen */
            color: #35424a; /* Text color */
        }

        header {
            background: rgba(53, 66, 74, 0.8); /* Dark header with slight transparency */
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
            flex: 1; /* Allow main to grow and take available space */
            max-width: 600px;
            margin: 20px auto; /* Center the main content */
            background: rgba(255, 255, 255, 0.9); /* White background for content with transparency */
            padding: 20px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            text-align: center; /* Center text */
        }

        h1 {
            font-size: 2.5em; /* Larger title */
            margin-bottom: 10px; /* Space below title */
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column; /* Stack input fields vertically */
            margin-top: 20px; /* Space above form */
        }

        input, textarea {
            padding: 10px; /* Padding inside input fields */
            margin: 10px 0; /* Space between fields */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 5px; /* Rounded corners */
            width: 100%; /* Full width */
        }

        button {
            padding: 10px; /* Padding for button */
            background: #35424a; /* Button background */
            color: white; /* Button text color */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background 0.3s; /* Transition for hover effect */
        }

        button:hover {
            background: #2c3e50; /* Darker button on hover */
        }

        footer {
            background: rgba(53, 66, 74, 0.8); /* Dark footer with slight transparency */
            color: white; /* White text */
            text-align: center;
            padding: 10px 0;
            margin-top: auto; /* Push footer to the bottom */
        }

        .footer-links a {
            color: white; /* White text for footer links */
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .contact-info {
            margin: 10px 0; /* Margin for spacing */
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Bahekar Driving Academy</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact Us</a></li>
                
                <!-- Check if user is logged in and show account details or login button -->
                <?php if (isset($_SESSION['user_email'])): ?>
                    <li>Welcome, <a href="account_details.php" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="enroll.php" class="btn-enroll">Enroll Now</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Contact Us</h1>
        <p>If you have any questions or inquiries, feel free to reach out to us!</p>
        
        <form action="contact_submit.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
        
        <div class="contact-info">
            <h2>Contact Information</h2>
            <p><strong>Address:</strong> Bahekar Driving Academy, Boisaar</p>
            <p><strong>Phone:</strong> (123) 456-7890</p>
            <p><strong>Email:</strong> bahekardrivingacademy@gmail.com</p>
        </div>
    </main>

    <footer>
        <div class="footer-links">
            <a href="privacy_policy.php">Privacy Policy</a>
            <a href="terms_of_service.php">Terms of Service</a>
        </div>
        <div class="contact-info">
            <p>Address: Bahekar Driving Academy, Boisaar</p>
            <p>Phone: (123) 456-7890</p>
            <p>Email: bahekardrivingacademy@gmail.com</p>
        </div>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
        </div>
    </footer>
</body>
</html>
