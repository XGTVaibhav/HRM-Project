<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['employeeId'])) {
    $employeeId = mysqli_real_escape_string($conn, $_POST['employeeId']);

    // Query to get the employee name based on the ID
    $query = "SELECT emp_name FROM add_employe WHERE emp_id = '$employeeId'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        echo $row['emp_name'];
    } else {
        echo ''; // Return an empty string if no employee found
    }
}
?>