<?php
include "db.php";

if (isset($_POST['employeeName'])) {
    $employeeName = mysqli_real_escape_string($conn, $_POST['employeeName']);
    $query = "SELECT emp_id FROM emp_rating WHERE emp_name = '$employeeName'";
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['emp_id'];
    } else {
        echo "Employee not found";
    }
} else {
    echo "Invalid request";
}
?>