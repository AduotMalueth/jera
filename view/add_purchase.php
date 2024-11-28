<?php
// Include database connection
include('../db/config.php');

// Insert new purchase if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $purchase_date = $_POST['purchase_date'];
    $region = $_POST['region'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // Calculate total price
    $total_price = $quantity * $unit_price;

    // SQL query to insert purchase into the database
    $sql = "INSERT INTO buy_now (purchase_date, region, quantity, unit_price, total_price) 
            VALUES ('$purchase_date', '$region', $quantity, $unit_price, $total_price)";

    if ($conn->query($sql) === TRUE) {
        // Successfully added
        // No need to display a message here, just refresh the page to show new purchase
    } else {
        // Error occurred
        // Handle error here
    }
}

// Fetch all purchase records from the database to display
$sql = "SELECT * FROM buy_now ORDER BY purchase_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Here</title>
    <link rel="stylesheet" href="../css/add_purchase.css">
</head>
<body>
    <header class="header">
        <h1>Purchase here!</h1>
    </header>
    <main>
        <!-- Go Back Button -->
        <button onclick="goBack()" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Go Back
        </button>

        <!-- History Section -->
        <section class="history-section">
            <h2>Purchase History</h2>
            <!-- Button to open the Add Purchase modal -->
            <button class="add-btn" onclick="openAddPurchaseModal()">+ Add Purchase</button>
            <table id="purchaseHistoryTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Region</th>
                        <th>Quantity</th>
                        <th>Unit Price (GHS)</th>
                        <th>Total Price (GHS)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="purchaseTableBody">
                    <?php
                    // Check if there are any records to display
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['purchase_date'] . "</td>";
                            echo "<td>" . $row['region'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['unit_price'] . "</td>";
                            echo "<td>" . $row['total_price'] . "</td>";
                            echo "<td></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Coconut Marketplace</p>
    </footer>

    <!-- Add Purchase Modal -->
    <div id="addPurchaseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addPurchaseModal')">&times;</span>
            <h3>Add Purchase</h3>
            <form id="addPurchaseForm" method="POST" action="">
                <label for="purchaseDate">Date:</label>
                <input type="date" name="purchase_date" required>

                <label for="purchaseRegion">Region:</label>
                <select name="region" required>
                    <option value="">Select Region</option>
                    <option value="Greater Accra">Greater Accra</option>
                    <option value="Ashanti">Ashanti</option>
                    <option value="Western">Western</option>
                    <!-- Add more regions as needed -->
                </select>

                <label for="purchaseQuantity">Quantity:</label>
                <input type="number" name="quantity" required>

                <label for="unitPrice">Unit Price (Gh₵):</label>
                <input type="number" name="unit_price" step="0.01" required>

                <button type="submit">Add Purchase</button>
            </form>
        </div>
    </div>

    <script>
        // Function to open the modal
        function openAddPurchaseModal() {
            document.getElementById("addPurchaseModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Close the modal if the user clicks outside the modal content
        window.onclick = function(event) {
            var modal = document.getElementById("addPurchaseModal");
            if (event.target == modal) {
                closeModal('addPurchaseModal');
            }
        }

        // Function to go back to the Regular Admin Dashboard
        function goBack() {
            window.location.href = 'Regular_Admin_dashboard.php'; // Redirect to the Regular Admin Dashboard
        }
    </script>

    <script src="../js/buy_now.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
