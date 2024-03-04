<link rel="stylesheet" type="text/css" href="css/style.css">
<?php include('includes/header.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Selection</title>
</head>
<body>
    <h2>Select Your Role</h2>
    <form action="register.php" method="post">
        <label for="actor">I am a:</label>
        <select id="actor" name="actor" required>
            <option value="tradesman">Tradesman</option>
            <option value="client">Client</option>
        </select>
        <button type="submit">Continue</button>
    </form>
</body>
</html>

<?php

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $actor = isset($_POST['actor']) ? $_POST['actor'] : '';

    // Store the selected role in a session variable
    $_SESSION['selected_role'] = $actor;

    // Redirect to the appropriate registration page
    if ($actor === 'client') {
        header('Location: client_registration.php');
        exit();
    } elseif ($actor === 'tradesman') {
        header('Location: tradesman_registration.php');
        exit();
    }
}
?>

<?php include('includes/footer.php'); ?> 
