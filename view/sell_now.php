<?php
include('../db/config.php');

// Handle the form submission to add a new product listing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $image = $_FILES['image']['name'];
    $description = $_POST['description'];
    $contact = $_POST['contact'];
    $region = $_POST['region'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $name = $_POST['name']; // Person's name

    // Save the image to the server
    $imagePath = 'uploads/' . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    // Insert the product details into the database
    $sql = "INSERT INTO products (image, description, contact_info, region, price, status, name) 
            VALUES ('$imagePath', '$description', '$contact', '$region', $price, '$status', '$name')";

    if ($conn->query($sql) === TRUE) {
        echo "New product listing added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all product listings from the database
$sql = "SELECT * FROM products ORDER BY date_added DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coconut Marketplace</title>
    <link rel="stylesheet" href="../css/sell_now.css">
</head>
<body>
    <!-- Go Back Button -->
    <button onclick="goBack()" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Go Back
    </button>
    
    <header>
        <h1>Coconut Marketplace</h1>
    </header>
    <main>
        <!-- Form for adding/editing products -->
        <section id="form-section">
            <h2>Adding coconuts to be sold!</h2>
            <form method="POST" enctype="multipart/form-data">
                <!-- Name of the person -->
                <label for="name">Your Name:</label>
                <input type="text" name="name" placeholder="Enter your name" required>

                <!-- Upload Image -->
                <label for="image">Upload Image:</label>
                <input type="file" name="image" accept="image/*" required>

                <!-- Short Description -->
                <label for="description">Short Description:</label>
                <input type="text" name="description" placeholder="Enter description" required>

                <!-- Contact Info -->
                <label for="contact">Contact Info:</label>
                <input type="text" name="contact" placeholder="Enter contact info" required>

                <!-- Region -->
                <label for="region">Region:</label>
                <input type="text" name="region" placeholder="Enter region" required>

                <!-- Price -->
                <label for="price">Price (Gh₵):</label>
                <input type="number" name="price" placeholder="Enter price" required>

                <!-- Status -->
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                </select>

                <button type="submit">Add Product</button>
            </form>
        </section>

        <!-- Product Listings -->
        <section id="product-list-section">
            <h2>Your Coconut Listings</h2>
            <div id="product-list">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='product-item'>";
                        echo "<img src='" . $row['image'] . "' alt='Product Image'>";
                        echo "<p>Name: " . $row['name'] . "</p>"; // Display name
                        echo "<p>Description: " . $row['description'] . "</p>";
                        echo "<p>Contact Info: " . $row['contact_info'] . "</p>";
                        echo "<p>Region: " . $row['region'] . "</p>";
                        echo "<p>Price: Gh₵" . $row['price'] . "</p>";
                        echo "<p>Status: " . $row['status'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No products listed yet.</p>";
                }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Coconut Marketplace</p>
    </footer>

    <script>
        // Function to go back to the Regular Admin Dashboard
        function goBack() {
            window.location.href = 'Regular_Admin_dashboard.php'; // Redirect to the Regular Admin Dashboard
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
