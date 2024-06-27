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
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <!-- Bootstrap CSS CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <!-- Google Fonts CDN Link (example fonts) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font Awesome CDN Link (Note: Correct the version and integrity attribute) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    
    <!-- Other CSS Links (fix incorrect links) -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS (replace with your actual CSS files) -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css">
    <!-- SweetAlert2 CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">



    
    <title>Sourcecode-Admin Dashboard</title>
    
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
    </style>
</head>


<body>
    <!-- HEADER.PHP -->
    <?php 
    include "include/header_ad.php"; 
    ?>
    
    <!-- FORM SECTION STARTS -->
    <main class="mt-5 pt-3">
    <div class="container ">
        <h2><b>Employee Leave Form</b></h2><hr>
        <form action="#" method="post" id="form"  enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="employeeid" class="mb-2">Employee-Id<span class="text-danger" style="font-size: 1.2em;">*</span></label>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="leavetype" class="mb-2">Leave-Type<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <select class="form-select" id="leavetypeWide" name="leavetype">
                            <option selected>Select</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Compensatory Off">Compensatory Off</option>
                            <option value="Bereavement Leave">Bereavement Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                        </select>
                        <span id="leaveTypeError" class="error"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fromDate" class="mb-2">From Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <input type="date" class="form-control" id="fromDate" name="frmdate" placeholder="Enter From Date">
                        <span id="frmDateError" class="error"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="toDate" class="mb-2">To Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <input type="date" class="form-control" id="toDate" name="todate" placeholder="Enter To Date">
                        <span id="toDateError" class="error"></span>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label for="reason" class="mb-2">Reason<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <textarea class="form-control" id="checkout" placeholder="Enter Reason......" name="reason"><?php echo isset($existingData['reason']) ? $existingData['reason'] : ''; ?></textarea>
                    <span id="reasonError" class="error"></span>
                </div>

                <div class="col-md-6">
                    <label for="comment" class="mb-2">Comment</label>
                    <textarea class="form-control" id="comment" placeholder="Enter Comment......" name="comment"><?php echo isset($existingData['comment']) ? $existingData['comment'] : ''; ?></textarea>
                    <span id="commentError" class="error"></span>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    </main>

    
        
    <!-- FORM VALIDATION -->
    <script>
    document.getElementById("form").addEventListener("submit", function (event) {
        const empId = document.getElementById("employeeid");
        const empName = document.getElementById("employeename");
        const leaveType = document.getElementById("leavetypeWide");
        const fromDate = document.getElementById("fromDate");
        const toDate = document.getElementById("toDate");
        const reason = document.getElementById("checkout");

        if (!empId.value || !empName.value || leaveType.value === "Select" || !fromDate.value || !toDate.value || !reason.value) {
            event.preventDefault(); // Prevent form submission if validation fails
            Swal.fire({
                icon: 'error',
                title: 'Form Submission Failed',
                text: 'Please fill in all the required fields.',
            });
        } else {
            // Form is valid, you can submit the form here
        }
    });
</script>

</body>
</html>

<!-- INSERT QUERY-SECTION-->
<?php
// Database connection information
$servername = "localhost";
$username   = "root";
$password   =  "";
$dbname     =  "db_hrmsoftwere";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['submit'])) {
    $empid     = test_input($_POST['emp_id']);
    $empname   = test_input($_POST['emp_name']);
    $leavetype = test_input($_POST['leavetype']);
    $frmdate   = test_input($_POST['frmdate']);
    $todate    = test_input($_POST['todate']);
    $reason    = test_input($_POST['reason']);
    $comment   = test_input($_POST['comment']);

    // Check for empty fields
    if (empty($empid) || empty($empname) || empty($leavetype) || empty($frmdate) || empty($todate) || empty($reason)) {
        echo "Please fill in all the required fields.";
    } else {
        // Check if a similar entry already exists
        $query = $conn->prepare("SELECT * FROM `leaveform` WHERE `emp_id` = ? AND `emp_name` = ? AND `leavetype` = ? AND `frmdate` = ? AND `todate` = ? AND `reason` = ? AND `comment` = ?");

        // Assuming you have a $comment variable containing the comment value
        $comment = "Your comment value here";

        // Bind parameters
        $query->bind_param("sssssss", $empid, $empname, $leavetype, $frmdate, $todate, $reason, $comment);

        // Execute the query
        $query->execute();

        // Fetch the result or perform further operations as needed
        $result = $query->get_result();
        $count = $result->num_rows;

        if ($count > 0) {
            echo "Duplicate entry. This record already exists.";
        } else {
            $insertQuery = $conn->prepare("INSERT INTO `leaveform`(`emp_id`, `emp_name`, `leavetype`, `frmdate`, `todate`, `reason`, `comment`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("sssssss", $empid, $empname, $leavetype, $frmdate, $todate, $reason, $comment);

            if ($insertQuery->execute()) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data Inserted Successfully!',
                    }).then(function() {
                        window.location.replace('add_leave.php');
                    });
                </script>";
            } else {
                echo "Error: " . $insertQuery->error;
            }
        }
    }
}

// Close the database connection when done
mysqli_close($conn);
?>





<!-- MANAGE LEAVE-TABLE SECTION -->
<main class="mt-5 pt-3">
    <div class="container">
        <div class="d-flex justify-content-center mt-3">
            <h2><b>Manage Employee Leave</b></h2>
        </div>

        <hr>
        <table id="example" class="table table-striped table-responsive" width="100%">

            <thead class="bg-dark text-light">
                <tr>
                    <th width="5%" scope="col">Sr_No</th>
                    <th width="5%" scope="col">Emp_Id</th>
                    <th width="8%" scope="col">Emp_Name</th>
                    <th width="10%" scope="col">Leave_Type</th>
                    <th width="10%" scope="col">From_date</th>
                    <th width="10%" scope="col">To_date</th>
                    <th width="8%" scope="col">Reason</th>
                    <th width="8%" scope="col">Comment</th>
                    <th width="15%" scope="col">Status</th>
                    <th width="15%" scope="col">Action</th>
                </tr>
            </thead>

            <?php
            include("db.php");

            $query = "SELECT * FROM `leaveform` ORDER BY id DESC";
            $data = mysqli_query($conn, $query);
            $total = mysqli_num_rows($data);

            if ($total != 0) {
                $rowNumber = 1; // Initialize row number with 1
                while ($result = mysqli_fetch_assoc($data)) {
                    echo "<tr style='height:40px;'>
                        <td>" . $rowNumber . "</td>
                        <td>" . $result['emp_id'] . "</td>
                        <td>" . $result['emp_name'] . "</td>
                        <td>" . $result['leavetype'] . "</td>
                        <td scope='col'>" . date('d/m/Y', strtotime($result['frmdate'])) . "</td>
                        <td scope='col'>" . date('d/m/Y', strtotime($result['todate'])) . "</td>
                        <td>" . (isset($result['reason']) ? $result['reason'] : '') . "</td>
                        <td>" . (isset($result['comment']) ? $result['comment'] : '') . "</td>
                        <td>";
                

                    if ($result['status'] == 'Accept') {
                        echo '<a href="leave_status.php?id=' . $result['id'] . '&status=Reject" class="btn btn-success text-white"> Accept <i class="fa fa-check" style="font-size: 14px;"></i></a>';
                    } elseif ($result['status'] == 'Reject') {
                        echo '<a href="leave_status.php?id=' . $result['id'] . '&status=Accept" class="btn btn-danger text-white"> Reject <i class="fa fa-times" style="font-size: 14px;"></i></a>';
                    } else {
                        echo '<a href="leave_status.php?id=' . $result['id'] . '&status=Accept" class="btn btn-warning text-white"> Pending <i class="fa fa-clock" style="font-size: 14px;"></i></a>';
                    }

                    echo "</td>
                            <td>
                                <a href='update_leave.php?id=" . $result['id'] . "' class='btn btn-info text-white'>
                                    <i class='fa fa-edit' style='font-size: 14px;'></i>
                                </a>
                                <a href='delete_leave.php?id=" . $result['id'] . "' class='btn btn-danger text-white'>
                                    <i class='fa fa-trash' style='font-size: 14px;'></i>
                                </a>
                            </td>
                        </tr>";

                    $rowNumber++; // Increment row number for the next iteration
                }
            } else {
                echo "<tr><td colspan='10'>No records Found</td></tr>";
            }
            ?>
        </table>
    </div>
</main>

<div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (required for Bootstrap and DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- PAGINATION -->
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    
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

<script>
    var currentDate = new Date();

    var fromDateString = currentDate.toISOString().slice(0, 10);

    document.getElementById('fromDate').value = fromDateString;
    document.getElementById('fromDate').min = fromDateString;

    document.getElementById('toDate').min = fromDateString;
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