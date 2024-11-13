<?php
include("db.php");

$query = "SELECT * FROM candidates";
$result = $conn->query($query);
$candidates = [];

while ($row = $result->fetch_assoc()) {
    $candidates[] = $row;
}

echo json_encode($candidates);
$conn->close();
?>
