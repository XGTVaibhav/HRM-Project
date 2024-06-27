<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in
if (!$userprofile) {
    header('location:login_admin.php');
}

// Update the last activity time in the session
$_SESSION['last_activity'] = time();

// Check if the user has been inactive for more than 1 minute
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    // Destroy the session and redirect to the login page
    session_unset();
    session_destroy();
    header('location:login_admin.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style_admin.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>

  <link rel="stylesheet" href="stylezzz.css">
  <title>Sourcecode-Admin Dashboard</title>
 
</head>
<style>
    .form-control::placeholder {
        font-size: 14px;
    }

    .btn-group {
        float: right;
    }

    .error {
        color: red;
    }

    body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }

        main {
            flex: 1;
        }
</style>

<body>
 
  <?php
    include "include/header_ad.php";
  ?>
  
<main class="mt-5 pt-3">
    <div class="container">
        <form action="#" method="POST" id="validateForm" novalidate>
            <h2><b>Activity</b></h2><hr>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="date">Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" name="date" id="date" required>
                    <div class="error" id="date_error"></div>
                </div>

                <div class="form-group col-md-12">
                    <label for="event-description">Description<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <textarea class="form-control" id="event-description" placeholder="Write here" name="emp_notice" required></textarea>
                    <div class="error" id="emp_notice_error"></div>
                </div>

                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</main>

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

if (isset($_POST['submit'])) {
    $from_date = $_POST['date'];
    $notice = $_POST['emp_notice'];

    if (empty($from_date) || empty($notice)) {
        echo "<script>
            alert('Please fill in all the required fields.');
            window.location.replace('emp_activity.php');
        </script>";
        exit;
    }

    $sql = "INSERT INTO `emp_activity`(`date`,`emp_notice`) VALUES ('$from_date','$notice')";
    $data = mysqli_query($conn, $sql);
    if ($data) {
        echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'Record Inserted Successfully',
          
          }).then(() => {
            window.location.replace('emp_activity.php');
          });
        </script>";
      } else {
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating data.',
          });
        </script>";
      }
}

// Fetch data again after insertion
$sql = "SELECT * FROM `emp_activity` ORDER BY id DESC";
$data = mysqli_query($conn, $sql);

?>

<main>
    <div class="container-fluid mt-5">
       <center> <h2><b>Manage Activity</b></h2></center><hr>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Sr_No</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th width="10%">Action</th>
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
                    <td>
                    <div class='btn-group'>
                    <a href='emp_activityupdate.php?id=" . $result['id'] . "' class='btn btn-info text-white'><i class='fa fa-edit' style='font-size: 14px;'></i></a>
                    <a href='emp_activitydelete.php?id=" . $result['id'] . "' class='btn btn-danger text-white' style='background-color: #ed112e; margin-left: 20px;'><i class='fa fa-trash' style='font-size: 14px;'></i></a>
                </div>
                </td>
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