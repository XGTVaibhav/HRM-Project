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

  <title>SourceCode Admin Dashboard</title>

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
    $query = "SELECT * FROM emp_docs WHERE id = '$id'";
    $query_show = mysqli_query($conn, $query);
    $show = mysqli_fetch_assoc($query_show);
    
    ?>
  <?php
    include "include/header_ad.php";
    ?>



 
 <main class="mt-5 pt-3"> 
  <div class="container">

    <h2><b>Update Employee Document's</b></h2>
    <hr>

    <form action="#" method="POST" enctype="multipart/form-data" id="noticeForm" novalidate>
      <div class="form-row">
        <div class="form-group col-md-6">
        <label>Employee ID:</label>
        <input type="text" class="form-control" id="firstName" placeholder="Employee id" id="event-date" name="emp_id" value="<?php echo $show['emp_id'];?>" readonly>
        </div>

        <div class="form-group col-md-6">
        <label>Employee Name:</label>
        <input type="text" id="event-description"  class="form-control" id="firstName" placeholder="Employee name" rows="4" name="emp_name" value="<?php echo $show['emp_name'];?>" readonly>
        </div>

        <div class="form-group col-md-6">
        <label for="event-description">Upload Your Adhar Card Image<span class="text-danger" style="font-size: 1.2em;">*</span></label>
        <input type="file" class="form-control-file" name="myfile" required>
                <div class="error" id="adhar_error"></div>
                <input name="oldImg" id="middle-name" class="form-control" type="hidden" value="<?php echo $show['myfile']; ?>">
                <img src="<?php echo $show['myfile']; ?>" width="100px" >
                 <h6 class="text-end"><?php echo $show['myfile']; ?></h6>
                 
        </div>

        <div class="form-group col-md-6">
        <label for="event-description">Upload Your Pan Card Image<span class="text-danger" style="font-size: 1.2em;">*</span></label>
        <input type="file" class="form-control-file" name="myfile1"required>
                <div class="error" id="pancard_error"></div>
                <input name="oldImg1" id="middle-name" class="form-control" type="hidden" value="<?php echo $show['myfile1']; ?>">
                <img src="<?php echo $show['myfile1']; ?>" width="100px" >
                 <h6 class="text-end"><?php echo $show['myfile1']; ?></h6>
        </div>
                
        <div class="form-group col-md-6">
        <label for="event-description">Upload Your Graduation Certificate Image</label>
        <input type="file" class="form-control-file" name="myfile2"  required>
                <div class="error" id="grad_cert_error"></div>
                <input name="oldImg2" id="middle-name" class="form-control" type="hidden" value="<?php echo $show['myfile2']; ?>">
                <img src="<?php echo $show['myfile2']; ?>" width="100px" >
                 <h6 class="text-end"><?php echo $show['myfile2']; ?></h6>
        </div>
                
        <div class="form-group col-md-6">
        <label for="event-description">Upload Your Graduation Marksheets Image</label>
        <input type="file" class="form-control-file" name="myfile3"  required>
                <div class="error" id="grad_marksheet_error"></div>
                <input name="oldImg3" id="middle-name" class="form-control" type="hidden" value="<?php echo $show['myfile3']; ?>">
                <img src="<?php echo $show['myfile3']; ?>" width="100px" >
                 <h6 class="text-end"><?php echo $show['myfile3']; ?></h6>
        </div>
                                                   
        

        <div class="form-group col-md-12 text-center"> <!-- Added text-center class here -->
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


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
    document.getElementById("noticeForm").addEventListener("submit", function (event) {
        const adhar = document.getElementsByName("myfile")[0];
        const pan = document.getElementsByName("myfile1")[0];
        const gradCert = document.getElementsByName("myfile2")[0];
        const gradMarksheet = document.getElementsByName("myfile3")[0];

        if (adhar.files.length > 0 && adhar.files[0].size > 5 * 1024 * 1024) {
            displayError("adhar_error", "Adhar Card file size must be less than 5MB.");
            event.preventDefault();
        } else {
            clearError("adhar_error");
        }

        if (pan.files.length > 0 && pan.files[0].size > 5 * 1024 * 1024) {
            displayError("pancard_error", "Pan Card file size must be less than 5MB.");
            event.preventDefault();
        } else {
            clearError("pancard_error");
        }

        if (gradCert.files.length > 0 && gradCert.files[0].size > 5 * 1024 * 1024) {
            displayError("grad_cert_error", "Graduation Certificate file size must be less than 5MB.");
            event.preventDefault();
        } else {
            clearError("grad_cert_error");
        }

        if (gradMarksheet.files.length > 0 && gradMarksheet.files[0].size > 5 * 1024 * 1024) {
            displayError("grad_marksheet_error", "Graduation Marksheet file size must be less than 5MB.");
            event.preventDefault();
        } else {
            clearError("grad_marksheet_error");
        }
    });

    // Other functions (displayError, clearError) as in your original code.
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
  $emp_id = $_POST['emp_id'];
  $emp_name = $_POST['emp_name'];

  // Function to delete old image file
  function deleteOldImage($oldImage) {
    if (!empty($oldImage) && file_exists($oldImage)) {
      unlink($oldImage);
    }
  }

  // Update Adhar Card Image
  $adhar_filename = $_FILES["myfile"]["name"];
  $old_adhar_image = $_POST['oldImg'];
  if ($adhar_filename != '') {
    deleteOldImage($old_adhar_image);
    $adhar_tempname = $_FILES["myfile"]["tmp_name"];
    $adhar_folder = "../files&img/" . $adhar_filename;
    move_uploaded_file($adhar_tempname, $adhar_folder);
  } else {
    $adhar_folder = $old_adhar_image;
  }

  // Update Pan Card Image
  $pan_filename = $_FILES["myfile1"]["name"];
  $old_pan_image = $_POST['oldImg1'];
  if ($pan_filename != '') {
    deleteOldImage($old_pan_image);
    $pan_tempname = $_FILES["myfile1"]["tmp_name"];
    $pan_folder = "../files&img/" . $pan_filename;
    move_uploaded_file($pan_tempname, $pan_folder);
  } else {
    $pan_folder = $old_pan_image;
  }

  // Update Graduation Certificate Image
  $grad_cert_filename = $_FILES["myfile2"]["name"];
  $old_grad_cert_image = $_POST['oldImg2'];
  if ($grad_cert_filename != '') {
    deleteOldImage($old_grad_cert_image);
    $grad_cert_tempname = $_FILES["myfile2"]["tmp_name"];
    $grad_cert_folder = "../files&img/" . $grad_cert_filename;
    move_uploaded_file($grad_cert_tempname, $grad_cert_folder);
  } else {
    $grad_cert_folder = $old_grad_cert_image;
  }

  // Update Graduation Marksheet Image
  $grad_marksheet_filename = $_FILES["myfile3"]["name"];
  $old_grad_marksheet_image = $_POST['oldImg3'];
  if ($grad_marksheet_filename != '') {
    deleteOldImage($old_grad_marksheet_image);
    $grad_marksheet_tempname = $_FILES["myfile3"]["tmp_name"];
    $grad_marksheet_folder = "../files&img/" . $grad_marksheet_filename;
    move_uploaded_file($grad_marksheet_tempname, $grad_marksheet_folder);
  } else {
    $grad_marksheet_folder = $old_grad_marksheet_image;
  }

  // Update the database record
  $sql = "UPDATE `emp_docs` SET `emp_id`='$emp_id',`emp_name`='$emp_name',`myfile`='$adhar_folder',`myfile1`='$pan_folder',`myfile2`='$grad_cert_folder',`myfile3`='$grad_marksheet_folder' WHERE `id`='$id'";
  $data = mysqli_query($conn, $sql);

  if ($data) {
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Record Updated Successfully',
      }).then(() => {
        window.location.replace('emp_docs.php');
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
?>