<?php
// Define server details needed to connect to the database
$servername = 'localhost'; // The server where the database is hosted
$username = 'aduot.jok';        // The username to access the database
$password = 'Aduot@12';            // The password to access the database (empty if none is set)
$dbname = 'webtech_fall2024_aduot_jok'; // Replace 'your_actual_database_name' with your database name

// Attempt to connect to the database using the provided details
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection and handle errors
if (!$conn) {
    die('Unable to connect: ' . mysqli_connect_error());
} else {
    echo 'Connection was successful';
}
?>
