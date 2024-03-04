<?php
// Include necessary files and database connection
include('includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user identifier and new password from the form
    $userIdentifier = $_POST['user_identifier'];
    $newPassword = $_POST['new_password'];

    // Check if the user exists in the database
    if (userExists($userIdentifier)) {
        // User exists, proceed with password reset
        if (resetUserPassword($userIdentifier, $newPassword)) {
            // Password reset successful
            echo "User password reset successfully.";
        } else {
            // Password reset failed
            echo "Error resetting user password.";
        }
    } else {
        // User does not exist
        echo "User does not exist. Password reset aborted.";
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

// Function to reset the user's password in the database
function resetUserPassword($identifier, $newPassword) {
    global $db; // Assuming $db is your database connection

    // Implement the code to reset the user's password in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = ? OR user_id = ?");
    $stmt->bind_param("sss", $hashedPassword, $identifier, $identifier);
    $result = $stmt->execute();

    // Return true if password reset is successful, false otherwise
    return $result;

    $stmt->close();
}
?>
