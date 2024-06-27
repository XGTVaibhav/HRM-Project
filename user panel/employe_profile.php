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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style_admin.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="stylezzz.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

  <title>SourceCode User Dashboard</title>
  <style>
    body {
      background-color:white;
    }
    .sam1 {
      position: relative;
      height: 250px;
      background-color: #392b45;
      border: 2px solid black;
    }

    .sam-1 {
      height: 250px;
      border: 2px solid black;
      width: 300px;
    }

    .box-color {
      background-color: #e4e8e3;
    }
  </style>
</head>

<?php
include 'db.php';
$id = $_SESSION['$user_name'];
$query = "SELECT * FROM `add_employe` WHERE emp_id = '$id'";
$query_show = mysqli_query($conn, $query);
$show = mysqli_fetch_assoc($query_show);
?>


<style>
  body{
    background-color: #e4e8e3;
  }
  .a1{
    background-color: #2d1540;
    position: relative;
  }
  .a2{
    color: #e4e8e3;
    margin-left: 300px;
  }
  .a3{
    width: 250px;
    height: 300px;
    position: absolute;
    right: 100px;
    top: 50%;

  }
  .a3 img{
    width: 100%;
    height: 100%;
  }
  .a4{
    border: 2px solid grey;
    height: 300px;
    margin: 100px 0 0 0;
  }
  .sam{
    width: 100%;
  }
  
 
</style>

<body>

  <?php
  include "include/header_us.php";
  ?>

<main class="mt-5 pt-3">
  <section class="h-100">
    <div class="container bg-white py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
          <div class="card">
            <div class="rounded-top text-white d-flex flex-row" style="background-color:#331a47; height:200px;">
              <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                <img src="<?php echo $show['uploadfile']; ?>" alt="Employee Image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
              </div>
              <div class="ms-3" style="margin-top: 130px;">
                <h3><b><?php echo $show['emp_name']; ?></b></h3>
                <h6><i class="bi bi-briefcase-fill"></i><?php echo $show['designation']; ?></h6>
              </div>
            </div>
            <div class="p-4 text-black" style="background-color: #f8f9fa;">
              <div class="d-flex justify-content-end text-center py-1">
                <div>
                  <h3><b>Contact Info</b></h3>
                  <p><i class="bi bi-envelope"></i> <?php echo $show['email']; ?></p>
                  <p><i class="bi bi-telephone-forward-fill"></i><?php echo $show['emp_mob1']; ?></p>
                </div>
              </div>
            </div>
            <div class="card-body p-4 text-black row">
              <div class="col-md-6">
                <h3><b>Personal Info</b></h3>
                <div class="p-4" style="background-color: #f8f9fa;">
                  <p class="font-italic mb-1"><i class="fa-solid fa-user"></i><?php echo $show['emp_name']; ?></p>
                  <p class="font-italic mb-1"><i class="fa-solid fa-user"></i><?php echo $show['gender']; ?></p>
                  <p class="font-italic mb-1"><i class="fa-solid fa-pen-nib"></i><?php echo $show['emp_id']; ?></p>
                  <p class="font-italic mb-1"><i class="fa-solid fa-cake-candles"></i><?php echo $show['emp_dob']; ?></p>
                  <p class="font-italic mb-0"><i class="bi bi-geo-alt-fill"></i><?php echo $show['emp_padd']; ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <h3><b>Bank Details</b></h3>
                <div class="p-4" style="background-color: #f8f9fa;">
                  <p class="font-italic mb-1"><b>Bank Name:</b> <span><?php echo $show['bank_name']; ?></span></p>
                  <p class="font-italic mb-1"><b>AC Number:</b> <span><?php echo $show['ac_num']; ?></span></p>
                  <p class="font-italic mb-1"><b>Branch Name:</b> <span><?php echo $show['branch_name']; ?></span></p>
                  <p class="font-italic mb-1"><b>IFSC: </b><span><?php echo $show['bank_code']; ?></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>
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
 