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

<!-- HTML CODE SECTION -->
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
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >


    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />        
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>


    <!-- Internal CSS -->
    <style>
    .error
    {
        color: red;
    }

    .form-control::placeholder,
    .form-select::placeholder 
    {
        font-size: 14px;
    }
	img 
	{
		height: 100px;
		width: 100px;
	}
    </style>
</head>

<body>
<!-- HEADER FILE -->
<?php
    include "include/header_ad.php";
?>

<!-- FORM SECTION -->
<main class="mt-5 pt-3">
<div class="container">
    <h2><b>Employee Attendance Form</b></h2><hr>
  
    <form action="#" method="POST" id="attendanceform" enctype="multipart/form-data" novalidate>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                <label for="employeeid" class="mb-2">Employee-Id <span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="employeeid" name="emp_id" placeholder="Enter Employee-Id" oninput="fetchEmployeeDetails(this.value, true)">
                    <span id="empIdError" class="error"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="employeename" class="mb-2">Employee-Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="employeename" name="emp_name" placeholder="Enter Employee Name" oninput="fetchEmployeeDetails(this.value, false)">
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
                        <option value="HR-Admin">HR-Admin</option>
                    </select>
                    <span id="attendByError" class="error"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shift" class="mb-2">Shift<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <select class="form-select" id="shift" name="shifttype">
                        <option selected>Select</option>
                        <option value="Morning Shift">Morning Shift</option>
                        <option value="General Shift">General Shift</option>
                        <option value="Night Shift">Night Shift</option>
                    </select>
                    <span id="shiftError" class="error"></span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="date" class="mb-2">Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date">
                <span id="dateError" class="error"></span>
            </div>
        </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="checkin" class="mb-2">Check-in<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="time" class="form-control" id="checkin" placeholder=" Enter Check-in" name="checkin">
                    <span id="checkinError" class="error"></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="checkout" class="mb-2">Check-out<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="time" class="form-control" id="checkout" placeholder="Enter Check-out" name="checkout">
                    <span id="checkoutError" class="error"></span>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="position" class="mb-2">Status<span class="text-danger" style="font-size: 1.2em;">*</span></label>
            <select class="form-select" id="status" name="status">
                <option selected>Select</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Weekly Off">Weekly Off</option>
                <option value="Half Day">Half Day</option>
            </select>
            <span id="statusError" class="error"></span>
        </div>

		<div class="form-group mb-3">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo <span class="required"></span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" name="uploadfile" id="uploadfile" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
              
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <input type="submit" name="update" value="Submit" class="btn btn-primary">
        </div>
    </form>
</div>
</main>

<!-- FORM VALIDATION -->
<script>
    document.getElementById("attendanceform").addEventListener("submit", function (event) {
        const empId     = document.getElementById("employeeid");
        const empName   = document.getElementById("employeename");
        const attendBy  = document.getElementById("attendance_by");
        const shift     = document.getElementById("shift");
        const date      = document.getElementById("date");
        const checkin   = document.getElementById("checkin");
        const checkout  = document.getElementById("checkout");
        const status    = document.getElementById("status");

        // Validate required fields
        if (!empId.value || !empName.value || !attendBy.value || shift.value === "Select" || !date.value || !checkin.value || !checkout.value || status.value === "Select") {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form Submission Failed',
                text: 'Please fill in all the required fields!',
            });
        }
    });
</script>

<!-- DISPLAY PAGE -->
<main class="mt-5 pt-3">   
<div class="container ">
    <div class="d-flex justify-content-center ">
        <h2><b>Manage Employee Attendance</b></h2>
    </div>   
    <hr>
    <div class="table-responsive">
        <div class="table-wrapper">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                <tr style="background-color: #a795f5;">
                    <th style="width: 3%; text-align: center;">Sr_No</th>
                    <th style="width: 5%;">Emp_Id</th>
                    <th style="width: 10%;">Emp_Name</th>
                    <th style="width: 10%;">Attendance_By</th>
                    <th style="width: 8%;">Shift</th>
                    <th style="width: 10%;">Date</th>
                    <th style="width: 4%;">Check_In</th>
                    <th style="width: 4%;">Check_Out</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 8%;">File</th>
                    <!-- <th style="width: 8%;">Excel File</th> -->
                    <th style="width: 30%;">Action</th>
                </tr>

                </thead>

                <tbody>
				<?php

					$query = "SELECT * FROM `attend_form` ORDER BY id DESC";
					$data = mysqli_query($conn, $query);
					$total = mysqli_num_rows($data);

					if ($total != 0) {
						$results = array();
						$rowNumber = $total;

						$rowNumber = 1;

						while ($result = mysqli_fetch_assoc($data)) {
							$results[] = $result;
						}

						foreach ($results as $result) {
							echo "<tr style='height:40px;'>
							<td>" . $rowNumber . "</td>
							<td>" . $result['emp_id'] . "</td>
							<td>" . $result['emp_name'] . "</td>
							<td>" . $result['attendby'] . "</td>
							<td>" . $result['shifttype'] . "</td>
							<td>" . date('d/m/Y', strtotime($result['date'])) . "</td>
							<td>" . $result['checkin'] . "</td>
							<td>" . $result['checkout'] . "</td>
							<td>" . $result['status'] . "</td>
							<td > 
                              <img src=".$result['uploadfile']." >
                            </td>

							<td>
								<a href='attendance_update.php?id=" . $result['id'] . "' class='btn btn-info text-white'>
									<i class='fa fa-edit' style='font-size: 14px;'></i>
								</a>
								<a href='attendance_delete.php?id=" . $result['id'] . "' class='btn btn-danger text-white' style='background-color:#ed112e; margin-top:10px;'>
									<i class='fa fa-trash' style='font-size: 14px;'></i>
								</a>
							</td>
						</tr>";

							$rowNumber++;
						}
					} else {
						echo "<tr><td colspan='10'>No records Found</td></tr>";
					}
				?>

                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>


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

    
<!-- PAGINATION SCRIPT -->
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "paging": true,
            "pageLength": 10,
        });
    });
</script>

<!-- Fetch Employee Name/ID Script -->
<script>
    // Function to fetch employee details by ID or Name
    function fetchEmployeeDetails(input, isId) {
        const targetInput = isId ? "#employeename" : "#employeeid";
        const errorElementId = isId ? "empIdError" : "empNameError";

        // Prepare the data to be sent in the AJAX request
        const requestData = isId ? { employeeId: input } : { employeeName: input }; 

        // Make an AJAX request to get the employee details
        $.ajax({
            url: 'fetch_employee_details.php',
            method: 'POST',
            data: requestData,
            success: function (response) {
                $(targetInput).val(response);
                clearError(errorElementId); // Clear any previous error
            },
            error: function () {
                displayError(errorElementId, 'Failed to fetch employee details.');
            }
        });
    }
</script>

<!-- Script for Previous One day and Next One day -->
<script>
    
    var currentDate = new Date();
    
    var previousDate = new Date();
    previousDate.setDate(currentDate.getDate() - 7);
    
    var nextDate = new Date();
    nextDate.setDate(currentDate.getDate() + 1);
    
    var previousDateString = previousDate.toISOString().slice(0, 10);
    var nextDateString = nextDate.toISOString().slice(0, 10);
    
    document.getElementById('date').min = previousDateString;
    document.getElementById('date').max = nextDateString;
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check if any required field is empty
    $requiredFields = ['emp_id', 'emp_name', 'attendby', 'shifttype', 'date', 'checkin', 'checkout', 'status'];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Form Submission Failed',
                    text: 'Please fill in all the required fields!',
                }).then(function() {
                    window.location.replace('add_attendance.php');
                });
            </script>";

            exit;
        }
    }

    // Get other form data
    $emp_id     = test_input($_POST['emp_id']);
    $emp_name   = test_input($_POST['emp_name']);
    $attendby   = test_input($_POST['attendby']);
    $shifttype  = test_input($_POST['shifttype']);
    $date       = test_input($_POST['date']);
    $checkin    = test_input($_POST['checkin']);
    $checkout   = test_input($_POST['checkout']);
    $status     = test_input($_POST['status']);

    // Check if file is uploaded
    if (isset($_FILES['uploadfile']) && $_FILES['uploadfile']['error'] == UPLOAD_ERR_OK) {
        $maxFileSize = 5242880; // 5 MB in bytes

        // Check file size
        if ($_FILES['uploadfile']['size'] <= $maxFileSize) {
            $filename = $_FILES["uploadfile"]["name"];
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $folder = "../files&img/" . $filename;
            move_uploaded_file($tempname, $folder);
        } else {
            // File size exceeds the limit
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'File Size Exceeds Limit',
                    text: 'Please upload a file up to 5 MB in size.',
                });
            </script>";

            exit;
        }
    } 

    
    // Check for Duplicate Data
    $checkDuplicateQuery = "SELECT id FROM `attend_form` WHERE emp_id = '$emp_id' AND date = '$date'";
    $result = mysqli_query($conn, $checkDuplicateQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Entry',
                text: 'Duplicate entry for the same employee and date.',
            }).then(function() {
                window.location.replace('add_attendance.php');
            });
        </script>";

        exit;
    }

    // Insert data into the database
    $insertQuery = "INSERT INTO `attend_form` (`emp_id`, `emp_name`, `attendby`, `shifttype`, `date`, `checkin`, `checkout`, `status`, `uploadfile`) 
                    VALUES ('$emp_id', '$emp_name', '$attendby', '$shifttype', '$date', '$checkin', '$checkout', '$status', '$folder')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Attendance Record Added',
                text: 'You have successfully added an attendance record.',
            }).then(function() {
                window.location.replace('add_attendance.php');
            });
        </script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }

    exit;
}
?>