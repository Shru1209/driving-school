<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Academy</title>
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
            max-width: 900px;
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

        h2, h3 {
            color: #35424a; /* Dark headings */
            margin-top: 20px; /* Space above headings */
        }

        .btn-enroll {
            display: inline-block; /* Make it a block element */
            padding: 10px 20px; /* Padding around button */
            background: #35424a; /* Button background */
            color: white; /* Button text color */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Bold text */
            transition: background 0.3s; /* Transition for hover effect */
        }

        .btn-enroll:hover {
            background: #2c3e50; /* Darker button on hover */
        }

        .owner-card, .cars-card {
            background: rgba(255, 255, 255, 0.8); /* Card background */
            padding: 20px;
            margin-top: 20px; /* Space above the card */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Shadow for card */
            text-align: left; /* Align text to the left */
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
                <li><a href="contact.php">Contact Us</a></li>
                
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
        <h1>Welcome to Our Driving Academy</h1>
        <p>Learn from the best instructors and become a safe driver!</p>
        
        <!-- Enroll Now Button -->
        <?php if (isset($_SESSION['user_email'])): ?>
            <a href="enroll.php" class="btn-enroll">Enroll Now</a>
        <?php else: ?>
            <a href="login.html" class="btn-enroll">Enroll Now</a>
            <p style="color: red;">*You must be logged in to enroll</p>
        <?php endif; ?>

         <!-- Owner's Details Card -->
         <div class="owner-card">
            <h2>Meet Our Owner</h2>
            <p><strong>Name:</strong> John Bahekar</p>
            <p><strong>Experience:</strong> 15 years in driving education</p>
            <p><strong>Message:</strong> "At Bahekar Driving Academy, we prioritize your safety and provide top-notch driving lessons tailored to your needs."</p>
        </div>

         <!-- Cars Provided for Training Card -->
         <div class="cars-card">
            <h2>Cars We Provide for Training</h2>
            <ul>
                <li><strong>Maruti Suzuki Swift:</strong> A compact car, easy to handle and perfect for beginners.</li>
                <li><strong>Toyota Innova:</strong> Spacious and comfortable, ideal for learning in urban settings.</li>
                <li><strong>Hyundai i10:</strong> A small hatchback known for its maneuverability and efficiency.</li>
                <li><strong>Honda City:</strong> A popular sedan with great visibility and handling.</li>
                <li><strong>Ford EcoSport:</strong> A compact SUV that offers a higher driving position and stability.</li>
            </ul>
        </div>
    </main>
    </main>

    <footer>
        <div class="footer-links">
            
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
        <div class="contact-info">
            <p>Address: Bahekar Driving Academy, boisar
            </p>
            <p>Phone: (123) 456-7890</p>
            <p>Email: bahekardrivingacademy@gmail.com </p>
        </div>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
        </div>
    </footer>
</body>
</html>
