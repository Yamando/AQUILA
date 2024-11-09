<?php
// Start a session
session_start();

// Demo credentials for testing purposes
$demo_username = 'paulo';
$demo_password = '123';
// Get the username and password from the form
$username = $_POST['username'] ?? 'paulo';
$password = $_POST['password'] ?? '123';

// Check if the credentials are correct
if ($username === $demo_username && $password === $demo_password) {
    // Set session variables
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    
    // Redirect to the dashboard page
    header("Location: dashboard.php");
    exit();
} else {
    // Redirect back to the login page with an error
    header("Location: login_page.php");
    exit();
}

