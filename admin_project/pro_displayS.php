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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="stylezzz.css">
    <title>Sourcecode-Admin Dashboard</title>

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
<?php
include ("db.php");

$idd= $_GET['id'];

$query="SELECT * FROM new_project where id='$idd'";
$data=mysqli_query($conn,$query);

$result=mysqli_fetch_assoc($data);
$total=mysqli_num_rows($data);
?>
<body>



  <?php
    include "include/header_ad.php";
  ?>

<main class="mt-5 pt-3">
  <h2><b>Project Details</b></h2>
  <hr>
   
    <div class="container ">
        <div class="rkform ">
            <form class="row g-3 ms-2 me-2" method="POST">
            <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Employee ID</label>
                  <input type="text" class="form-control" id="inputEmail4" name="emp_id" value="<?php echo $result['emp_id']; ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Employee Name</label>
                  <input type="text" class="form-control" id="inputEmail4" name="emp_name" value="<?php echo $result['emp_name']; ?>" readonly>
                </div>

                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Project Name</label>
                  <input type="text" class="form-control" id="inputEmail4" name="project_name" value="<?php echo $result['project_name']; ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress" class="form-label">Project Description</label>
                    <input type="text" class="form-control" id="inputAddress" name="description" value="<?php echo $result['description']; ?>" readonly>
                  </div>
                 
                
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="inputPassword4" name="start_date" value="<?php echo $result['start_date']; ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="inputPassword4" name="end_date" value="<?php echo $result['end_date']; ?>" readonly>
                  </div>
    
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Project Manager</label>
                    <input type="text" class="form-control" id="inputEmail4" name="project_manager" value="<?php echo $result['project_manager']; ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Team Member</label>
                    <input type="text" class="form-control" id="inputEmail4" name="project_team1" value="<?php echo $result['members']; ?>" readonly>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Team Size</label>
                    <input type="number" class="form-control" id="inputEmail4" name="team_size" value="<?php echo $result['team_size']; ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="inputState" class="form-label">Status</label>
                   
                    <select id="inputState" class="form-select" name="status" value="<?php echo $result['status']; ?>" readonly>
                        <option value="">Choice</option>
                      <option value="Done" 
                    <?php
                    if($result['status'] == 'Done')
                    {
                      echo  "selected";
                    }
                    ?>>Done</option>
                    <option  value="Pending"
                    <?php
                    if($result['status'] == 'Pending')
                    {
                      echo  "selected";
                    }
                    ?>> Pending</option>
                    </select>
                  </div>
                
                <div class="col-12 mb-3">
                  <!-- <button type="" class="btn "  href="pro_display.php"></button> -->
                 <center> <a class='btn btn-primary' name="back" href='pro_display.php'>Back</a></center>
                </div>
              </form>
        </div>
    </div>
  </main>

            <div>
                <footer class="text-black text-center py-2" style="margin-right:22%;">
            
                <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
                </footer>
            </div>

<?php 
if (isset($_POST['back'])) {
  $e_id=$_POST['emp_id'];
  $e_name=$_POST['employee_name'];
    $p_name=$_POST['project_name'];
    $d_name=$_POST['description'];
    $s_date=$_POST['start_date'];
    $e_date=$_POST['end_date'];
    $p_man=$_POST['project_manager'];
    $p_team1=$_POST['project_team1'];
    $p_team2=$_POST['project_team2'];
    $p_team3=$_POST['project_team3'];
    $p_team4=$_POST['project_team4'];
    $p_team5=$_POST['project_team5'];
    $t_size=$_POST['team_size'];
    $status=$_POST['status'];



   $query="UPDATE `new_project` SET emp_id='$e_id',employee_name='$e_name', project_name='$p_name',description='$d_name',start_date='$s_date',end_date='$e_date',project_manager='$p_man',project_team1=' $p_team1',project_team2=' $p_team2',project_team3=' $p_team3',project_team4=' $p_team4',project_team5=' $p_team5',team_size='$t_size',`status`='$status'where sr_no='$idd' ";
   $data=mysqli_query($conn,$query);

   if ($data) {

   }
   else{
    echo "data Not Updated";
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
  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
</body>
</html>