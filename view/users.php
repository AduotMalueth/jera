<?php 
// user.php - A simple PHP file to manage users
session_start();
// Include your database connection
include('../db/config.php');

// Initialize users array
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        ['id' => 1, 'name' => 'Ruon Kom', 'email' => 'ruon.kom@ashesi.edu.gh', 'cost' => 150, 'coconuts' => 20, 'region' => 'Greater Accra']
    ];
}

// Function to get all users
function getUsers() {
    return $_SESSION['users'];
}

// Function to add a user
function addUser($name, $email, $cost, $coconuts, $region) {
    $id = count($_SESSION['users']) + 1;
    $_SESSION['users'][] = ['id' => $id, 'name' => $name, 'email' => $email, 'cost' => $cost, 'coconuts' => $coconuts, 'region' => $region];
}

// Function to update a user
function updateUser($id, $name, $email, $cost, $coconuts, $region) {
    foreach ($_SESSION['users'] as $key => $user) {
        if ($user['id'] == $id) {
            $_SESSION['users'][$key] = ['id' => $id, 'name' => $name, 'email' => $email, 'cost' => $cost, 'coconuts' => $coconuts, 'region' => $region];
            break;
        }
    }
}

// Function to delete a user
function deleteUser($id) {
    foreach ($_SESSION['users'] as $key => $user) {
        if ($user['id'] == $id) {
            unset($_SESSION['users'][$key]);
            $_SESSION['users'] = array_values($_SESSION['users']);  // Reindex the array
            break;
        }
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                addUser($_POST['name'], $_POST['email'], $_POST['cost'], $_POST['coconuts'], $_POST['region']);
                break;
            case 'update':
                updateUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['cost'], $_POST['coconuts'], $_POST['region']);
                break;
            case 'delete':
                deleteUser($_POST['id']);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../css/user.css">
    <style>
        /* Styles for the page, same as before */
    </style>
</head>
<body>
    <!-- Go Back Button -->
    <button onclick="goBack()" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Go Back
    </button>
    
    <nav class="navbar">
        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
        <ul>
            <li><a href="users.php">Users</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>User Management Interface</h2>

        <!-- Add User Button -->
        <button onclick="openAddUserModal()">Add User</button>

        <!-- User Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Cost</th>
                    <th>Number of Coconuts</th>
                    <th>Region</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php
                $users = getUsers();
                foreach ($users as $user) {
                    echo "<tr>
                        <td>{$user['id']}</td>
                        <td>{$user['name']}</td>
                        <td>{$user['email']}</td>
                        <td>Gh₵{$user['cost']}</td>
                        <td>{$user['coconuts']}</td>
                        <td>{$user['region']}</td>
                        <td>
                            <button onclick='readUser({$user['id']})'>View</button>
                            <button onclick='updateUser({$user['id']})'>Edit</button>
                            <button onclick='deleteUser({$user['id']})'>Delete</button>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add User Form Modal -->
        <div id="addUserFormModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addUserFormModal')">&times;</span>
                <h3>Add User</h3>
                <form id="addUserForm" method="POST" action="users.php">
                    <input type="hidden" name="action" value="add">
                    <label for="newName">Name:</label>
                    <input type="text" id="newName" name="name" required>

                    <label for="newEmail">Email:</label>
                    <input type="email" id="newEmail" name="email" required>

                    <label for="newCost">Cost:</label>
                    <input type="number" id="newCost" name="cost" required>

                    <label for="newCoconuts">Number of Coconuts:</label>
                    <input type="number" id="newCoconuts" name="coconuts" required>

                    <label for="newRegion">Region:</label>
                    <select id="newRegion" name="region" required>
                        <option value="Greater Accra">Greater Accra</option>
                        <option value="Western">Western</option>
                        <option value="Central">Central</option>
                    </select>

                    <button type="submit">Add User</button>
                </form>
            </div>
        </div>

        <!-- Update User Form Modal -->
        <div id="updateUserFormModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('updateUserFormModal')">&times;</span>
                <h3>Edit User</h3>
                <form id="updateUserForm" method="POST" action="users.php">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="userId" name="id">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="cost">Cost:</label>
                    <input type="number" id="cost" name="cost" required>

                    <label for="coconuts">Number of Coconuts:</label>
                    <input type="number" id="coconuts" name="coconuts" required>

                    <label for="region">Region:</label>
                    <select id="region" name="region" required>
                        <option value="Greater Accra">Greater Accra</option>
                        <option value="Western">Western</option>
                        <option value="Central">Central</option>
                    </select>

                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to open the Add User modal
        function openAddUserModal() {
            document.getElementById('addUserFormModal').style.display = "block";
        }

        // Function to close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Function to read user details (View)
        function readUser(userId) {
            alert('View details of user with ID ' + userId);
        }

        // Function to update user details (Edit)
        function updateUser(userId) {
            document.getElementById('userId').value = userId;
            // You should populate the form fields with the user details via AJAX or reload the page with data
            document.getElementById('updateUserFormModal').style.display = "block";
        }

        // Function to delete a user (Delete)
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'users.php';
                var hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = 'action';
                hiddenField.value = 'delete';
                form.appendChild(hiddenField);
                hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = 'id';
                hiddenField.value = userId;
                form.appendChild(hiddenField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Function to go back to the dashboard
        function goBack() {
            window.location.href = "Admin_dashboard.php";  // Adjust the URL as needed
        }

        // Toggle menu function for responsive design
        function toggleMenu() {
            const menu = document.querySelector('.navbar ul');
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }
    </script>
</body>
</html>
