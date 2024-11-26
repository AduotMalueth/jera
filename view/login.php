<?php
// Include your database connection
include('../db/config.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $userrole = isset($_POST['role']) ? trim($_POST['role']) : '';

    // Validate form fields
    if (empty($email) || empty($password) || empty($userrole)) {
        die('Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    // Prepare a statement to check user credentials
    $stmt = $conn->prepare('SELECT email, userpass FROM users WHERE email = ? AND userrole = ?');
    $stmt->bind_param('ss', $email, $userrole);
    $stmt->execute();

    // Retrieve the result
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['userpass'])) {
            // Start a session and store user details
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $userrole;

            // Redirect based on role
            if ($userrole === 'admin') {
                header('Location: ../view/Admin_dashboard.php');
            } elseif ($userrole === 'user') {
                header('Location: ../view/regular_dashboard.php');
            } else {
                die('Invalid role specified.');
            }
            exit;
        } else {
            die('Incorrect password.');
        }
    } else {
        die('No user found with the specified email and role.');
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
    <title>JERAConnect - Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="auth-container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</body>
</html>
