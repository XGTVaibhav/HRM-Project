<?php
session_start();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- Bootstrap JS CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

    <!-- Google Fonts CDN Link -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />

    <title>SourceCode User Dashboard</title>

    <style>
    .error {
        color: red;
    }

    h2, h5 {
        text-align: center;
    }

    .monthly-attendance {
        text-align: center;
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
<?php
include 'db.php';
$id = $_SESSION['$user_name'];
$query = "SELECT * FROM `add_employe` WHERE emp_id = '$id'";
$query_show = mysqli_query($conn, $query);
$show = mysqli_fetch_assoc($query_show);
?>

<body>
    <!-- INCLUDE HEADER FILE -->
    <?php
    include "include/header_us.php";
    error_reporting(0);
    ?>

    <!-- FORM SECTION -->
    <main class="mt-5 pt-3">
    <div class="container-fluid">
        <h2 style="text-align:left"><b>Attendance Report</b></h2>
        <form id="attendanceform" method="get" action="#">

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="employeeid" class="mb-2">Employee-Id</label>
                        <input type="text" class="form-control" id="employeeid" name="emp_id"
                            placeholder="Employee Id" value="<?php echo $show['emp_id']; ?>" readonly>
                        <span id="empIdError" class="error"></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="employeename" class="mb-2">Employee-Name</label>
                        <input type="text" class="form-control" id="employeename" name="emp_name" placeholder="Employee Name" value="<?php echo $show['emp_name']; ?>" readonly>
                        <span id="empNameError" class="error"></span>
                    </div>
                </div>

                 <div class="col-md-4">
                    <label for="month">Month<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="month" class="form-control" id="month" name="date" placeholder="Month" value="<?php echo $show['date']; ?>">
                    <span id="dateError" class="error"></span>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <input type="submit" name="update" value="Submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    </main>

    <div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>

    <?php
    include 'db.php';
    $e_id = $_SESSION['$user_name'];
    $query = "SELECT * FROM attend_form WHERE emp_id= '$e_id'";
    $result = $conn->query($query);
    $conn->close();
    ?>

    <!--  FORM VALIDATION -->
    <script>
        document.getElementById("attendanceform").addEventListener("submit", function (event) {
            const empId = document.getElementById("employeeid");
            const empName = document.getElementById("employeename");
            const monthYear = document.getElementById("month");

            if (!empId.value) {
                displayError("empIdError", "Employee-Id is required.");
                event.preventDefault();
            } else {
                clearError("empIdError");
            }

            if (!empName.value) {
                displayError("empNameError", "Employee-Name is required.");
                event.preventDefault();
            } else {
                clearError("empNameError");
            }

            if (!monthYear.value) {
                displayError("dateError", "Month is required.");
                event.preventDefault();
            } else {
                clearError("dateError");
            }
        });

        function displayError(id, message) {
            const errorElement = document.getElementById(id);
            errorElement.textContent = message;
            errorElement.style.color = "red";
        }

        function clearError(id) {
            const errorElement = document.getElementById(id);
            errorElement.textContent = "";
        }
    </script> 


<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["emp_id"]) && isset($_GET["emp_name"]) && isset($_GET["date"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_hrmsoftwere";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $employee_id    = $conn->real_escape_string($_GET["emp_id"]);
        $employee_name  = $conn->real_escape_string($_GET["emp_name"]);
        $selected_month = $conn->real_escape_string($_GET["date"]);

        $sql = "SELECT id, date, status FROM attend_form WHERE emp_id = ? AND DATE_FORMAT(date, '%Y-%m') = ? ORDER BY date DESC";


        $stmt   = $conn->prepare($sql);

        $stmt->bind_param("ss", $employee_id, $selected_month);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<main class='mt-5 pt-3'>";
            echo "<h2 class='text-center monthly-attendance'><b>Monthly Attendance</b> 
                <a href='view_file.php?emp_id=$employee_id&date=$selected_month' class='btn btn-dark float-end'>
                    <i class='fas fa-eye'></i> View File
                </a>
            </h2>";
            echo "<hr>";
            echo "<h5 class='employee-info'>Employee-Name: $employee_name</h5>";
            echo "<h5 class='employee-info'>Employee-Id: $employee_id</h5>";

            echo "<div class='table-responsive'>";
            echo "<table id='report_table' class='table table-striped' style='width:100%; text-align: center;'>";
            echo "<thead>
                    <tr>
                    <th style='width: 30%; padding-left: 10%;'>Dates</th>
                    <th style='width: 10%;'>Status</th>
                    </tr>
                </thead>";
            echo "<tbody>";

            $counter = 1;

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                // echo "<td style='text-align: left; padding-left: 5%;'>$counter</td>";
                echo "<td style='text-align: left; padding-left: 10%;'>" . date('d/m/Y', strtotime($row['date'])) . "</td>";
                echo "<td style='text-align: left; padding-right: 25%;'>" . $row["status"] . "</td>";
                echo "</tr>";


                $counter++;
            }

            echo "</tbody></table>";

            echo "</div>";

            echo "</div>";
            echo "</main>";
        } else {
            // No data found message
            echo "<script>alert('No Data Found For Given Employee');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables CSS and JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Popper.js and Bootstrap JS Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


<script>
    $(document).ready(function () {
    // Initialize DataTable
    $('#report_table').DataTable();
    });
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