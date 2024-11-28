<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('../db/config.php'); 

// Handling comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_comment'])) {
    // Sanitize and validate input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $type = $conn->real_escape_string($_POST['type']);
    $region = $conn->real_escape_string($_POST['region']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Validate lengths to fit schema constraints
    if (strlen($name) > 255 || strlen($email) > 255 || strlen($region) > 255) {
        die("<p style='color: red;'>Error: Name, email, or region exceeds the maximum allowed length of 255 characters.</p>");
    }

    if (strlen($contact) > 15) {
        die("<p style='color: red;'>Error: Contact exceeds the maximum allowed length of 15 characters.</p>");
    }

    // Insert comment into the database
    $sql = "INSERT INTO comments (name, email, contact, type, region, comment) 
            VALUES ('$name', '$email', '$contact', '$type', '$region', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Comment posted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Fetch comments from the database
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);

$comments = [];
if ($result) {
    $comments = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<p style='color: red;'>Error fetching comments: " . $conn->error . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="../css/comment.css">
</head>
<body>
    <div class="comment-section">
        <h1>Comment Section</h1>

        <!-- Go Back Button -->
        <button onclick="goBack()" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Go Back
        </button>

        <!-- Comment Form -->
        <form action="add_comment.php" method="POST" id="commentForm">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" maxlength="255" placeholder="Enter your name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" maxlength="255" placeholder="Enter your email" required>

            <label for="contact">Contact:</label>
            <input type="text" name="contact" id="contact" maxlength="15" placeholder="Enter your contact number" required>

            <label for="type">Type:</label>
            <select name="type" id="type" required>
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>

            <label for="region">Region:</label>
            <input type="text" name="region" id="region" maxlength="255" placeholder="Enter your region" required>

            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" placeholder="Write your comment here..." required></textarea>

            <button type="submit" name="post_comment" class="add-btn">+ Post Comment</button>
        </form>

        <!-- Displaying Previous Comments -->
        <div id="commentsList">
            <h3>Previous Comments</h3>
            <ul>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <li>
                            <p><strong><?php echo htmlspecialchars($comment['name']); ?>:</strong> <?php echo htmlspecialchars($comment['comment']); ?></p>
                            <small>Posted on <?php echo date('Y-m-d H:i:s', strtotime($comment['created_at'])); ?></small>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script src="../js/comment.js"></script>
    <script>
        // Function to go back to the Regular Admin Dashboard
        function goBack() {
            window.location.href = 'Regular_Admin_dashboard.php'; // Redirect to the Regular Admin Dashboard
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
