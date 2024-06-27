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



include 'db.php';

$id = $_GET['id'];

if ($id) {
    $query = "SELECT * FROM `leaveform` WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $existingData = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
}

if (isset($_POST['update'])) {
    $empid = $_POST['emp_id'];
    $empname = $_POST['emp_name'];
    $leavetype = $_POST['leavetype'];
    $frmdate = $_POST['frmdate'];
    $todate = $_POST['todate'];
    $reason = $_POST['reason'];
    $comment = $_POST['comment'];
    $status = isset($_POST['status']) ? $_POST['status'] : ''; // Check if 'status' is set

    $query = "UPDATE `leaveform` SET `emp_id`=?, `emp_name`=?, `leavetype`=?, `frmdate`=?, `todate`=?, `reason`=?, `comment`=?, `status`=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssssi", $empid, $empname, $leavetype, $frmdate, $todate, $reason, $comment, $status, $id);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        // Echo a response message to be used by JavaScript
        $response = array(
            'status' => 'success',
            'message' => 'Data Updated Successfully'
        );
    } else {
        // Echo a response message to be used by JavaScript
        $response = array(
            'status' => 'error',
            'message' => 'Update Failed'
        );
    }

    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap CSS CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!-- Bootstrap JS CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- Google Fonts CDN Link -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    
    <title>Sourcecode-Admin Dashboard</title>
  <style>
    
        .error 
        {
            color: red;
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
    <!-- HEADER.PHP -->
    <?php 
    include "include/header_ad.php"; 
    ?>
<main class="mt-5 pt-3">
<div class="container ">
    <h2><b>Employee Leave Form-Update</b></h2>
    <form method="POST" action="#">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="employeeid" class="mb-2">Employee-Id</label>
                    <input type="text" class="form-control" id="employeeid" name="emp_id" placeholder="Employee Id" value="<?php echo isset($existingData['emp_id']) ? $existingData['emp_id'] : ''; ?>" readonly required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="employeename" class="mb-2">Employee-Name</label>
                    <input type="text" class="form-control" id="employeename" name="emp_name" placeholder="Employee Name" value="<?php echo isset($existingData['emp_name']) ? $existingData['emp_name'] : ''; ?>" readonly required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="leavetype" class="mb-2">Leave-Type<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <select class="form-control" id="leavetypeWide" name="leavetype" required>
                        <option value="" <?php echo (isset($existingData['leavetype']) && $existingData['leavetype'] == '') ? 'selected' : ''; ?>>Select</option>
                        <option value="Sick Leave" <?php echo (isset($existingData['leavetype']) && $existingData['leavetype'] == 'Sick Leave') ? 'selected' : ''; ?>>Sick Leave</option>
                        <option value="Casual Leave" <?php echo (isset($existingData['leavetype']) && $existingData['leavetype'] == 'Casual Leave') ? 'selected' : ''; ?>>Casual Leave</option>
                        <option value="Compensatory Off" <?php echo (isset($existingData['leavetype']) && $existingData['leavetype'] == 'Compensatory Off') ? 'selected' : ''; ?>>Compensatory Off</option>
                        <option value="Bereavement Leave" <?php echo (isset($existingData['leavetype']) && $existingData['leavetype'] == 'Bereavement Leave') ? 'selected' : ''; ?>>Bereavement Leave</option>
                        <option value="Paternity Leave" <?php echo (isset($existingData['leavetype']) && $existingData['leavetype'] == 'Paternity Leave') ? 'selected' : ''; ?>>Paternity Leave</option>
                    </select>
                </div>
            </div>
      
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date" class="mb-2">From Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" id="date" name="frmdate" placeholder="From Date" value="<?php echo isset($existingData['frmdate']) ? $existingData['frmdate'] : ''; ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="date" class="mb-2">To Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" id="date" placeholder="To Date" name="todate" value="<?php echo isset($existingData['todate']) ? $existingData['todate'] : ''; ?>" required>
                </div>
            </div>

            <div class="row mb-2">
            <div class="col-md-6">
                    <label for="reason" class="mb-2">Reason<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <textarea class="form-control" id="checkout" placeholder="Reason" name="reason" required><?php echo isset($existingData['reason']) ? $existingData['reason'] : ''; ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="comment" class="mb-2">Comment<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <textarea class="form-control" id="checkout" placeholder="Comment" name="comment" required><?php echo isset($existingData['comment']) ? $existingData['comment'] : ''; ?></textarea>
                </div>

            </div>
        </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" name="update" value="Update" class="btn btn-primary">
                <div class="ms-2"></div> 
                <a href="javascript:history.go(-1);" class="btn btn-secondary">Back</a>
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
        var currentDate = new Date();
        var previousDate = new Date();
        previousDate.setDate(currentDate.getDate() - 1);
        var nextDate = new Date();
        nextDate.setDate(currentDate.getDate() + 10);
        var previousDateString = previousDate.toISOString().slice(0, 10);
        var nextDateString = nextDate.toISOString().slice(0, 10);
        document.getElementById('date').min = previousDateString;
        document.getElementById('date').max = nextDateString;

        // Add a JavaScript function to handle the SweetAlert dialogs
        function handleSweetAlert(response) {
            Swal.fire({
                icon: response.status === 'success' ? 'success' : 'error',
                title: response.message,
            }).then((result) => {
                if (result.isConfirmed && response.status === 'success') {
                    window.location.href = 'add_leave.php';
                }
            });
        }
    </script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your additional script to handle SweetAlert -->
<script>
    // Check if you have a response to display SweetAlert for the update
    <?php
    if (isset($response)) {
        echo "handleSweetAlert(" . json_encode($response) . ");";
    }
    ?>
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