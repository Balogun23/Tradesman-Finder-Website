<?php
// Include necessary files and database connection
include('includes/database.php');

// Check if the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user identifier from the form
    $userIdentifier = $_POST['user_identifier'];

    // Check if the user exists in the database
    if (userExists($userIdentifier)) {
        // User exists, proceed with the deletion
        if (deleteUser($userIdentifier)) {
            // User successfully deleted
            echo "User successfully deleted.";
        } else {
            // Deletion failed
            echo "Error deleting user.";
        }
    } else {
        // User does not exist
        echo "User does not exist. Deletion aborted.";
    }
} else {
    // Redirect to the appropriate page if accessed without form submission
    header('Location: admin_dashboard.php');
    exit();
}

// Function to check if the user exists in the database
function userExists($identifier) {
    global $db; // Assuming $db is your database connection

    // Implement the code to check if the user exists in the database
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR user_id = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return true if the user exists, false otherwise
    return $result->num_rows > 0;

    $stmt->close();
}

// Function to delete the user from the database
function deleteUser($identifier) {
    global $db; // Assuming $db is your database connection

    // Implement the code to delete the user from the database
    $stmt = $db->prepare("DELETE FROM users WHERE username = ? OR user_id = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $result = $stmt->execute();

    // Return true if deletion is successful, false otherwise
    return $result;

    $stmt->close();
}
?>
