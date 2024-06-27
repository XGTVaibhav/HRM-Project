<?php
include "db.php"; // Include your database connection file

if (isset($_POST['employeeName'])) {
    $employeeName = mysqli_real_escape_string($conn, $_POST['employeeName']);
    $query = "SELECT emp_id FROM emp_rating WHERE emp_name = '$employeeName'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['emp_id'];
    } else {
        echo "Employee ID not found";
    }
} else {
    echo "Invalid request";
}
?>