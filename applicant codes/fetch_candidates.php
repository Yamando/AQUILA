<?php
include("db.php");
$result = $con->query("SELECT * FROM candidates");
$candidates = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($candidates);
?>
