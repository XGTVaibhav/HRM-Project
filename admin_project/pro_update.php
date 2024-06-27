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
 <h2><b>Update Project</b></h2>
  
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
                    <input type="text" class="form-control" id="inputAddress" name="description" value="<?php echo $result['description']; ?>">
                  </div>
                  <div class="col-md-6">
                  <label for="start_date" class="form-label">Start Date</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $result['start_date']; ?>">
                  <div class="error" id="start_dateError"></div>
              </div>

              <div class="col-md-6">
                  <label for="end_date" class="form-label">End Date</label>
                  <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $result['end_date']; ?>">
                  <div class="error" id="end_dateError"></div>
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
    <label for="inputState" class="form-label">Team Members</label>
    <button class="btn dropdown-toggle dropdown-button" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $result['members']; ?>
    </button>

    <ul class="dropdown-menu" aria-labelledby="multiSelectDropdown">
        <?php
        $i = 1;
        $query_show = mysqli_query($conn, "SELECT * FROM add_employe ORDER BY emp_name ASC");
        while ($show = mysqli_fetch_array($query_show)) {
            $concatenatedValue = $show['emp_id'] . '-' . $show['emp_name'];
            ?>
            <li>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="members[]" value="<?php echo $concatenatedValue; ?>" <?php if (!empty($result['members']) && in_array($concatenatedValue, explode(', ', $result['members']))) echo 'checked'; ?> onclick="updateSelectedTeamMembers()">
                    <label class="form-check-label">
                        <?php echo $show['emp_id'] . ' (' . $show['emp_name'] . ')'; ?>
                    </label>
                </div>
            </li>
            <?php
            $i++;
        } ?>
    </ul>
</div>



<div class="col-md-4">
    <label for="team_size" class="form-label">Team Size</label>
    <input type="number" class="form-control" id="team_size" name="team_size" value="<?php echo isset($result['team_size']) ? $result['team_size'] : ''; ?>" readonly>
</div>



                    <div class="col-md-4" style="padding-top:7px;">
                        <label for="team_size" class="">Create Meeting</label>
                        <input type="url" class="form-control custom-input" id="team_size" name="links" placeholder="Enter your meeting Url">
                        <!-- <div class="error" id="team_sizeError"></div> -->
                    </div>

                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Status</label>
                        <select id="inputState" class="form-select" name="status" value="<?php echo $result['status']; ?>">
                            <option value="">Choice</option>
                            <option value="Done" <?php echo ($result['status'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                            <option value="Pending" <?php echo ($result['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 mt-3">
                 <center> <button type="submit" class="btn btn-primary" name="Update">Update</button></center>
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
    if (isset($_POST['Update'])) {
      $e_id=$_POST['emp_id'];
      $e_name=$_POST['emp_name'];
        $p_name=$_POST['project_name'];
        $d_name=$_POST['description'];
        $s_date=$_POST['start_date'];
        $e_date=$_POST['end_date'];
         $p_man=$_POST['project_manager'];
      
        $members = !empty($_POST['members']) ? implode(", ", $_POST['members']) : '';

        $t_size=$_POST['team_size'];
        $links=$_POST['links'];
        $status=$_POST['status'];

      
      $query="UPDATE new_project SET emp_id='$e_id',emp_name='$e_name', project_name='$p_name',description='$d_name',start_date='$s_date',end_date='$e_date',project_manager='$p_man',members='$members', team_size='$t_size' ,links='$links',status='$status' where id='$idd' ";
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
      window.location.replace('pro_display.php');
      });
      </script>";
      }
      else{
        echo "data Not Updated";
      }

    }         
?>

<script>
function updateSelectedTeamMembers() {
    var checkboxes = document.getElementsByName('members[]');
    var selectedCount = 0;

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            selectedCount++;
        }
    });

    document.getElementById('team_size').value = selectedCount;
}
</script>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
</body>

</html>