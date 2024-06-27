<?php
session_start();

include("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />
    <title>SourceCode User Dashboard</title>

    <style>
        .error {
            color: red;
        }
       
    </style>
</head>

<body>
    <!-- HEADER.PHP -->
    <?php
    include "include/header_us.php";
    ?>
    <main class="mt-5 pt-3">
        <div class="container">
            <h2><b>Employee Leave Form</b></h2><hr>
            <form action="#" method="post" id="form" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employeeid" class="mb-2">Employee-Id</label>
                            <input type="text" class="form-control" id="employeeid" name="emp_id" placeholder="Employee Id" value="<?php echo $show['emp_id']; ?>" readonly>
                            <span id="empIdError" class="error"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employeename" class="mb-2">Employee-Name</label>
                            <input type="text" class="form-control" id="employeename" name="emp_name" placeholder="Employee Name" value="<?php echo $show['emp_name']; ?>" readonly>
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
                            <label for="date" class="mb-2">From Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                            <input type="date" class="form-control" id="fromDate" name="frmdate" placeholder="From Date">
                            <span id="frmDateError" class="error"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date" class="mb-2">To Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                            <input type="date" class="form-control" id="toDate" placeholder="To Date" name="todate">
                            <span id="toDateError" class="error"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                <div class="col-md-">
                    <label for="reason" class="mb-2">Reason<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <textarea class="form-control" id="checkout" placeholder="Enter Reason......" name="reason"><?php echo isset($existingData['reason']) ? $existingData['reason'] : ''; ?></textarea>
                    <span id="reasonError" class="error"></span>
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
        document.getElementById("form").addEventListener("submit", function(event) {
            const empId = document.getElementById("employeeid");
            const empName = document.getElementById("employeename");
            const leaveType = document.getElementById("leavetypeWide");
            const fromDate = document.getElementById("fromDate");
            const toDate = document.getElementById("toDate");
            const reason = document.getElementById("checkout");

            if (!empId.value || !empName.value || leaveType.value === "Select" || !fromDate.value || !toDate.value || !reason.value) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Form Submission Failed',
                    text: 'Please fill in all the fields.',
                });
            }
        });
    </script>

    <?php
    include 'db.php';

    if (isset($_POST['submit'])) {
        $empid = test_input($_POST['emp_id']);
        $empname = test_input($_POST['emp_name']);
        $attendby = test_input($_POST['leavetype']);
        $shifttype = test_input($_POST['frmdate']);
        $checkin = test_input($_POST['todate']);
        $checkout = test_input($_POST['reason']);
       // $comment = test_input($_POST['comment']);

        // Validate required fields
        if (empty($empid) || empty($empname) || empty($attendby) || empty($shifttype) || empty($checkin) || empty($checkout)) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Form Submission Failed',
                    text: 'Please fill in all the fields.',
                });
            </script>";
        } else {
            $query = "INSERT INTO `leaveform`(`emp_id`, `emp_name`, `leavetype`, `frmdate`, `todate`, `reason`)
                    VALUES ('$empid','$empname','$attendby','$shifttype','$checkin','$checkout')";

            $data = mysqli_query($conn, $query);

            if ($data) {
                echo "<script>
                  Swal.fire({
                    icon: 'success',
                    title: 'Record Inserted Successfully',
                  
                  }).then(() => {
                    window.location.replace('emp_leave.php');
                  });
                </script>";
              } else {
                echo "<script>
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating data.',
                  });
                </script>";
              }
            }
    }
    ?>

    <?php
    include 'db.php';
    $e_id = $_SESSION['$user_name'];

    $query = "SELECT * FROM leaveform WHERE emp_id= '$e_id'";
    $result = $conn->query($query);

    $conn->close();
    ?>

    <main class=" mt-5 pt-5">
        <div class="container">

            <h2 style="text-align: center;"><b>Manage Leave</b></h2>
            <hr>

            <table id="example" class="table table-striped" style="width:100%">
                <thead class="bg-dark text-light">
                    <tr>
                        <th width="15%" scope="col">Leave-Type</th>
                        <th width="10%" scope="col">From</th>
                        <th width="10%" scope="col">To</th>
                        <th width="10%" scope="col">Reason</th>
                        <th width="10%" scope="col">Comment</th>
                        <th width="10%" scope="col">Status</th>
                    </tr>
                </thead>

                <?php
                include("db.php");

                $query = "SELECT * FROM `leaveform` WHERE emp_id = '$e_id' ORDER BY id DESC";
 // Use ORDER BY to sort in descending order by id
                $data = mysqli_query($conn, $query);
                $total = mysqli_num_rows($data);
                $counter = 1; // Initialize the counter

                if ($total != 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                            <td>" . $result['leavetype'] . "</td>
                            <td>" . date('d/m/Y', strtotime($result['frmdate'])) . "</td>
                            <td>" . date('d/m/Y', strtotime($result['todate'])) . "</td>
                            <td>" . $result['reason'] . "</td>
                            <td>" . $result['comment'] . "</td>
                            <td>" . $result['status'] . "</td>
                        </tr>";
                        $counter++; // Increment the counter
                    }
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Popper.js and Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- PAGINATION -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
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