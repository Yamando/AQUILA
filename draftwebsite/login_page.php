<?php
session_start();

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($email) && !empty($password)) {
        // Query to check if user exists
        $stmt = $con->prepare("SELECT * FROM register WHERE email = ? AND pass = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, start a session and redirect to dashboard
            $_SESSION['user'] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid login
            echo "<script type='text/javascript'>alert('Invalid email or password.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script type='text/javascript'>alert('Please fill in both fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQUILA CORPS</title>
    <link rel="stylesheet" href="login_page.css">
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop class="background-video">
    <source src="design/bg.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="login-container">
    <div class="login-box">
        <!-- Logo -->
        <img src="design/aquila.png" alt="System Logo" class="logo">

        <!-- Title -->
        <h2>Aquila Tekno Solutions Inc.</h2>

        <!-- Login Form -->
        <form method="POST">
            <div class="input-group">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="button-group">
                <button type="submit" class="login-button">Log in</button>
                <button type="button" class="register-button" onclick="window.location.href='register.php'">Register</button>
            </div>
        </form>
        <!-- Forgot Password Link -->
        <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
    </div>
</div>

</body>
</html>
