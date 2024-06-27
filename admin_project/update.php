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
<?Php
include("db.php")
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
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="stylezzz.css">

  <title>SourceCode Admin Dashboard</title>
</head>

<?php
    include 'db.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM `add_employe` WHERE id = '$id'";
    $query_show = mysqli_query($conn, $query);
    $show = mysqli_fetch_assoc($query_show); 
    ?>
<body>

  <?php
  include "include/header_ad.php";
  ?>

<main class="mt-5 pt-3">
  <div class="container ">
        <h2 ><b> Update Employee Profile</b></h2><br><hr>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">Employe Name</label>
                    <input type="text" class="form-control" id="firstName" name="emp_name" placeholder="Employe Name" value="<?php echo $show ['emp_name'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">Employe ID</label>
                    <input type="text" class="form-control" id="lastName" name="emp_id" placeholder="Employe ID" value="<?php echo $show ['emp_id'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">Email<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="email" class="form-control" id="firstName" name="email" placeholder="Employe Email" value="<?php echo $show ['email'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">Date Of Birth<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" id="lastName" name="emp_dob" placeholder="Last Name" value="<?php echo $show ['emp_dob'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">password<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="firstName" name="emp_password" placeholder="Employe Name" value="<?php echo $show ['emp_password'] ?>">
                </div>
                <div class="form-group col-md-6">
                <label>Designation<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select class="form-control" id="position" name="designation" >
                    <option value="">Select Position</option>
                    
                    <option  value="Front-End Developer"
                    
                    <?php
                    if($show['designation'] == 'Front-End Developer')
                    {
                      echo  "selected";
                    }
                    ?>>Front-end Developer</option>
                    <option  value="Back-End Developer"
                    
                    <?php
                    if($show['designation'] == 'Back-End Developer')
                    {
                      echo  "selected";
                    }
                    ?>>Back-End Developer</option>
                    <option  value="Softwere Developer"
                    
                    <?php
                    if($show['designation'] == 'Softwere Developer')
                    {
                      echo  "selected";
                    }
                    ?>>Softwere Developer</option>
                    <option  value="Manager"
                    
                    <?php
                    if($show['designation'] == 'Manager')
                    {
                      echo  "selected";
                    }
                    ?>>Manager</option>
                    <option  value="HR"
                    <?php
                    if($show['designation'] == 'HR')
                    {
                      echo  "selected";
                    }
                    ?>>HR</option>
                    
                   

                </select>
                    
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="position">Gender<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select class="form-control" id="position" name="gender" >
                    <option value="">Select Gender</option>
                    <option value="Male" 
                    <?php
                    if($show['gender'] == 'Male')
                    {
                      echo  "selected";
                    }
                    ?>>Male</option>
                    <option  value="Female"
                    <?php
                    if($show['gender'] == 'Female')
                    {
                      echo  "selected";
                    }
                    ?>> Female</option>
                    
                    <option value="Other"
                    <?php
                    if($show['gender'] == 'Other')
                    {
                      echo  "selected";
                    }
                    ?>>Other</option>

                </select>
                </div>
                <div class="form-group col-md-6">
                <label for="position">Marital Status<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select class="form-control" id="status" name="married_status" >
                <option value="">Select Status</option>
                    <option value="Single"
                    <?php
                    if($show['married_status'] == 'Single')
                    {
                      echo  "selected";
                    }
                    ?>>Single</option>
                    <option value="Married"
                    <?php
                    if($show['married_status'] == 'Married')
                    {
                      echo  "selected";
                    }
                    ?>>Married</option>
                 
                    <option value="Other"
                    <?php
                    if($show['married_status'] == 'Other')
                    {
                      echo  "selected";
                    }
                    ?>>Other</option>

                </select>
                    
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">Phone No<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="tel" class="form-control"  placeholder="Phone Number"name="emp_mob1" id="mobileNumber1" value="<?php echo $show ['emp_mob1'] ?>" pattern="\d{10}" maxlength="10" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">Phone Number<span class="text-danger" style="font-size: 1.2em;"></span></label>
                    <input type="tel" class="form-control"  name="emp_mob2" placeholder="Phone Number" id="mobileNumber2"  value="<?php echo $show ['emp_mob2'] ?>" pattern="\d{10}" maxlength="10">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">Current Address<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="firstName" name="emp_add" placeholder="Employe Current Address" value="<?php echo $show ['emp_add'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">Permanent Address<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="lastName" name="emp_padd" placeholder="Employe Permanent Address" value="<?php echo $show ['emp_padd'] ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo <span class="required">*</span> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input name="uploadfile" id="middle-name" class="form-control col-md-7 col-xs-12" width="100%" type="file">
                        <input name="oldImg" id="middle-name" class="form-control col-md-7 col-xs-12" type="hidden" value="<?php echo $show['uploadfile']; ?>">
                        <img src="<?php echo $show['uploadfile']; ?>" width="100px" >
                        <h6 class="text-end"><?php echo $show['uploadfile']; ?></h6>
                      </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="lastName">Comment</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment" value="<?php echo $show ['comment'] ?>" required><?php echo $show ['comment'] ?></textarea>
                </div>
            </div>
           
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">Account No<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="number" class="form-control" id="firstName" name="ac_num" placeholder="Account No" value="<?php echo $show ['ac_num'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">Bank Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="lastName" name="bank_name" placeholder="Bank Name" value="<?php echo $show ['bank_name'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">Branch Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="firstName" name="branch_name" placeholder="Branch Name" value="<?php echo $show ['branch_name'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">IFSC Code<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="lastName" name="bank_code" placeholder="IFSC Code" value="<?php echo $show ['bank_code'] ?>">
                </div>
            </div>
            <center><button type="submit" class="btn btn-primary" name="submit">Update</button></center>
        </form>
    </div>
</main>

            <div>
                <footer class="text-black text-center py-2" style="margin-right:22%;">
            
                <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
                </footer>
            </div>


  <?php
// error_reporting(0);
  if (isset($_POST['submit'])) {
    $ename = $_POST['emp_name'];
    $email = $_POST['email'];
    $dob = $_POST['emp_dob'];
    $designation = $_POST['designation'];
    $eid = $_POST['emp_id'];
    $pass = $_POST['emp_password'];
    $gender = $_POST['gender'];
    $mob1 = $_POST['emp_mob1'];
    $mob2 = $_POST['emp_mob2'];
    $add = $_POST['emp_add'];
    $padd = $_POST['emp_padd'];
    $status = $_POST['married_status'];
    $filename = $_FILES["uploadfile"];
    $filename = $_FILES["uploadfile"]["name"];
    $old_image=$_POST['oldImg'];
    // Maximum allowed file size (5 MB in bytes)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB

    if ($_FILES['uploadfile']['size'] > $maxFileSize) {
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

            $update_filename = $_FILES['uploadfile']['name'];
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $folder = "../image/" . $update_filename;
            move_uploaded_file($tempname, $folder);
        } else {
            // If no new image is uploaded, keep the old image
            $update_filename = $old_image;
            $folder = "" . $update_filename;
        }
      }
    $comment = $_POST['comment'];
    $ac_num = $_POST['ac_num'];
    $bank_name = $_POST['bank_name'];
    $branch_name = $_POST['branch_name'];
    $bank_code = $_POST['bank_code'];
    $sql= "UPDATE `add_employe` SET `emp_name`='$ename',`email`='$email',`emp_dob`='$dob',`designation`='$designation',`emp_id`='$eid',`emp_password`='$pass',`gender`='$gender',`emp_mob1`='$mob1',`emp_mob2`='$mob2',`emp_add`='$add',`emp_padd`='$padd',`married_status`='$status',`uploadfile`='$folder',`comment`='$comment', `ac_num`='$ac_num',`bank_name`='$bank_name',`branch_name`='$branch_name',`bank_code`='$bank_code' WHERE id=$id ";
    $data = mysqli_query($conn, $sql);

    ?>

    <meta http-equiv = "refresh" content = "2; url=display.php">
      
<?php
  
  if ($data) {
    // echo "Data Inserted";
    echo 
 
    "<script type='text/javascript'>
    Swal.fire({
    title:'Data Update successfully',
    icon:'success',
    showConfirmButton: false,
    timer:2000
    }).then(function() {
    window.location.replace('display.php');
    });
    </script>";
    }
    else{
     echo "data Not Updated";
    }
 
 }
?>


<!-- validation mobile no -->
<script>
        function validateMobileNumber(input) {
            // Remove non-numeric characters
            input.value = input.value.replace(/\D/g, '');

            // Limit the length to 10 digits
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }

        function submitForm() {
            var mobileNumber1 = document.getElementById('mobileNumber1').value;
            var mobileNumber2 = document.getElementById('mobileNumber2').value;

            // Check if both mobile numbers are valid (exactly 10 digits)
            if (mobileNumber1.length === 10 && mobileNumber2.length === 10) {
                alert('Mobile numbers are valid:\nMobile Number 1: ' + mobileNumber1 + '\nMobile Number 2: ' + mobileNumber2);
                // You can submit the form or perform other actions here
            } else {
                alert('Please enter valid 10-digit mobile numbers for both fields');
            }
        }
    </script>
<!--  -->
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
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


     <!-- sweetalert -->
     <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>