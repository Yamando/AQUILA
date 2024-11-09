<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQUILA CORPS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="login_page.css">
    <style>
        .registration-form {
            width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .registration-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #333;
            background-color: #f9f9f9;
        }
        .registration-form button {
            width: 100%;
            padding: 10px;
            background-color: #283a7a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .registration-form button:hover {
            background-color: #1e2d5b;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop class="background-video">
    <source src="bg.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<!-- Registration Form -->
<div class="registration-form">
    <h2>Register for AQUILA</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $fullName = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["confirm_password"];

        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();

        // Validation checks
        if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
            array_push($errors, "All fields are required.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid.");
        }
        if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long.");
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, "Passwords do not match.");
        }

        // Display errors or proceed with the registration if no errors
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            // Database connection
            require_once "db_register.php";
            
            // Prepare the SQL query
            $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sqli)) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $password_hash);

                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='alert alert-success'>Registration successful! Redirecting...</div>";
                    header("refresh:2;url=login_page.php"); // Redirect to login page after 2 seconds
                    exit(); // Ensure no further code is run after the redirect
                } else {
                    // Execution error
                    die("Error: Could not execute the query.");
                }
            } else {
                // Query preparation error
                die("Error: Could not prepare the SQL statement.");
            }
        }

        // Close the statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    ?>
    <form action="" method="POST">
        <input type="text" class="form-control" name="fullname" placeholder="Full Name:" required>
        <input type="email" class="form-control" name="email" placeholder="Email:" required>
        <input type="password" class="form-control" name="password" placeholder="Password:" required>
        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password:" required>
        <input type="submit" class="btn btn-primary" value="Register" name="submit">
    </form>
</div>

</body>
</html>
