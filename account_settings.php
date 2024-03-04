<?php
// Include necessary files and database connection
include('includes/database.php');  // Include database connection file
include('includes/header.php');    // Include header file

// Fetch user information from the session or database
$userId = $_SESSION['user_id'];    // Replace with your actual session variable
$selectQuery = "SELECT username, email FROM users WHERE user_id = ?";
$stmt = $dbc->prepare($selectQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <!-- Include  CSS styles -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div>

    <h1>Account Settings and Profile Management</h1>
    <!-- Display user information retrieved from the database -->
    <h2>Your Profile</h2>

    <?php
    // Display user information
    echo '<p>Username: ' . $username . '</p>';
    echo '<p>Email: ' . $email . '</p>';

    // Retrieve profile picture path from the database (adjust the query based on your database schema)
    $selectProfilePictureQuery = "SELECT profile_picture FROM users WHERE user_id = ?";
    $stmtProfilePicture = $dbc->prepare($selectProfilePictureQuery);
    
    if ($stmtProfilePicture) {
        $stmtProfilePicture->bind_param("i", $userId);
        $stmtProfilePicture->execute();
        $stmtProfilePicture->bind_result($profilePicturePath);
    
        // Check if the fetch was successful or if the value is NULL
        if ($stmtProfilePicture->fetch() || $profilePicturePath === null) {
            // User profile picture path fetched successfully or is NULL
            $stmtProfilePicture->close();
        } else {
            // Error fetching user profile picture path
            echo "Error fetching user profile picture path";
            $stmtProfilePicture->close();
            // Handle the error as needed (redirect, display an error message, etc.)
            exit();
        }
    } else {
        // Error preparing the statement for profile picture
        echo "Error preparing profile picture statement: " . $dbc->error;
        // Handle the error as needed (redirect, display an error message, etc.)
        exit();
    }
    

    // Display existing profile picture if available
    if ($profilePicturePath) {
        echo '<img src="' . $profilePicturePath . '" alt="Profile Picture" width="150">';
    } else {
        echo '<p>No profile picture available</p>';
    }
    ?>


    <!-- Form to update account settings -->
    <h2>Update Account Settings</h2>
    <form action="process_update_account.php" method="post">
        <div class="form-group">
            <label for="new_email">New Email:</label>
            <input type="email" name="new_email" id="new_email" placeholder="Enter new email" required>
        </div>

        <button type="submit">Update Account</button>
    </form>

    <!-- Form to upload profile picture -->
    <h2>Upload Profile Picture</h2>
    <form action="process_upload_picture.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_picture">Choose a file:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
        </div>

        <button type="submit">Upload Picture</button>
    </form>

    <!-- Link to change password -->
    <h2>Change Password</h2>
    <a href="change_password.php" class="dashboard-button">Change Password</a>

    <!-- Link to return to the public user dashboard -->
    <a href="public_user_dashboard.php" class="dashboard-button">Back to Dashboard</a>
</div>

    <!-- Include the footer content -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
