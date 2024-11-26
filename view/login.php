<?php
// Include your database connection
//include './db/config.php';
include('../db/config.php');
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
   // var_dump($_POST);
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    $userrole = isset($_POST['role']) ? trim($_POST['role']) : ''; // Get role from the form
    // Validate form fields
    if (empty($email) || empty($password) || empty($confirm_password) || empty($userrole)) {
       // die('Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       // die('Invalid email format.');
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
       // die('Passwords do not match.');
    }

    //echo $email;
   //echo $userrole;
$stmt = $conn->prepare('SELECT email, userpass FROM users WHERE email = ? AND userrole = ?');
$stmt->bind_param('ss', $email, $userrole);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['userpass'])) {
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $userrole;
        
        if ($userrole === 'admin' ) {
            header('Location: ../jera-main/view/Admin_dashboard.php');
        } else {
            header('Location: ../jera-main/view/regular_dashboard.php');
        }
        exit;
    } else {
        //echo 'Invalid password.';
    }
} else {
    //echo 'No user found with this email and role.';
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
    <link rel="stylesheet" href="../jera-main/css/login.css">
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
        <p>Don't have an account? <a href="register.php"> Signup</a></p>
    </div>
</body>
</html>