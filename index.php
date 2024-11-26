<?php
// Include your database connection
include('./db/config.php');
//include './db/config.php';

// Error handling for database connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JERAConnect - Home</title>
    <!-- Linking the CSS file -->
    <link rel="stylesheet" href="./jera-main/css/index.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1>JERAConnect</h1>
            <p>Connecting Coconut Farmers and Buyers</p>
        </div>
        <nav>
            <ul>
                <li><a href="./jera-main/action/about.php">About Us</a></li>
                <li><a href="./jera-main/action/services.php">Services</a></li>
                <li><a href="./jera-main/view/register.php">Register Here</a></li>
                <li><a href="./jera-main/view/login.php">Login</a></li>
                <li><a href="./jera-main/action/team.php">Our Team</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section>
            <h1>Welcome to JERAConnect</h1>
            <p>Your trusted platform for coconut farmers and buyers in Ghana. Connect, share, and grow with us!
                JERAConnect is a web application designed to enhance communication and interaction among coconut farmers and buyers in Ghana. 
                The platform enables users to engage with one another through various features, fostering collaboration and building a supportive community.
            </p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 JERAConnect. All Rights Reserved.</p>
    </footer>
</body>
</html>
