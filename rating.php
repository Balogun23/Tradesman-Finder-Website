<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Rating Form</title>
</head>
<body>
    
<?php
// Include the header content
include('includes/header.php');
include('includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted with a valid rating
    if (
        isset($_POST['rating']) && is_numeric($_POST['rating']) && $_POST['rating'] >= 1 && $_POST['rating'] <= 5 &&
        isset($_POST['keyword']) && !empty($_POST['keyword']) // New: Check for the presence of the keyword
    ) {
        $rating = $_POST['rating'];
        $keyword = $_POST['keyword']; // Get the keyword from the form

        // Sanitize and validate other form inputs if needed

        $userId = $_SESSION['user_id']; // Assuming you have a user session
        $comment = $_POST['comment'];

        // Validate the keyword against the database
        $validateKeywordQuery = "SELECT * FROM job_requests WHERE unique_keyword = ? AND status = 'Completed'";
        $stmtKeyword = $dbc->prepare($validateKeywordQuery);

        if (!$stmtKeyword) {
            // Handle the error
            die('Prepare Error: ' . $dbc->error);
        }
        
        $stmtKeyword->bind_param("s", $keyword);
        $stmtKeyword->execute();
        
        $result = $stmtKeyword->get_result();
        

        if ($result->num_rows > 0) {
            // Keyword is valid, proceed with rating submission

            // Insert the rating into the ratings table
            $insertQuery = "INSERT INTO ratings (user_id, tradesman_id, rating, comment) VALUES (?, ?, ?, ?)";
            $stmt = $dbc->prepare($insertQuery);
            $stmt->bind_param("iiis", $userId, $tradesmanId, $rating, $comment);
            
            if ($stmt->execute()) {
                // Rating successfully added to the database
                echo "Rating submitted successfully!";
            } else {
                // Handle database error
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Invalid keyword or job not marked as completed
            echo "Invalid keyword or the job is not marked as completed!";
        }

        $stmtKeyword->close();
    } else {
        // Invalid rating value or missing keyword
        echo "Invalid rating value or missing keyword!";
    }
}
?>

<form method="post" action="">
<div class="form-group">
    <h1>Submit Rating</h1>
    <label for="rating">Rating:</label>
    <div class="star-rating">
        <input type="radio" id="5" name="rating" value="5" title="Excellent" required>
        <label for="5" title="Excellent">★★★★★<br>Exceptional work, exceeding expectations in all aspects.</label>

        <input type="radio" id="4" name="rating" value="4" title="Very Good">
        <label for="4" title="Very Good">★★★★☆<br>Work exceeded expectations, above average.</label>

        <input type="radio" id="3" name="rating" value="3" title="Good">
        <label for="3" title="Good">★★★☆☆<br>Work met the average expectations.</label>

        <input type="radio" id="2" name="rating" value="2" title="Fair">
        <label for="2" title="Fair">★★☆☆☆<br>Work was below the expected standard.</label>

        <input type="radio" id="1" name="rating" value="1" title="Poor">
        <label for="1" title="Poor">★☆☆☆☆<br>Work quality did not meet expectations.</label>

    </div>
</div>

<div class="form-group">
    <label for="keyword">Unique Keyword:</label>
    <input type="text" id="keyword" name="keyword" placeholder="Enter unique keyword" required>
</div>

<div class="form-group">
    <label for="comment">Comment:</label>
    <textarea id="comment" name="comment" placeholder="Enter your comment"></textarea>
</div>

<!-- Submit button -->
<button type="submit">Submit Rating</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted with a valid rating
    if (
        isset($_POST['rating']) && is_numeric($_POST['rating']) && $_POST['rating'] >= 1 && $_POST['rating'] <= 5 &&
        isset($_POST['keyword']) && !empty($_POST['keyword']) // New: Check for the presence of the keyword
    ) {
        $rating = $_POST['rating'];
        $keyword = $_POST['keyword']; // Get the keyword from the form

        // Sanitize and validate other form inputs if needed
        $userId = $_SESSION['user_id'];
        $comment = $_POST['comment'];

        // Validate the keyword against the database
        $validateKeywordQuery = "SELECT * FROM job_requests WHERE unique_keyword = ? AND status = 'Completed'";
        $stmtKeyword = $dbc->prepare($validateKeywordQuery);
        $stmtKeyword->bind_param("s", $keyword);
        $stmtKeyword->execute();
        $result = $stmtKeyword->get_result();

        if ($result->num_rows > 0) {
            // Keyword is valid, proceed with rating submission

            // Insert the rating into the ratings table
            $insertQuery = "INSERT INTO ratings (user_id, rating, comment) VALUES (?, ?, ?)";
            $stmt = $dbc->prepare($insertQuery);
            $stmt->bind_param("iis", $userId, $rating, $comment);
            
            if ($stmt->execute()) {
                // Rating successfully added to the database
                echo "Rating submitted successfully!";
            } else {
                // Handle database error
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Invalid keyword or job not marked as completed
            echo "Invalid keyword or the job is not marked as completed!";
        }

        $stmtKeyword->close();
    } else {
        // Invalid rating value or missing keyword
        echo "Invalid rating value or missing keyword!";
    }
}

?>

<?php
    // Include the footer content
    include('includes/footer.php');
    ?>
</body>

</html>