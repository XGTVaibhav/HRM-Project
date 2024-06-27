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
    <title>Sourcecode-Admin Dashboard</title>

    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>

</head>

<body>

<?php

include("db.php");

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (!empty($id)) {
    $query = "SELECT * FROM `attend_form` WHERE id='$id'";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    if (isset($_POST['update'])) {
        // Your code to process the form data
        $emp_id = $_POST['emp_id'];
        $emp_name = $_POST['emp_name'];
        $attendby = $_POST['attendby'];
        $shifttype = $_POST['shifttype'];
        $date = $_POST['date'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $status = $_POST['status'];

        $filename = $_FILES["uploadfile"]["name"];
        $old_image = $_POST['oldImg'];

        if ($_FILES["uploadfile"]["size"] > 5242880) { // 5 MB in bytes
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'File size exceeds the 5 MB limit',
                text: 'Please select a smaller file.',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('add_attendance.php');
                }
            });
        </script>";

            exit;
        } else {
            if ($_FILES["uploadfile"]["error"] == UPLOAD_ERR_OK) {
                // Delete the old image from the folder
                if (file_exists($old_image)) {
                    unlink($old_image);
                }

                $update_filename = $_FILES['uploadfile']['name'];
                $tempname = $_FILES["uploadfile"]["tmp_name"];
                $folder = "../files&img/" . $update_filename;
                move_uploaded_file($tempname, $folder);
            } else {
                // Handle file upload error
            }
        }

        // Use prepared statements to avoid SQL injection
        $stmt = mysqli_prepare($conn, "UPDATE `attend_form` SET emp_id=?, emp_name=?, attendby=?, shifttype=?, date=?, checkin=?, checkout=?, status=?, uploadfile=? WHERE id=?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssssi", $emp_id, $emp_name, $attendby, $shifttype, $date, $checkin, $checkout, $status, $folder, $id);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($success) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Data Updated Successfully',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'add_attendance.php';
                    }
                });
            </script>";
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: 'An error occurred while updating data.',
                });
            </script>";
            }
        }
    }
}
?>

<?php
include "include/header_ad.php";
?>

<main class="mt-5 pt-3">
    <div class="container">
        <h2><b>Employee Attendance Form-Update</b></h2><hr>

        <form action="#" method="POST" id="attendanceform" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="employeeid" class="mb-2">Employee-Id</label>
                        <input type="text" class="form-control" id="id" name="emp_id" value="<?php echo isset($result['emp_id']) ? $result['emp_id'] : ''; ?>" readonly>
                        <span id="empIdError" class="error"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="employeename" class="mb-2">Employee-Name</label>
                        <input type="text" class="form-control" id="name" name="emp_name" value="<?php echo isset($result['emp_name']) ? $result['emp_name'] : ''; ?>" readonly>
                        <span id="empNameError" class="error"></span>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="attendanceby" class="mb-2">Attendance-By<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <select class="form-select" id="attendance_by" name="attendby">
                            <option value="">Select</option>
                            <option value="HR-Admin" <?php echo (isset($result['attendby']) && $result['attendby'] == 'HR-Admin') ? 'selected' : ''; ?>>HR-Admin</option>
                        </select>
                        <span id="attendByError" class="error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="shift" class="mb-2">Shift<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <select class="form-select" id="shift" name="shifttype">
                            <option value="">Select</option>
                            <option value="Morning Shift" <?php echo (isset($result['shifttype']) && $result['shifttype'] == 'Morning Shift') ? 'selected' : ''; ?>>Morning Shift</option>
                            <option value="General Shift" <?php echo (isset($result['shifttype']) && $result['shifttype'] == 'General Shift') ? 'selected' : ''; ?>>General Shift</option>
                            <option value="Night Shift" <?php echo (isset($result['shifttype']) && $result['shifttype'] == 'Night Shift') ? 'selected' : ''; ?>>Night Shift</option>
                        </select>
                        <span id="shiftError" class="error"></span>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date" class="mb-2">Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo isset($result['date']) ? date('Y-m-d', strtotime($result['date'])) : ''; ?>" required>
                        <span id="dateError" class="error"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkin" class="mb-2">Check-in<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <input type="time" class="form-control" name="checkin" value="<?php echo isset($result['checkin']) ? date('H:i', strtotime($result['checkin'])) : ''; ?>" required>
                        <span id="checkinError" class="error"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkout" class="mb-2">Check-out<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <input type="time" class="form-control" name="checkout" value="<?php echo isset($result['checkout']) ? date('H:i', strtotime($result['checkout'])) : ''; ?>" required>
                        <span id="checkoutError" class="error"></span>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="position" class="mb-2">Status<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select class="form-select" id="status" name="status">
                    <option selected>Select</option>
                    <option value="Present" <?php echo (isset($result['status']) && $result['status'] == 'Present') ? 'selected' : ''; ?>>Present</option>
                    <option value="Absent" <?php echo (isset($result['status']) && $result['status'] == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                    <option value="Weekly Off" <?php echo (isset($result['status']) && $result['status'] == 'Weekly Off') ? 'selected' : ''; ?>>Weekly Off</option>
                    <option value="Half Day" <?php echo (isset($result['status']) && $result['status'] == 'Half Day') ? 'selected' : ''; ?>>Half Day</option>
                </select>
                <span id="statusError" class="error"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="uploadfile" id="middle-name" class="form-control col-md-7 col-xs-12" width="100%" type="file">
                    <input name="oldImg" id="middle-name" class="form-control col-md-7 col-xs-12" type="hidden" value="<?php echo $result['uploadfile']; ?>">
                    <img src="<?php echo $result['uploadfile']; ?>" width="100px">
                    <h6 class="text-end"><?php echo $result['uploadfile']; ?></h6>
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
    previousDate.setDate(currentDate.getDate() - 10);

    var nextDate = new Date();
    nextDate.setDate(currentDate.getDate() + 10);

    var previousDateString = previousDate.toISOString().slice(0, 10);
    var nextDateString = nextDate.toISOString().slice(0, 10);

    document.getElementById('date').min = previousDateString;
    document.getElementById('date').max = nextDateString;
</script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
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