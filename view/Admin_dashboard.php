<?php
// Include your database connection
//include './db/config.php';
include('../db/config.php');
// Error Handling for Connection
if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
}

// Fetch total users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult ? $totalUsersResult->fetch_assoc()['total_users'] : 0;

// Fetch total coconuts
$totalCoconutsQuery = "SELECT COUNT(*) AS total_coconuts FROM coconuts";
$totalCoconutsResult = $conn->query($totalCoconutsQuery);
$totalCoconuts = $totalCoconutsResult ? $totalCoconutsResult->fetch_assoc()['total_coconuts'] : 0;

// Fetch top 5 most active users
$topUsersQuery = "
    SELECT users.name, COUNT(coconuts.id) AS total_coconuts 
    FROM users 
    JOIN coconuts ON users.id = coconuts.user_id 
    GROUP BY users.id 
    ORDER BY total_coconuts DESC 
    LIMIT 5";
$topUsersResult = $conn->query($topUsersQuery);

$topUsers = [];
if ($topUsersResult) {
    while ($row = $topUsersResult->fetch_assoc()) {
        $topUsers[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../jera/css/Admin_dashboard.css">
</head>
<body>
    <nav class="navbar">
        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
        <ul>
            <li><a href="../jera/function/users.php">Users</a></li>
            <li><a href="../jera/function/buy_Coconuts.php">Available coconuts</a></li>
            <li><a href="../jera/view/regular_dashboard.php">User Admin_dashboard</a></li>
            <li><a href="../jera/action/logout.php">Logout</a>
           <!--- <li><a href="login.html">login</a></li>-->
           <!--- <li><a href="Signup.html">signup</a></li>-->
        </ul>
    </nav>

    <section class="analytics-section">

        
        <div class="stats">
            <div class="stat-item users">
                <i class="fas fa-users stat-icon"></i> 
                <h3>Total Users</h3>
                <p id="total-users">150</p>
            </div>
            <div class="stat-item coconut">
                <i class="	fas fa-leaf stat-icon"></i> 
                <h3>Total coconuts</h3>
                <p id="total-coconuts">320</p> 
            </div>
            <div class="stat-item ratings">
                <i class="fas fa-star stat-icon"></i> 
                <h3>Avg Rating</h3>
                <p id="avg-rating">4.5</p> 
            </div>
        </div>
        <!-- Bar Chart: coconuts Created Per Month -->
        <div>
            <h2>coconuts Created Per Month</h2>
            <div class="bar-chart">
                <div class="bar" style="height: 200px;">
                    <span>50</span> 
                    <span>Jan</span>
                </div>
                <div class="bar" style="height: 150px;">
                    <span>30</span> 
                    <span>Feb</span>
                </div>
                <div class="bar" style="height: 220px;">
                    <span>60</span> 
                    <span>Mar</span>
                </div>
                <div class="bar" style="height: 180px;">
                    <span>40</span> 
                    <span>Apr</span>
                </div>
                <div class="bar" style="height: 300px;">
                    <span>70</span> 
                    <span>May</span>
                </div>
            </div>
        </div>
        <div class="top-users-list">
            <h2>Top 5 Most Active Users</h2>
            <ul>
                <li>
                    <span class="user-name">Kom</span><br>
                    <span class="user-coconuts">25 coconuts</span>
                </li>
                <li>
                    <span class="user-name">Nana</span><br>
                    <span class="user-coconuts">22 coconuts</span>
                </li>
                <li>
                    <span class="user-name">Ben</span><br>
                    <span class="user-coconuts">20 coconuts</span>
                </li>
                <li>
                    <span class="user-name">John</span><br>
                    <span class="user-coconuts">38 coconuts</span>
                </li>
                <li>
                    <span class="user-name">Kwame</span><br>
                    <span class="user-coconuts">25 coconuts</span>
                </li>
            </ul>
        </div>
    </section>

    <script>
        function toggleMenu() {
            const navbar = document.querySelector('.navbar');
            const ul = navbar.querySelector('ul');
            ul.classList.toggle('show');
        }

       
        document.getElementById('total-users').innerText = 5000; 
        document.getElementById('total-coconuts').innerText = 420; 
    </script>
</body>
</html>