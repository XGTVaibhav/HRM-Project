<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in
if (!$userprofile) {
    header('location:login_manager.php');
}

// Update the last activity time in the session
$_SESSION['last_activity'] = time();

// Check if the user has been inactive for more than 1 minute
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    // Destroy the session and redirect to the login page
    session_unset();
    session_destroy();
    header('location:login_manager.php');
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

    <title>Sourcecode-Manager Dashboard</title>
  <style>
     #multiSelectDropdown
    {
        font-size: 14px;
    }
    
    .dropdown-button {
    border: 1px solid #ced4da;
}

  </style>
</head>
<?php
include ("db.php");

$idd= $_GET['id'];

$query="SELECT * FROM add_team where id='$idd'";
$data=mysqli_query($conn,$query);

$result=mysqli_fetch_assoc($data);
$total=mysqli_num_rows($data);
?>
<body>

<?php
    include "include/header_mg.php";
?>


<main class="mt-5 pt-3">
 <h2><b>Update Project</b></h2>
  
    <div class="container ">
        <div class="rkform ">
            <form class="row g-3 ms-2 me-2" method="POST">
           
                
                <div class="col-md-8">
                  <label for="inputEmail4" class="form-label">Team Name</label>
                  <input type="text" class="form-control" id="inputEmail4" name="teamname" value="<?php echo $result['teamname']; ?>" readonly>
                </div>

                <div class="col-md-12">
                <div class="dropdown col-md-12">
                    <label for="inputState" class="form-label">Team Members</label>
                    <button class="btn dropdown-toggle dropdown-button" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $result['members']; ?>
                    </button>


                    <ul class="dropdown-menu" aria-labelledby="multiSelectDropdown">
                        <li>
                            <label>
                                <?php
                                $i = 1;
                                $query_show = mysqli_query($conn, "SELECT * FROM add_employe ORDER BY emp_name ASC");
                                while ($show = mysqli_fetch_array($query_show)) {
                                    ?>
                                    <input type="checkbox" name="members[]" value="<?php echo $show['emp_id'] . '-' . $show['emp_name']; ?>" <?php if (in_array($show['emp_name'], explode(', ', $result['members']))) echo 'checked'; ?>>
                                    <?php echo $show['emp_id']; ?> (<?php echo $show['emp_name']; ?>)<br><br>
                                    <?php
                                    $i++;
                                } ?>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
                
                <div class="col-12 mb-3">
                 <center> <button type="submit" class="btn btn-primary" name="Update">Update</button></center>
                </div>
              </form>
        </div>
    </div>
  </main>




<?php 
if (isset($_POST['Update'])) {
 
    $p_name=$_POST['teamname'];
  
   
    $members = !empty($_POST['members']) ? implode(", ", $_POST['members']) : '';

   
  

   $query="UPDATE `add_team` SET teamname='$p_name',members='$members' where id='$idd' ";
   $data=mysqli_query($conn,$query);

   if ($data) {
   // echo "Data Inserted";
   echo 

   "<script type='text/javascript'>
   Swal.fire({
   title:'Update Details successfully',
   icon:'success',
   showConfirmButton: false,
   timer:2000
   }).then(function() {
   window.location.replace('add_team.php');
   });
   </script>";
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