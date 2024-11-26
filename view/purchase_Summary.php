<?php
session_start();
// Include your database connection
//include './db/config.php';
include('../db/config.php');
// Function to insert data into the purchases table
function addPurchase($data) {
    global $conn;

    $query = "
        INSERT INTO purchases (date, region, quantity, cost, seller, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($query);

    // Correct type string for bind_param
    $stmt->bind_param(
        "ssisss",
        $data['date'],   // Date as string
        $data['region'], // Region as string
        $data['quantity'], // Quantity as integer
        $data['cost'],   // Cost as float (treated as string)
        $data['seller'], // Seller as string
        $data['status']  // Status as string
    );

    if ($stmt->execute()) {
        $stmt->close();
        return true; // Return true on success
    } else {
        error_log("Database Error: " . $stmt->error);
        $stmt->close();
        return false; // Return false on failure
    }
}

// Handle form submission
$message = ''; // Initialize message variable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchaseData = [
        'date' => $_POST['date'],
        'region' => $_POST['region'],
        'quantity' => (int)$_POST['quantity'],
        'cost' => (float)$_POST['cost'],
        'seller' => $_POST['seller'],
        'status' => $_POST['status']
    ];

    if (addPurchase($purchaseData)) {
        //$message = "Purchase added successfully!";
    } else {
        //$message = "Failed to add purchase. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Purchase</title>
    <link rel="stylesheet" href="..Connect1/css/purchase.css">
</head>
<body>
    <div class="container">
        <h1>Add a Purchase</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="purchase_Summary.php" method="POST">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="region">Region:</label>
            <input type="text" id="region" name="region" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="cost">Cost:</label>
            <input type="number" step="0.01" id="cost" name="cost" required>

            <label for="seller">Seller:</label>
            <input type="text" id="seller" name="seller" required>

            <label for="status">Payment Status:</label>
            <select id="status" name="status" required>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
            </select>

            <button type="submit">Add Purchase</button>
        </form>
        <button onclick="window.location.href='regular_dashboard.php'" class="back-button">Go Back</button>
    </div>
    <script src="../js/purchase.js"></script>
</body>
</html>
