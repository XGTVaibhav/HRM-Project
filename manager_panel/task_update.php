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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sourcecode-Manager Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Remove duplicate links below -->
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

 <?php
    include "include/header_mg.php";
?>

<?php
include ("db.php");

$idd= $_GET['id'];

$query="SELECT * FROM new_task where id='$idd'";
$data=mysqli_query($conn,$query);

$result=mysqli_fetch_assoc($data);
$total=mysqli_num_rows($data);
?>
<body>

  <?php
    include "include/header_mg.php";
  ?>
            
<main class="mt-5 pt-3">
 
<h2><b>Update Ticket</b></h2><hr>

    <div class="container ">
        <div class="rkform ">
            <form class="row g-3 ms-2 me-2" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Employee ID</label>
                  <input type="text" class="form-control" id="inputEmail4" name="emp_id" value="<?php echo $result['emp_id']; ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Employee Name</label>
                  <input type="text" class="form-control" id="inputEmail4" name="emp_name" value="<?php echo $result['emp_name']; ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="project_name" class="form-label">Project Name</label>
                    <select class="form-control" id="project_name" name="project_name">
                    <option selected value="<?php echo $result['project_name'];?>"><?php echo $result['project_name'];?></option>
                        <?php
                        $i = 1;
                        $query_show = mysqli_query($conn, "SELECT * FROM new_project ORDER BY project_name ASC");
                        while ($show = mysqli_fetch_array($query_show)) {
                        ?>
                            <option value="<?php echo $show['project_name']; ?>"><?php echo $show['project_name']; ?></option>
                        <?php
                        $i++;
                        }
                        ?>
                    </select>
                    <div class="error" id="project_nameError"></div>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress" class="form-label">Project Description</label>
                    <input type="text" class="form-control" id="inputAddress" name="description" value="<?php echo $result['description']; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="inputAddress" class="form-label">Assign Ticket</label>
                    <input type="text" class="form-control" id="inputAddress" name="a_task" value="<?php echo $result['a_task']; ?>">
                  </div>

                  <div class="col-md-6">
              <label for="project_manager" style="padding-top: 5px;">Project Manager</label>
              <select class="form-control" id="project_manager" name="project_manager">
              <?php echo $result['project_manager']; ?>
                  <option value="">Select</option>
                  <?php
                  $query_show = mysqli_query($conn, "SELECT emp_id, emp_name, designation FROM add_employe WHERE designation = 'Manager' ORDER BY emp_name ASC");

                  while ($show = mysqli_fetch_array($query_show)) {
                      $selected = ($show['emp_id'] == $result['project_manager']) ? 'selected' : '';
                      ?>
                      <option value="<?php echo $show['emp_id']; ?>" <?php echo $selected; ?>>
                          <?php echo $show['emp_name']; ?> (ID: <?php echo $show['emp_id']; ?>)
                      </option>
                  <?php
                  }
                  ?>
              </select>
              <div class="error" id="project_managerError"></div>
          </div>
                  <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"value="<?php echo $result['start_date']; ?>">
                    <div class="error" id="start_dateError"></div>
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $result['end_date']; ?>">
                    <div class="error" id="end_dateError"></div>
                </div>

    
                  
                  <div class="col-md-6">
                  <label for="inputupload">Upload</label>
             
            
              <input name="upload" id="middle-name" class="form-control" width="100%" type="file">
                                                <input name="oldImg" id="middle-name" class="form-control" type="hidden" value="<?php echo $result['upload']; ?>">
                                                <img src="<?php echo $result['upload']; ?>" width="100px" >
                                                <h6 class="text-end"><?php echo $result['upload']; ?></h6>
            
            
            
            </div>
                  <div class="col-md-6">
                    <label for="inputState" class="form-label">Status</label>
                    <select id="inputState" class="form-select" name="status" value="<?php echo $result['status']; ?>">
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
                  <center><button type="submit" class="btn btn-primary" name="update">Update</button></center>
                </div>
              </form>
        </div>
    </div>
    </main>

    <?php 
if (isset($_POST['update'])) {
  $e_id=$_POST['emp_id'];
  $e_name=$_POST['emp_name'];
    $p_name=$_POST['project_name'];
    $d_name=$_POST['description'];
    $a_task=$_POST['a_task'];
    $p_manager=$_POST['project_manager'];
    $s_date=$_POST['start_date'];
    $e_date=$_POST['end_date'];
   

    $file=$_FILES['upload']['name'];
    $tempname = $_FILES['upload']['tmp_name'];
     $folder = "../files&img/".$file;
    move_uploaded_file($tempname, $folder);
    echo"<img src='$file'height='100px' width='100px'>";



    $status=$_POST['status'];

    $query="UPDATE `new_task` SET emp_id='$e_id',emp_name='$e_name',project_name='$p_name',description='$d_name', a_task='$a_task',project_manager='$p_manager',start_date='$s_date',end_date='$e_date',upload='$folder',`status`='$status'where id='$idd' ";
   $data=mysqli_query($conn,$query);

   if ($data) {
   //echo "Data Inserted";
   echo 

   "<script type='text/javascript'>
   Swal.fire({
   title:'Update Details successfully',
   icon:'success',
   showConfirmButton: false,
   timer:2000
   }).then(function() {
   window.location.replace('task_display.php');
   });
   </script>";
   }
   else{
    echo "data Not Updated";
   }

}

?>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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