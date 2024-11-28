<? ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regular Dashboard</title>
    <link rel="stylesheet" href="../css/Regular_Admin_dashboard.css">
    <script src="../js/Aduot.js"></script> <!-- Include Chart.js -->
</head>
<body>
    <header class="header">
        <h1>Regular Dashboard</h1>
        <p>Welcome to the Coconut Management System</p>
    </header>
    <nav>
        <ul>
            <li><a href="add_comment.php" onclick="showSection('commentsSection')">Comments/recommendation</a></li>
            <li><a href="add_purchase.php" onclick="showSection('summarySection')">Buy coconuts now</a></li>
            <li><a href="sell_now.php" onclick="showSection('summarySection')">Sell your coconuts</a></li>
            <li><a href="login.php">Logout</a>
        </ul>
</body>
</html>
