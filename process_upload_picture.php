<?php
// Include necessary files and database connection
include('includes/database.php');
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the user is logged in and you have the user ID from the session
    $userId = $_SESSION['user_id']; // Replace with your actual session variable

    // Retrieve the current profile picture path from the database
    $selectQuery = "SELECT profile_picture FROM users WHERE user_id = ?";
    $stmt = $dbc->prepare($selectQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($currentProfilePicturePath);
    $stmt->fetch();
    $stmt->close();

    // File upload handling
    $targetDir = "uploads/"; // Replace with your desired upload directory
    $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, the file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES['profile_picture']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can customize this)
    if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg") {
        echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk === 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, upload the file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            // Change the permissions of the "uploads" directory
            chmod($targetDir, 0755);
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Update the user's profile picture path in the database
            $updateQuery = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
            $stmt = $dbc->prepare($updateQuery);
            $stmt->bind_param("si", $targetFile, $userId);

            if ($stmt->execute()) {
                // Delete the previous profile picture file if it exists
                if ($currentProfilePicturePath && file_exists($currentProfilePicturePath)) {
                    unlink($currentProfilePicturePath);
                }

                echo "The file " . htmlspecialchars(basename($_FILES['profile_picture']['name'])) . " has been uploaded and the profile picture has been updated.";
            } else {
                echo "Sorry, there was an error updating the profile picture in the database.";
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
