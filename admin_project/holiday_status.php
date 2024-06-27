<?php
include('db.php');

$id = $_GET['id'];
$status = $_GET['status'];

// Sanitize and validate input to prevent SQL injection
$id = mysqli_real_escape_string($conn, $id);
$status = mysqli_real_escape_string($conn, $status);

$query = "UPDATE add_holiday SET status=$status WHERE id='$id'";
mysqli_query($conn, $query);

header('Location:manage_holiday.php');
?>
