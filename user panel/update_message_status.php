<?php
include('db.php');
session_start();
$userprofile = $_SESSION['$user_name'];
$emp_id='emp_id';
mysqli_query($conn,"update messages set status=1 where to_id=$emp_id");
?>