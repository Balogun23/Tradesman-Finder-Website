<?php
// Include necessary files and database connection
require('includes/database.php');
include('includes/header.php');

// Check if the request method is GET and tradesman_id is set in the query parameters
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['tradesman_id'])) {
    // Sanitize the tradesman_id to prevent SQL injection
    $tradesman_id = $dbc->real_escape_string($_GET['tradesman_id']);
    
    // Query to retrieve tradesman details based on tradesman_id
    $query = "SELECT * FROM users WHERE user_id = $tradesman_id";  // Adjusted column name
    $result = $dbc->query($query);
    
    // Check if the query executed successfully
    if ($result) {
        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Fetch tradesman details
            $tradesman = $result->fetch_assoc();
    
            // Check if essential indexes exist in the $tradesman array
            if (isset($tradesman['user_id']) && isset($tradesman['username']) && isset($tradesman['skills']) && isset($tradesman['location']) && isset($tradesman['professional_certification']) && isset($tradesman['hourly_rate'])) {
                // Display detailed tradesman information
                echo '<h2>' . $tradesman['username'] . '</h2>';
                echo '<p>Skills: ' . $tradesman['skills'] . '</p>';
                echo '<p>Location: ' . $tradesman['location'] . '</p>';
                echo '<p>Professional Certification: ' . $tradesman['professional_certification'] . '</p>';
                echo '<p>Hourly Rate: $' . $tradesman['hourly_rate'] . '</p>';
    
                // Link to view ratings page
                echo '<a href="view_ratings.php?tradesman_id=' . $tradesman_id . '">View Ratings</a>';
            } else {
                echo 'Invalid data for the tradesman in the database.';
            }
        } else {
            echo 'Tradesman not found.';
        }
    } else {
        // Output the specific error message from the database
        echo 'Error executing the query: ' . $dbc->error;
    }
}

// Include the footer content
include('includes/footer.php');
?>
