<?php
session_start();

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $gender = $_POST['gender'];
    $num = $_POST['number'];
    $address = $_POST['address'];
    $gmail = $_POST['mail'];
    $password = $_POST['pass'];

    if (!empty($gmail) && !empty($password) && !is_numeric($gmail)) {
        $stmt = $con->prepare("INSERT INTO register (fname, lname, gender, cnum, address, email, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstname, $lastname, $gender, $num, $address, $gmail, $password);

        if ($stmt->execute()) {
            echo "<script type='text/javascript'> alert('Successfully Registered'); </script>";
        } else {
            echo "<script type='text/javascript'> alert('Error: " . $stmt->error . "'); </script>";
        }
        $stmt->close();
    } else {
        echo "<script type='text/javascript'> alert('Please Enter Valid Information'); </script>";
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
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
        }
        .signup {
            background-color: #283a7a; /* Dark blue */
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        .signup h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup label {
            display: block;
            margin: 10px 0 5px;
        }
        .signup input[type="text"],
        .signup input[type="password"],
        .signup input[type="email"],
        .signup input[type="tel"],
        .signup input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .signup input[type="submit"] {
            background-color: #3053a6;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        .signup input[type="submit"]:hover {
            background-color: #d48a1c; /* Darker orange */
        }
        .signup p {
            text-align: center;
            margin-top: 10px;
        }
        .signup p a {
            color: #f5a623;
            text-decoration: none;
        }
        .signup p a:hover {
            text-decoration: underline;
        }
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="signup">
        <h1>Register</h1>
        <form method="POST">
    <label for="firstName">First Name</label>
    <input type="text" id="firstName" name="fname" required>
    
    <label for="lastName">Last Name</label>
    <input type="text" id="lastName" name="lname" required>
    
    <label for="gender">Gender</label>
    <input type="text" id="gender" name="gender" required>
    
    <label for="contact">Contact Number</label>
    <input type="text" id="contact" name="number" required>

    <label for="contact">Address</label>
    <input type="text" id="contact" name="address" required>
    
    <label for="email">Email</label>
    <input type="email" id="email" name="mail" required>
    
    <label for="password">Password</label>
    <input type="password" id="password" name="pass" required>
    
    <input type="submit" value="Submit">
</form>
        <p>Already have an account? <a href="login_page.php">Login Here</a></p>
    </div>

    <!-- Video Background -->
    <video autoplay muted loop class="background-video">
        <source src="design/bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</body>
</html>
