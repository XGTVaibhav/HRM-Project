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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
 
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link rel="stylesheet" href="stylezzz.css">

    <title>Sourcecode-Admin Dashboard</title>

</head>
<!-- <style>
   body{
    background-color: #fff;
    }
     h2,label{
        color:black;
     }
.container {
            padding-left: 10%;
            padding-top: 3%;
            padding-right: 3%;
            margin-left: 13%;
            margin-top: 3%;
            margin-right: 3%;
        }
     h2{
      text-align: start;
    } 

    label{
        font-size:17px;
    }
    .text-center {
      display:flex;
      justify-content:center;
      align-items:center;
    }
</style> -->

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
<body>
<?php
    include 'db.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM emp_notice WHERE id = '$id'";
    $query_show = mysqli_query($conn, $query);
    $show = mysqli_fetch_assoc($query_show);
    
    ?>
 

  <?php
    include "include/header_ad.php";
    ?>

<main class="mt-5 pt-3">
  <div class="container">

    <h2><b>Update Notice</b></h2>
    <hr>

    <form action="#" method="POST" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="event-date">Date:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
          <input type="date" class="form-control" id="dateInput"  name="date" value="<?php echo $show['date'];?>" >
        </div>

        <div class="form-group col-md-6">
          <label for="event-description">Subject<span class="text-danger" style="font-size: 1.2em;">*</span></label>
          <input type="text" class="form-control" name="subject" value="<?php echo $show['subject'];?>" >
        </div>

        <div class="form-group col-md-6">
        <label for="event-description">Employee File</label>
                <input name="myfile" id="middle-name" class="form-control" type="file">
                <input name="oldImg" id="middle-name" class="form-control" type="hidden" value="<?php echo $show['myfile']; ?>">
                <img src="<?php echo $show['myfile']; ?>" width="100px" >
                <h6 class="text-end"><?php echo $show['myfile']; ?></h6>
        </div>
                                            
        <div class="form-group col-md-6">
          <label for="event-description">Employee Notice<span class="text-danger" style="font-size: 1.2em;">*</span></label>
          <input type="text" class="form-control" name="emp_notice" value="<?php echo $show['emp_notice'];?>" >
        </div>

        <div class="form-group col-md-12 text-center"> <!-- Added text-center class here -->
          <button type="submit" class="btn btn-primary" name="submit">Update </button>
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


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
    const dateInput = document.getElementById('dateInput');
    const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

    // Set the min attribute to today's date
    dateInput.setAttribute('min', today);
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

<?php
if (isset($_POST['submit'])) {
    // Your existing code here...

    $fromdate = $_POST['date'];
    $subject = $_POST['subject'];

    $filename = $_FILES["myfile"];
    $filename = $_FILES["myfile"]["name"];
    $old_image = $_POST['oldImg'];

    // Maximum allowed file size (5 MB in bytes)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB

    if ($_FILES['myfile']['size'] > $maxFileSize) {
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'The uploaded file exceeds the maximum allowed size (5 MB).',
          });
        </script>";
    } else {
        if ($filename != '') {
            // Delete the old image from the folder
            if (file_exists($old_image)) {
                unlink($old_image);
            }

            $update_filename = $_FILES['myfile']['name'];
            $tempname = $_FILES["myfile"]["tmp_name"];
            $folder = "../files&img/" . $update_filename;
            move_uploaded_file($tempname, $folder);
        } else {
            // If no new image is uploaded, keep the old image
            $update_filename = $old_image;
            $folder = "" . $update_filename;
        }

        $notice = $_POST['emp_notice'];

        $sql = "UPDATE `emp_notice` SET `date`='$fromdate',`subject`='$subject',`myfile`='$folder',`emp_notice`='$notice' WHERE `id`='$id'";

        $data = mysqli_query($conn, $sql);

        if ($data) {
            echo "<script>
              Swal.fire({
                icon: 'success',
                title: 'Record Updated Successfully',
              }).then(() => {
                window.location.replace('emp_notice.php');
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
}
?>