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
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>  
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylezzz.css">  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
<body>
    
    <?php
    include 'db.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM emp_rating WHERE id = '$id'";
    $query_show = mysqli_query($conn, $query);
    $show = mysqli_fetch_assoc($query_show);
    
    ?>

    <?php
    include "include/header_ad.php";
    ?>

<main class="mt-5 pt-3">
    <div class="container ">
    <h2><b>Employee Performance Form-Update</b></h2><hr>
        <form action="#" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Employee ID</label>
                        <input type="text" name="emp_id" class="form-control"  value="<?php echo $show['emp_id'];?>" readonly><br>
                        <div class="error" id="employee_idError"></div>
                     </div>

                     <div class="form-group col-md-6">
                        <label>Employee Name</label>
                        <input type="text" name="emp_name"  class="form-control" value="<?php echo $show['emp_name'];?>" ,`myfile2`='$folder2' readonly><br>
                        <div class="error" id="employee_idError"></div>
                    </div>

                   <div class="form-group col-md-6">
                        <label>Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <input type="date" name="date"  class="form-control" value="<?php echo $show['date'];?>" required><br>
                        <div class="error" id="dateError"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Department<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <select name="dept" class="form-control" value="<?php echo $show['dept'];?>" required>
                            <option>Choose...</option>
                            <option value="Software Engineer" <?php echo ($show['dept']=='Software Engineer') ? 'selected' :'';?>>Software Engineer</option>
                            <option value="Software Developer"  <?php echo ($show['dept']=='Software Developer') ? 'selected' :'';?>>Software Developer</option>
                            <option value="HR Department" <?php echo ($show['dept']=='HR Department') ? 'selected' :'';?>>HR Department</option>
                            <option value="Project Manager" <?php echo ($show['dept']=='Project Manager') ? 'selected' :'';?>>Project Manager</option>
                        </select><br>
                        <div class="error" id="deptError"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Shift<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <select name="shift"  class="form-control" value="<?php echo $show['shift'];?>"  required >
                        <option>Choose...</option>
                            <option value="General Shift" <?php echo ($show['shift']=='General Shift') ? 'selected' :'';?>>General Shift</option>
                            <option value="Day Shift" <?php echo ($show['shift']=='Day Shift') ? 'selected' :'';?>>Day Shift</option>
                            <option value="Night Shift" <?php echo ($show['shift']=='Night Shift') ? 'selected' :'';?>>Night Shift</option>
                        </select><br>
                        <div class="error" id="shiftError"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Rating<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <select name="emp_status"  class="form-control" value="<?php echo $show['emp_status'];?>" required>
                            <option>Choose...</option>
                            <option value="0" <?php echo ($show['emp_status']=='0') ? 'selected' :'';?>>0</option>
                            <option value="1" <?php echo ($show['emp_status']=='1') ? 'selected' :'';?>>1</option>
                            <option value="2" <?php echo ($show['emp_status']=='2') ? 'selected' :'';?>>2</option>
                            <option value="3" <?php echo ($show['emp_status']=='3') ? 'selected' :'';?>>3</option>
                            <option value="4" <?php echo ($show['emp_status']=='4') ? 'selected' :'';?>>4</option>
                            <option value="5" <?php echo ($show['emp_status']=='5') ? 'selected' :'';?>>5</option>
                            <option value="6" <?php echo ($show['emp_status']=='6') ? 'selected' :'';?>>6</option>
                            <option value="7" <?php echo ($show['emp_status']=='7') ? 'selected' :'';?>>7</option>
                            <option value="8" <?php echo ($show['emp_status']=='8') ? 'selected' :'';?>>8</option>
                            <option value="9" <?php echo ($show['emp_status']=='9') ? 'selected' :'';?>>9</option>
                            <option value="10" <?php echo ($show['emp_status']=='10') ? 'selected' :'';?>>10</option>
                        </select><br>
                        <div class="error" id="statusError"></div>
                    </div>

            <div class="form-group col-md-12 text-center"> <!-- Added text-center class here -->
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
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
    const performanceReportForm = document.getElementById('performanceReportForm');
    const employee_id = document.getElementsByName('employee_id')[0];
    const date = document.getElementsByName('date')[0];
    const dept = document.getElementsByName('dept')[0];
    const shift = document.getElementsByName('shift')[0];
    const status = document.getElementsByName('status')[0];

    performanceReportForm.addEventListener('submit', function (e) {
        if (!validateForm()) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function validateForm() {
        let valid = true;

        // Reset error messages
        setError('employee_idError', '');
        setError('dateError', '');
        setError('deptError', '');
        setError('shiftError', '');
        setError('statusError', '');

        if (employee_id.value === '') {
            setError('employee_idError', 'Employee ID must be filled out');
            valid = false;
        }
        if (date.value === '') {
            setError('dateError', 'Month/Year must be filled out');
            valid = false;
        }
        if (dept.value === '') {
            setError('deptError', 'Department must be selected');
            valid = false;
        }
        if (shift.value === '') {
            setError('shiftError', 'Shift must be selected');
            valid = false;
        }
        if (status.value === '') {
            setError('statusError', 'Status must be selected');
            valid = false;
        }

        return valid;
    }

    function setError(id, message) {
        const errorElement = document.getElementById(id);
        errorElement.innerText = message;
    }
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
    $employee_id = $_POST['emp_id'];
    $name = $_POST['emp_name'];
    $date = $_POST['date'];
    $dept = $_POST['dept'];
    $shift = $_POST['shift'];
    $status = $_POST['emp_status'];
 
$sql= "UPDATE `emp_rating` SET `emp_id`='$employee_id',`emp_name`='$name',`date`='$date', `dept`='$dept',`shift`='$shift',`emp_status`='$status' WHERE `id`='$id'";

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
                    window.location.href = 'emp_performance.php';
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