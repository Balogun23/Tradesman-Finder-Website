<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communication Tools</title>
    <!-- Include CSS styles for a simple chat layout -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
   
    <div>
        <h1>Communication Tools</h1>

        <!-- Display chat interface -->
        <div class="chat-container">
            <!-- Display chat messages -->
            <div id="chat-messages">
                <!-- Messages will be dynamically loaded here -->
                <?php
                // Function to get chat messages from the database
                function getChatMessages($dbc, $senderId, $receiverId, $isTradesman) {
                    // Determine the columns for sender and receiver based on the user type
                    $senderColumn = $isTradesman ? 'tradesman_id' : 'user_id';
                    $receiverColumn = $isTradesman ? 'user_id' : 'tradesman_id';

                    // Replace the query with your actual query to fetch chat messages
                    $query = "SELECT cm.*, sender.username as sender_username, receiver.username as receiver_username 
                              FROM chat_messages cm 
                              INNER JOIN users sender ON cm.sender_id = sender.user_id
                              INNER JOIN users receiver ON cm.receiver_id = receiver.user_id
                              WHERE (cm.sender_id = '$senderId' AND cm.receiver_id = '$receiverId') 
                                 OR (cm.sender_id = '$receiverId' AND cm.receiver_id = '$senderId') 
                                 AND cm.$senderColumn = '$senderId' 
                                 AND cm.$receiverColumn = '$receiverId'
                              ORDER BY cm.timestamp DESC LIMIT 20";

                    $result = mysqli_query($dbc, $query);

                    if (!$result) {
                        echo "Error: " . mysqli_error($dbc);
                        return []; // Return an empty array in case of an error
                    }

                    $messages = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $messages[] = $row;
                    }

                    return $messages;
                }
                ?>
            </div>

            <!-- Chat input form -->
            <form action="process_send_message.php" method="post">
                <!-- Hidden input for receiver_id -->
                <input type="hidden" name="receiver_id" value="<?php echo $_SESSION['user_id']; ?>">

                <!-- Message input -->
                <input type="text" name="message" placeholder="Type your message..." required>

                <!-- Submit button -->
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <!-- Include the footer content -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
