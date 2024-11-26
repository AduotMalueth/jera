<?php
// Include your database connection
include('../db/config.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    $userrole = isset($_POST['role']) ? trim($_POST['role']) : ''; // Get role from the form

    // Validate form fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($userrole)) {
        die('Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Check if the email already exists
    $stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        die('Email is already registered.');
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the `users` table
    $query = 'INSERT INTO users (name, email, userpass, userrole) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $username, $email, $hashed_password, $userrole);

    // Execute the query and check for success
    // Execute the query
    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header('Location: ../jera-main/view/login.php'); // Redirect to login page
        exit();
    } else {
        //die('Error inserting user. Please try again later.');
    }
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form id="registerForm" action="register.php" method="POST" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button type="submit">Register</button>
        </form>
        <div id="error_message"></div>
    </div>

    <!-- Link to JS -->
    <script src="../js/script.js"></script>
</body>
</html>