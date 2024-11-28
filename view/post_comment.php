<?php
// Include database configuration file
include('../db/config.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_comment'])) {
    // Sanitize and validate user input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $type = $conn->real_escape_string($_POST['type']);
    $region = $conn->real_escape_string($_POST['region']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Validate lengths to fit database schema
    if (strlen($name) > 255 || strlen($email) > 255 || strlen($region) > 255) {
        die(json_encode(["status" => "error", "message" => "Name, email, or region exceeds the maximum length of 255 characters."]));
    }
    if (strlen($contact) > 15) {
        die(json_encode(["status" => "error", "message" => "Contact number exceeds the maximum length of 15 characters."]));
    }

    // Insert the comment into the database
    $sql = "INSERT INTO comments (name, email, contact, type, region, comment)
            VALUES ('$name', '$email', '$contact', '$type', '$region', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Comment posted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error posting comment: " . $conn->error]);
    }

    // Close the database connection
    $conn->close();
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
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

        <!-- Comment Form -->
        <form action="podt_comment.php" method="POST" id="commentForm">
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

            <button type="submit" name="post_comment">Post Comment</button>
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
</body>
</html>

