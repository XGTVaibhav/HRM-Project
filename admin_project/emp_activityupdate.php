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
  <link rel="stylesheet" href="style_admin.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="stylezzz.css">

    <title>Sourcecode-Admin Dashboard</title>
 <style>
  
  body{
    background-color: #fff;
  }
  h2,label{
        color:black;
    }
    h2{
      text-align:start;
    }
    label{
        font-size:17px;
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
</head>

<body>
<?php
    include 'db.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM emp_activity WHERE id = '$id'";
    $query_show = mysqli_query($conn, $query);
    $show = mysqli_fetch_assoc($query_show);
    
?>

  <?php
    include "include/header_ad.php";
  ?>

<main class="mt-5 pt-3">
    <div class="container">
        <h2><b>Update Activity</b></h2>
        <hr>

        <form action="#" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="date">Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" name="date" value="<?php echo $show['date'];?>">
                </div>

                <div class="form-group col-md-6">
                    <label for="emp_notice">Description<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <textarea rows="4" class="form-control" name="emp_notice" required><?php echo $show['emp_notice'];?></textarea>
                </div>

                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
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


<?php
if (isset($_POST['submit'])) {

$fromdate=$_POST['date'];
  
$notice=$_POST['emp_notice'];
   
$sql= "UPDATE `emp_activity` SET `date`='$fromdate',`emp_notice`='$notice' WHERE `id`='$id'";

$data= mysqli_query($conn,$sql);

  if ($data) {
    // Show a success SweetAlert and redirect
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Record Updated Successfully',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = 'emp_activity.php';
        });
    </script>";
} else {
    // Show an error SweetAlert
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Data not inserted',
            text: 'Something went wrong!',
        });
    </script>";
}
}
?>