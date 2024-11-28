<?php
session_start();
include('../db/config.php'); // Include the database connection file

// Function to fetch all users
function getUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM users");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch all users from the database
$users = getUsers();
$total_users = count($users);
$total_coconuts = array_sum(array_column($users, 'coconuts'));

// Data for the bar chart (coconuts created per month)
$monthlyData = [
    'Jan' => 50, // Example data
    'Feb' => 30,
    'Mar' => 60,
    'Apr' => 40,
    'May' => 70
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/Admin_dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar">
        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
        <ul>
            <li><a href="users.php">Users Management</a></li>
            <li><a href="Regular_Admin_dashboard.php">User Dashboard</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <section class="analytics-section">
        <div class="stats">
            <div class="stat-item users">
                <i class="fas fa-users stat-icon"></i> 
                <h3>Total Users</h3>
                <p id="total-users"><?php echo $total_users; ?></p>
            </div>
            <div class="stat-item coconut">
                <i class="fas fa-leaf stat-icon"></i> 
                <h3>Total Coconuts</h3>
                <p id="total-coconuts"><?php echo $total_coconuts; ?></p> 
            </div>
            <div class="stat-item ratings">
                <i class="fas fa-star stat-icon"></i> 
                <h3>Avg Rating</h3>
                <p id="avg-rating">4.5</p> 
            </div>
        </div>

        <!-- Bar Chart: Coconuts Created Per Month -->
        <div>
            <h2>Coconuts Created Per Month</h2>
            <canvas id="coconutsBarChart"></canvas>
        </div>
    </section>

    <script>
        // Bar Chart Data (coconuts created per month)
        const months = <?php echo json_encode(array_keys($monthlyData)); ?>;
        const coconuts = <?php echo json_encode(array_values($monthlyData)); ?>;

        // Create the Bar Chart using Chart.js
        const ctx = document.getElementById('coconutsBarChart').getContext('2d');
        const coconutsBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Coconuts Created',
                    data: coconuts,
                    backgroundColor: '#FF5733',
                    borderColor: '#C70039',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide legend if not needed
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' coconuts';
                            }
                        }
                    }
                }
            }
        });

        // Toggle menu for navigation
        function toggleMenu() {
            const navbar = document.querySelector('.navbar');
            const ul = navbar.querySelector('ul');
            ul.classList.toggle('show');
        }
    </script>
</body>
</html>
