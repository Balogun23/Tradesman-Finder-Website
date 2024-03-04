<?php
// process_send_message.php

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in. Please log in and try again.";
    exit;
}

// Connect to the database
require('includes/database.php');

// Function to store chat messages in the database
function storeChatMessage($senderId, $receiverId, $message, $dbc) {
    // Use mysqli_real_escape_string to prevent SQL injection
    $senderId = mysqli_real_escape_string($dbc, $senderId);
    $receiverId = mysqli_real_escape_string($dbc, $receiverId);
    $message = mysqli_real_escape_string($dbc, $message);

    // Your INSERT query
    $query = "INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES ('$senderId', '$receiverId', '$message')";
    
    // Execute the query
    if (mysqli_query($dbc, $query)) {
        return true; // Message stored successfully
    } else {
        echo "Error: " . mysqli_error($dbc); // Log the MySQL error
        return false; // Failed to store message
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $senderId = $_SESSION['user_id']; // Assuming user_id is the sender's ID
    $receiverId = isset($_POST['receiver_id']) ? $_POST['receiver_id'] : null; // Check if receiver_id is set
    $message = isset($_POST['message']) ? $_POST['message'] : null; // Check if message is set

    // Store the chat message in the database
    if ($receiverId !== null && $message !== null && storeChatMessage($senderId, $receiverId, $message, $dbc)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message. Please try again.";
    }
}
?>

