<?php
session_start();
// Include your database connection
include('../db/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input data
    $region = $_POST['user'];
    $quantity = intval($_POST['quantity']);
    $userId = $_SESSION['user_id']; // Assuming the user ID is stored in session

    // Validate inputs
    if (!$region || $quantity <= 0) {
        echo "Invalid input. Please try again.";
        exit();
    }

    // Insert purchase data into database
    $stmt = $conn->prepare("INSERT INTO coconuts (id, user, quantity) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("isi", $userId, $region, $quantity);

    if ($stmt->execute()) {
        echo "Purchase successful!";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coconut Delights</title>
    <link rel="stylesheet" href="../JERAConnect1/css/buy_coconut.css">
    <style>
        .star-rating {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .star {
            font-size: 24px;
            color: lightgray;
            cursor: pointer;
        }

        .star.selected {
            color: gold;
        }
    </style>
</head>
<body>
    <button onclick="goBack()" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Go Back
    </button>
    <h1>Coconut-Inspired Dishes</h1>

    <!-- Search box -->
    <div class="search-container">
        <form action="#" method="get">
            <input type="text" id="searchInput" name="search" placeholder="Search for coconut recipes...">
            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Grid of Coconut Dishes -->
    <div class="recipe-grid" id="recipeGrid">
        <!-- Coconut Dish Cards -->
        <div class="recipe-card">
            <img src="../images/pexels-photo-5945719.jpg" alt="Coconut" style="max-width:100%;height:auto;">
            <h3>Coconut</h3>
            <p>Fluffy rice infused with the rich flavor of coconut milk, perfect as a side dish or a light meal.</p>
            <div class="star-rating" data-dish="Coconut Rice">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <p class="rating-result">No rating yet.</p>
        </div>

        <div class="recipe-card">
            <img src="../images/pexels-photo-11495862 (1).jpg" alt="Coconut Shrimp" style="max-width:100%;height:auto;">
            <h3>Coconut Shrimp</h3>
            <p>Crispy shrimp coated in shredded coconut, served with a tangy dipping sauce.</p>
            <div class="star-rating" data-dish="Coconut Shrimp">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <p class="rating-result">No rating yet.</p>
        </div>

        <!-- Repeat the same structure for other dishes -->
    </div>


    <!-- Grid of Coconut Dishes -->
    <div class="recipe-grid" id="recipeGrid">
        <!-- Coconut Dish Cards -->
        <div class="recipe-card">
            <img src="../images/coconut-1326867.jpg" alt="Coconut Rice" style="max-width:100%;height:auto;">
            <h3>Coconut Rice</h3>
            <p>Fluffy rice infused with the rich flavor of coconut milk, perfect as a side dish or a light meal.</p>
            <div class="star-rating" data-dish="Coconut Rice">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <p class="rating-result">No rating yet.</p>
        </div>

        <div class="recipe-card">
            <img src="../images/coconut-1326867.jpg" alt="Coconut Shrimp" style="max-width:100%;height:auto;">
            <h3>Coconut Shrimp</h3>
            <p>Crispy shrimp coated in shredded coconut, served with a tangy dipping sauce.</p>
            <div class="star-rating" data-dish="Coconut Shrimp">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <p class="rating-result">No rating yet.</p>
        </div>
        <!-- Repeat the same structure for other dishes -->
    </div>
    <!-- Grid of Coconut Dishes -->
    <div class="recipe-grid" id="recipeGrid">
        <!-- Coconut Dish Cards -->
        <div class="recipe-card">
            <img src="../images/green-coconut-2-1382712.webp" alt="Coconut" style="max-width:100%;height:auto;">
            <h3>Coconut</h3>
            <p>Fluffy rice infused with the rich flavor of coconut milk, perfect as a side dish or a light meal.</p>
            <div class="star-rating" data-dish="Coconut Rice">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <p class="rating-result">No rating yet.</p>
        </div>

        <div class="recipe-card">
            <img src="../images/green-coconut-2-1382712.webp" alt="Coconut Green " style="max-width:100%;height:auto;">
            <h3>Coconut Green</h3>
            <p>Crispy shrimp coated in shredded coconut, served with a tangy dipping sauce.</p>
            <div class="star-rating" data-dish="Coconut Shrimp">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <p class="rating-result">No rating yet.</p>
        </div>

        <!-- Repeat the same structure for other dishes -->
    </div>
    <script>
        // Functionality for star rating
        document.querySelectorAll('.star-rating').forEach(ratingContainer => {
            const stars = ratingContainer.querySelectorAll('.star');
            const result = ratingContainer.nextElementSibling;

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = star.dataset.value;

                    // Clear previous selection
                    stars.forEach(s => s.classList.remove('selected'));

                    // Highlight the selected stars
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('selected');
                    }

                    // Update rating result
                    result.textContent = `You rated this ${value} star${value > 1 ? 's' : ''}!`;
                });
            });
        });

        // Back button functionality
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }
    </script>
</body>
</html>
