<?php
// Include database connection
include("db.php");

// Get employee data from POST request
$id = $_POST['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$city = $_POST['city'];
$position = $_POST['position'];
$salary = $_POST['salary'];
$start_date = $_POST['start_date'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Update the employee data in the database
$query = "UPDATE employees SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            age = '$age', 
            city = '$city', 
            position = '$position', 
            salary = '$salary', 
            start_date = '$start_date', 
            email = '$email', 
            phone = '$phone' 
          WHERE id = '$id'";

if ($con->query($query) === TRUE) {
    header("Location: all_employees.php"); // Redirect back to the employee list page
    exit();
} else {
    echo "Error: " . $query . "<br>" . $con->error;
}
?>
