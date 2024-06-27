<?php
include('db.php');

$id = $_GET['id'];
$status = $_GET['status'];

// Validate and sanitize user inputs
$id = mysqli_real_escape_string($conn, $id);
$status = mysqli_real_escape_string($conn, $status);

$query = "UPDATE add_query SET status='$status' WHERE id='$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    echo '<script>window.location.replace(document.referrer);</script>';
    exit();
} else {
    echo "Error updating query status: " . mysqli_error($conn);
}
?>
