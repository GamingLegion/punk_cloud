<?php
// Simulated user data (Replace with actual user authentication logic)
$valid_username = "admin";
$valid_password = "password";

// Retrieve username and password from the request
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the submitted username and password match the valid credentials
if ($username === $valid_username && $password === $valid_password) {
    echo "success"; // Return success message if login is successful
} else {
    echo "error"; // Return error message if login is unsuccessful
}
?>
