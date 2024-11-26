<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="..Connect1/css/user.css">
    <style>
        /* Styles for the page, same as before */
    </style>
</head>
<body>
    <nav class="navbar">
        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
        <ul>
            <li><a href="..Connect1/view/regular_dashboard.php">Dashboard</a></li>
            <li><a href="..Connect1/function/users.php">Users</a></li>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <tr>
                    <td>1</td>
                    <td>Ruon Kom</td>
                    <td>ruon.kom@ashesi.edu.gh</td>
                    <td>
                        <button onclick="readUser(1)">View</button>
                        <button onclick="updateUser(1)">Edit</button>
                        <button onclick="deleteUser(1)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- User Details Modal -->
        <div id="userDetailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('userDetailsModal')">&times;</span>
                <h3>User Details</h3>
                <p><strong>Name:</strong> <span id="detailName">Ruon Kom</span></p>
                <p><strong>Email:</strong> <span id="detailEmail">ruon.kom@ashesi.edu.gh</span></p>
            </div>
        </div>

        <!-- Add User Form Modal -->
        <div id="addUserFormModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addUserFormModal')">&times;</span>
                <h3>Add User</h3>
                <form id="addUserForm">
                    <label for="newName">Name:</label>
                    <input type="text" id="newName" name="name" required>

                    <label for="newEmail">Email:</label>
                    <input type="email" id="newEmail" name="email" required>

                    <button type="submit">Add User</button>
                </form>
            </div>
        </div>

        <!-- Update User Form Modal -->
        <div id="updateUserFormModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('updateUserFormModal')">&times;</span>
                <h3>Edit User</h3>
                <form id="updateUserForm">
                    <input type="hidden" id="userId" name="userId">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to display user details (Read)
        function readUser(userId) {
            document.getElementById("detailName").textContent = "Ruon Kom";
            document.getElementById("detailEmail").textContent = "ruon.kom@ashesi.edu.gh";
            document.getElementById("userDetailsModal").style.display = "block";
        }

        // Function to update user details (Edit)
        function updateUser(userId) {
            document.getElementById('userId').value = userId;
            document.getElementById('name').value = "Ruon Kom";
            document.getElementById('email').value = "ruon.kom@ashesi.edu.gh";
            document.getElementById('updateUserFormModal').style.display = "block";
        }

        // Function to delete a user (Delete)
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                const row = document.querySelector(`#userTable tr td:first-child:contains('${userId}')`).parentElement;
                if (row) {
                    row.remove();
                    alert("User deleted.");
                } else {
                    alert("User not found.");
                }
            }
        }

        // Function to close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Function to open the Add User modal
        function openAddUserModal() {
            document.getElementById('addUserFormModal').style.display = "block";
        }

        // Add User Form submission
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newName = document.getElementById('newName').value;
            const newEmail = document.getElementById('newEmail').value;

            if (!validateEmail(newEmail)) {
                alert('Please enter a valid email address.');
                return;
            }

            // Add new user to the table
            const userTable = document.getElementById('userTable');
            const newRow = userTable.insertRow();
            const userId = userTable.rows.length; // Automatically increment user ID based on number of rows

            newRow.innerHTML = `
                <td>${userId}</td>
                <td>${newName}</td>
                <td>${newEmail}</td>
                <td>
                    <button onclick="readUser(${userId})">View</button>
                    <button onclick="updateUser(${userId})">Edit</button>
                    <button onclick="deleteUser(${userId})">Delete</button>
                </td>
            `;

            // Close the modal and reset the form
            closeModal('addUserFormModal');
            document.getElementById('addUserForm').reset();
            alert('User added successfully!');
        });

        // Email validation function
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        // Function to toggle the menu visibility
        function toggleMenu() {
            const navbar = document.querySelector('.navbar');
            const ul = navbar.querySelector('ul');
            ul.classList.toggle('show');
        }
    </script>
</body>
</html>
