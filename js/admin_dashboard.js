// Function to fetch and display user data
function fetchUsers() {
    fetch('?action=fetch_users')
        .then(response => response.json())
        .then(data => {
            let userTableBody = document.querySelector('#userTable tbody');
            userTableBody.innerHTML = ''; // Clear existing data

            data.forEach(user => {
                let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><button onclick="deleteUser(${user.id})">Delete</button></td>
                </tr>`;
                userTableBody.innerHTML += row;
            });
        });
}

// Function to fetch and display transaction data
function fetchTransactions() {
    fetch('?action=fetch_transactions')
        .then(response => response.json())
        .then(data => {
            let transactionTableBody = document.querySelector('#transactionTable tbody');
            transactionTableBody.innerHTML = ''; // Clear existing data

            data.forEach(transaction => {
                let row = `<tr>
                    <td>${transaction.id}</td>
                    <td>${transaction.user_id}</td>
                    <td>${transaction.transaction_type}</td>
                    <td>${transaction.quantity}</td>
                    <td>${transaction.total}</td>
                    <td><button>Details</button></td>
                </tr>`;
                transactionTableBody.innerHTML += row;
            });
        });
}

// Function to delete user
function deleteUser(userId) {
    fetch(`?action=delete_user&id=${userId}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User deleted successfully');
            fetchUsers(); // Refresh the user table
        } else {
            alert('Failed to delete user');
        }
    });
}

// Initializing dashboard
document.addEventListener('DOMContentLoaded', () => {
    fetchUsers();
    fetchTransactions();
});
