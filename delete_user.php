<!-- Include the header content -->
<?php include('includes/header.php'); ?>

<div>
    <!-- Form to specify and confirm deletion of a user account -->
    <form action="process_delete_user.php" method="post">
        <p>Specify and confirm deletion of a user account:</p>

        <!-- Input field to specify the username or user ID to delete -->
        <label for="user_identifier">Specify User (Username or ID):</label>
        <input type="text" name="user_identifier" id="user_identifier" required>

        <!-- Confirmation step -->
        <p>Are you sure you want to delete this user account?</p>
        
        <!-- Submit button to confirm deletion -->
        <button type="submit">Yes, Delete</button>

        <!-- Link to cancel and go back to the admin dashboard -->
        <a href="admin_dashboard.php">No, Cancel</a>
    </form>
</div>

<!-- Include the footer content -->
<?php include('includes/footer.php'); ?>
