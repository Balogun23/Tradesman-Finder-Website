<!-- reset_password.php -->
<?php
include('includes/database.php');
include('includes/header.php');
?>
<!-- Form to specify and reset a user's password -->
<form action="process_reset_password.php" method="post">
    <p>Specify and reset a user's password:</p>

    <!-- Input field to specify the username or user ID to reset password -->
    <label for="user_identifier">Specify User (Username or ID):</label>
    <input type="text" name="user_identifier" id="user_identifier" required>

    <!-- Input field for the new password -->
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required>

    <button type="submit">Reset Password</button>
</form>

<?php include('includes/footer.php'); ?>