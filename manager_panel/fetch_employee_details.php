<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['employeeId'])) {
        $employeeId = mysqli_real_escape_string($conn, $_POST['employeeId']);

        $query = "SELECT emp_name FROM add_employe WHERE emp_id = '$employeeId'";
        $result = mysqli_query($conn, $query);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            echo $row['emp_name'];
        } else {
            echo '';
        }
    } elseif (isset($_POST['employeeName'])) {
        $employeeName = mysqli_real_escape_string($conn, $_POST['employeeName']);

        $query = "SELECT emp_id FROM add_employe WHERE emp_name = '$employeeName'";
        $result = mysqli_query($conn, $query);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            echo $row['emp_id'];
        } else {
            echo '';
        }
    }
}
?>