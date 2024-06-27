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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
  <link rel="stylesheet" href="style_admin.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <link rel="stylesheet" href="stylezzz.css">

    <title>Sourcecode-User Dashboard</title>
<style>

.container {
            padding-left: 10%;
            padding-top: 3%;
            padding-right: 3%;
            margin-left: 13%;
            margin-top: 3%;
            margin-right: 3%;
        }
  .error {
    color: red;
}

   /* Decrease the font size of placeholders */
   ::placeholder {
        font-size: 14px; /* Adjust the font size as needed */
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

  <!-- navigation & offcanvas starts -->

  <?php
    include "include/header_us.php";
    ?>

  <!-- navigation & offcanvas ends -->

 

  <main class="">
    <div class="container">
        <h2><b>Change Password</b></h2>
        <hr>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="emp_id">Employee ID:</label>
                    <input type="text" class="form-control" id="emp_id" placeholder="Enter employee ID" name="emp_id" value="<?php echo $show['emp_id']; ?>" readonly>
                    <div class="error" id="emp_id_error"></div>
                </div>

                <div class="form-group col-md-6">
                    <label for="emp_name">Employee name:</label>
                    <input type="text" class="form-control" id="emp_name" placeholder="Enter employee Name" name="emp_name" value="<?php echo $show['emp_name']; ?>" readonly>
                    <div class="error" id="emp_name_error"></div>
                </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="password">Current Password <span class="text-danger" style="font-size: 1.2em;">*</span></label>
                  <div class="input-group">
                      <input type="password" class="form-control" name="emp_password" id="password" placeholder="Enter your current password" value="<?php echo $show['emp_password']; ?>" required>
                      <div class="input-group-append">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input mr-3" id="showPassword">
                        <label class="form-check-label" for="showPassword">
                            <i class="fas fa-eye"></i> 
                        </label>
                    </div>


                      </div>
                  </div>
                  <div class="error" id="password_error"></div>
              </div>
          </div>


            <div class="form-row mb-3">
                <div class="form-group col-md-6">
                    <label>New Password <span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="password" class="form-control" name="n_password" id="n_password" placeholder="Enter New Password" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Confirm Password <span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="password" class="form-control" id="c_password" placeholder="Confirm your New Password" name="c_password" required>
                </div>
            </div>

            <div class="form-group col-md-6 offset-md-3 text-center">
                <button type="submit" name="register" class="btn btn-primary">Save Change</button>
            </div>
        </form>
    </div>
</main>
<div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>

       
  <!-- /top tiles -->


  <!-- end of weather widget -->
  </div>
  </div>
  </div>
  </div>
  <!-- /page content -->

 
  </div>
  </div>
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- gauge.js -->
  <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="../vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="../vendors/Flot/jquery.flot.js"></script>
  <script src="../vendors/Flot/jquery.flot.pie.js"></script>
  <script src="../vendors/Flot/jquery.flot.time.js"></script>
  <script src="../vendors/Flot/jquery.flot.stack.js"></script>
  <script src="../vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="../vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../vendors/moment/min/moment.min.js"></script>
  <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>
  <script>
		document.addEventListener("DOMContentLoaded", function () {
			const passwordInput = document.getElementById("password");
			const showPasswordCheckbox = document.getElementById("showPassword");

			showPasswordCheckbox.addEventListener("change", function () {
				if (showPasswordCheckbox.checked) {
					passwordInput.type = "text";
				} else {
					passwordInput.type = "password";
				}
			});
		});
	</script>
   <?php
    if (isset($_POST['register'])) {
        $cpassword = $_POST['c_password'];
        $npassword = $_POST['n_password'];
       $id = $_SESSION['$user_name'];

    if( $cpassword==$npassword)
            { $query = "update `add_employe` set `emp_password`='$cpassword' where emp_id='$id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "
        <script type='text/javascript'>
            Swal.fire({
                title: '',
                text: 'Password Updated Successfully!!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.back();
            });
        </script>";
          
            } else {
               // die("Data not inserted:" . mysqli_connect_error($conn));
            }
        }
        else {
          echo "
          <script type='text/javascript'>
              Swal.fire({
                  title: 'oooops',
                  text: 'Password doesnt match.!!',
                  icon: 'error',
                
              });
          </script>";
        }
      }
    ?>

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