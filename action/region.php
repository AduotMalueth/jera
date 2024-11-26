<?php
session_start();
// Include your database connection
include('../db/config.php');
// Fetch regions in Ghana
$query = "SELECT * FROM regions WHERE country = 'Ghana'";
$result = $conn->query($query);

// Handle form submission to add a new region
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newRegion = trim($_POST['region_name']);

    if (!empty($newRegion)) {
        $stmt = $conn->prepare("INSERT INTO regions (region_name, country) VALUES (?, 'Ghana')");
        $stmt->bind_param("s", $newRegion);

        if ($stmt->execute()) {
            $message = "Region added successfully!";
        } else {
           // $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        //$message = "Region name cannot be empty!";
    }

    // Refresh the page to display updated list
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regions in Ghana</title>
    <link rel="stylesheet" href="region.css"> <!-- Link to a CSS file -->
</head>
<body>
    <header>
        <h1>Regions in Ghana</h1>
    </header>
    <main>
        <!-- Display Regions -->
        <section>
            <h2>List of Regions</h2>
            <table border="8">
                <thead>
                    <tr>
                        <th>Region ID</th>
                        <th>Region Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['region_id']) ?></td>
                                <td><?= htmlspecialchars($row['region_name']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No regions found for Ghana.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Add New Region -->
        <section>
            <h2>Add a New Region</h2>
            <form action="" method="post">
                <label for="region_name">Region Name:</label>
                <input type="text" id="region_name" name="region_name" required>
                <button type="submit">Add Region</button>
            </form>
            <?php if (isset($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
