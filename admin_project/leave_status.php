<?php
include('db.php');


$id = $_GET['id'];
$status = $_GET['status'];


$id = mysqli_real_escape_string($conn, $id);
$status = mysqli_real_escape_string($conn, $status);

$query = "UPDATE leaveform SET status='$status' WHERE id='$id'";
$result = mysqli_query($conn, $query);

if ($result) {
   
    header('Location: add_leave.php');
    exit();
} else {
   
    echo "Error updating leave status: " . mysqli_error($conn);
   
}
?>