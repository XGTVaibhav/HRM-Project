<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];


if (!$userprofile) {
    header('location:login_user.php');
}

$_SESSION['last_activity'] = time();


if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    
    session_unset();
    session_destroy();
    header('location:login_user.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap CSS CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- Bootstrap JS CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- Google Fonts CDN Link -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />
    <title>SourceCode User Dashboard</title>
</head>

<?php
include 'db.php';
$id = $_SESSION['$user_name'];
$query = "SELECT * FROM `add_employe` WHERE emp_id = '$id'";
$query_show = mysqli_query($conn, $query);
$show = mysqli_fetch_assoc($query_show);
?>


<body>

<?php
include "include/header_us.php";
?>

<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    
    $servername = "localhost";
    $username   = "root";
    $password   =  "";
    $dbname     =  "db_hrmsoftwere";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $selected_month = $_POST["selected_month"];
    $month_name = date("F", strtotime($selected_month));
   
    
    $logged_in_user_id = $_SESSION['$user_name'];

    $sql = "SELECT * FROM emp_salary WHERE month = '$selected_month' AND emp_id = '$logged_in_user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<main class='mt-5 pt-3'>";
        echo "<div class='container'>";
        echo "<center><h3><b>Data for $selected_month</b></h3></center>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='table-dark'>
        <tr>
            <th class='py-2 px-3'>Employee ID</th>
            <th class='py-2 px-3'>Salary (INR)</th>
            <th class='py-2 px-3'>Action</th>
            </tr>
        </thead>
        <tbody>";


        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['emp_id'] . "</td>";
           
            echo "<td>" . $row['netsalary'] . "</td>";
            
            echo "<td><a href='view_details.php?emp_id={$row['emp_id']}&month={$selected_month}' class='btn btn-primary'>View Details</a></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
        echo "</div>";
        echo "</main>";
    } else {
    
        echo "<script>
                Swal.fire({
                    icon: 'info',
                    title: 'No data found',
                    text: 'No data found for $month_name.',
                }).then(function() {
                    window.location.href = 'payslip.php'; 
                });
              </script>";
    }
    $conn->close();
}
?>

<?php
    include 'db.php';
    $e_id = $_SESSION['$user_name'];
    $query = "SELECT * FROM emp_salary WHERE emp_id= '$e_id'";
    $result = $conn->query($query);
    $conn->close();
    ?>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
// JavaScript to track user activity
document.addEventListener('mousemove', function() {
    // Send an AJAX request to update the last activity time in the session
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'user_activity.php', true);
    xhr.send();
});

// Set a timer to check for inactivity and log out the user
setTimeout(function() {
    window.location.href = 'force_logout.php';
}, 180000); // 1 minute = 60,000 milliseconds
</script>
</body>
</html>