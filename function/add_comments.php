<?php
session_start();
// Include your database connection
include('../db/config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input data
    $comment = trim($_POST['comment']);
    $userId = $_SESSION['user_id']; // Assuming the user ID is stored in session

    // Validate inputs
    if (!$comment) {
        echo "Comment cannot be empty.";
        exit();
    }

    // Insert comment into database
    $stmt = $conn->prepare("INSERT INTO comments (user_id, comment, comment_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $userId, $comment);

    if ($stmt->execute()) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Comment Section</title>
    <link rel="stylesheet" href="../JERAConnect1/css/comment.css">
</head>
<body>
    <div class="comment-section">
        <h1>Comment Section</h1>
        <form id="commentForm">
            <textarea id="commentInput" placeholder="Write your comment here..." required></textarea>
            <button type="submit">Post Comment</button>
        </form>
        <div id="commentsList"></div>
    </div>
    <script src="../JERAConnect1/js/comment.js"></script>
</body>
</html>