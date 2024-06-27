<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in
if (!$userprofile) {
    header('location:login_user.php');
}

// Update the last activity time in the session
$_SESSION['last_activity'] = time();

// Check if the user has been inactive for more than 1 minute
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    // Destroy the session and redirect to the login page
    session_unset();
    session_destroy();
    header('location:login_user.php');
    exit();
}

?>

<?php


//error_reporting(0);
$query = "SELECT * FROM add_holiday ORDER BY id DESC"; // Fetch rows in descending order by 'id'";
$data = mysqli_query($conn, $query);
$total= mysqli_num_rows($data);

	if($total !=0) 
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SourceCode User Dashboard</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style_admin.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="stylezzz.css">
  <style>body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }

        main {
            flex: 1;
        }
        </style>
</head>

<body>


  <?php
    include "include/header_us.php";
  ?>

<main class="mt-5 pt-3">
    <div class="container">
        <center><h2><b>All Holidays</b></h2></center><hr>
        <div class="table-responsive">
            <div class="table-wrapper">
                <table id="example" class="table table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">SR</th>
                            <th style="width: 15%;">From Date</th>
                            <th style="width: 15%;">To Date</th>
                            <th style="width: 65%;">Holiday Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1; // Initialize row number
                        while ($result = mysqli_fetch_assoc($data)) {
                            echo "<tr>
                                <td>" . $no . "</td>
                                <td>" . date('d/m/Y', strtotime($result['from_date'])) . "</td>
                                <td>" . date('d/m/Y', strtotime($result['to_date'])) . "</td>
                                <td>" . $result['holiday_name'] . "</td>
                            </tr>";

                            $no++; // Increment row number
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
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