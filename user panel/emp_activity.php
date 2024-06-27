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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

 
 

  <link rel="stylesheet" href="style_admin.css" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  
  <link rel="stylesheet" href="stylezzz.css">
  <title>SourceCode User Dashboard</title>
  <style>
    body {
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
  <!-- navigation & off-canvas starts -->
  <?php
    include "include/header_us.php";
  ?>
  

<script>

    document.getElementById("validateForm").addEventListener("submit", function (event) {
       
      const date = document.getElementsByName("date")[0];

        const empId = document.getElementsByName("emp_notice")[0];
       
        if (!date.value) {
            displayError("date_error", "Please select date.");
            event.preventDefault();
        } else {
            clearError("date_error");
        }
      

        if (!empId.value) {
            displayError("emp_notice_error", "Please write somthing.");
            event.preventDefault();
        } else {
            clearError("emp_notice_error");
        }

       

      
    }); 

    function displayError(id, message) {
        const errorElement = document.getElementById(id);
        errorElement.textContent = message;
        errorElement.style.color = "red";
    }

    function clearError(id) {
        const errorElement = document.getElementById(id);
        errorElement.textContent = "";
    }
</script>

<?php
include "db.php";
// error_reporting(0);


// Fetch data again after insertion
$sql = "SELECT * FROM `emp_activity` ORDER BY id DESC";
$data = mysqli_query($conn, $sql);

?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
      <center> <h2 id="top"><b>Activities</b></h2></center><hr>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($result = mysqli_fetch_assoc($data)) {
                    echo
                    "<tr>
                        <td>" . $no . "</td>
                        <td>" . date('d/m/Y', strtotime($result['date'])) . "</td>
                        <td>" . $result['emp_notice'] . "</td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
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
    $(document).ready(function () {
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