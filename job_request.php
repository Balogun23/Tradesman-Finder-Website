<?php
// Assuming you have a database connection established

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['job_request_id'])) {
    $job_request_id = $_GET['job_request_id'];
    // Query job request details based on ID
    $query = "SELECT * FROM job_requests WHERE id = $job_request_id";
s}
?>