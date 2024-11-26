<?php
session_start();
include("db.php");
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the timezone
date_default_timezone_set('Asia/Manila'); // Ensure this matches your server's timezone

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Step 1: Authenticate user credentials
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate inputs
        if (!empty($email) && !empty($password)) {
            $stmt = $con->prepare("SELECT * FROM register WHERE email = ? AND pass = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User authenticated
                $_SESSION['email'] = $email;

                // Check if the user has the "Remember Me" cookie
                if (isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] === $email) {
                    $_SESSION['user'] = $email;
                    header("Location: dashboard.php");
                    exit();
                }

                // Otherwise, proceed to OTP
                // Generate OTP
                $otp = rand(100000, 999999);

                // Calculate expiration time (5 minutes from now)
                $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                // Save OTP in the database
                $stmt = $con->prepare("INSERT INTO otp_requests (email, otp, expires_at) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $email, $otp, $expires_at);

                if ($stmt->execute()) {
                    // Send OTP to email
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
                        $mail->SMTPAuth = true;
                        $mail->Username = 'aquilatekno@gmail.com'; // Replace with your email
                        $mail->Password = 'ofvrnqpchavqnref'; // Replace with your email password or app password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('aquilatekno@gmail.com', 'Aquila Tekno Solutions');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Your Login OTP';
                        $mail->Body = "Your OTP for login is: <b>$otp</b>";

                        $mail->send();
                        echo "<script type='text/javascript'>alert('OTP sent to your email. Please check your inbox.');</script>";
                        header("Location: otpverify.php"); // Redirect to otpverify.php
                        exit();
                    } catch (Exception $e) {
                        echo "<script type='text/javascript'>alert('Failed to send OTP: {$mail->ErrorInfo}');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Failed to generate OTP. Please try again later.');</script>";
                }
                $stmt->close();
            } else {
                // Invalid credentials
                echo "<script type='text/javascript'>alert('Invalid email or password.');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Please fill in both fields.');</script>";
        }
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
        <form method="POST" id="login-form">
            <div class="input-group">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="button-group">
                <button type="submit" name="login" class="login-button">Log in</button>
                <button type="button" class="register-button" onclick="window.location.href='register.php'">Register</button>
            </div>
        </form>

        <!-- Forgot Password Link -->
        <a href="forgotps.php" class="forgot-password">Forgot Password?</a>
    </div>
</div>

</body>
</html>