<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $query = "UPDATE employees SET first_name=?, last_name=?, age=?, city=?, position=?, salary=?, start_date=?, email=?, phone=? WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssissssssi", $first_name, $last_name, $age, $city, $position, $salary, $start_date, $email, $phone, $id);
    
    if ($stmt->execute()) {
        header("Location: all_employees.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>
