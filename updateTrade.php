<?php
    // Include necessary files and database connection
    include('includes/database.php');
    include('includes/header.php');

    //  Access Trade List
$tradeListQuery = "SELECT * FROM trades";
$tradeListResult = $dbc->query($tradeListQuery);

// Check if there are trades available
if ($tradeListResult->num_rows > 0) {
    // Display the list of trades with an option to update each trade
    while ($trade = $tradeListResult->fetch_assoc()) {
        echo '<p>Trade ID: ' . $trade['trade_id'] . '</p>';
        echo '<p>Trade Name: ' . $trade['trade'] . '</p>';
        echo '<p>Skills: ' . $trade['skills'] . '</p>';
        echo '<p>Professional Certification: ' . $trade['professional_certification'] . '</p>';
        echo '<p>Location: ' . $trade['location'] . '</p>';
        echo '<p>Hourly Rate: ' . $trade['hourly_rate'] . '</p>';
        
        echo '<form method="post" action="updateTrade.php">';
        echo '<input type="hidden" name="trade_id" value="' . $trade['trade_id'] . '">';
        echo '<button type="submit">Update Trade</button>';
        echo '</form>';
        
        echo '<hr>';
    }
} else {
    echo '<p>No trades available.</p>';
}

// Update Trade Information (update_trade.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trade_id'])) {
    $selectedTradeId = $_POST['trade_id'];

    // Retrieve existing trade information based on trade_id
    $getTradeQuery = "SELECT * FROM trades WHERE trade_id = ?";
    $getTradeStmt = $dbc->prepare($getTradeQuery);
    $getTradeStmt->bind_param("i", $selectedTradeId);
    $getTradeStmt->execute();
    $selectedTrade = $getTradeStmt->get_result()->fetch_assoc();
    $getTradeStmt->close();

    // Display a form to modify trade information
    if ($selectedTrade) {
        echo '<h2>Update Trade Information</h2>';
        echo '<form method="post" action="updateTrade.php">';
        echo '<input type="hidden" name="trade_id" value="' . $selectedTrade['trade_id'] . '">';
        echo 'Trade Name: <input type="text" name="trade_name" value="' . $selectedTrade['trade'] . '"><br>';
        echo 'Skills: <input type="text" name="skills" value="' . $selectedTrade['skills'] . '"><br>';
        echo 'Professional Certification: <input type="text" name="professional_certification" value="' . $selectedTrade['professional_certification'] . '"><br>';
        echo 'Location: <input type="text" name="location" value="' . $selectedTrade['location'] . '"><br>';
        echo 'Hourly Rate: <input type="text" name="hourly_rate" value="' . $selectedTrade['hourly_rate'] . '"><br>';
        
        echo '<button type="submit">Save Changes</button>';
        echo '</form>';
    } else {
        echo '<p>Trade not found.</p>';
    }
}

// Close the database connection
$dbc->close();
include('includes/footer.php');

?>