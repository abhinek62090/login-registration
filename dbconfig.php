<?php
// Database configuration
$host = "localhost";
$user = "username";
$password = "password";
$database = "database_name";

// Establishing database connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
