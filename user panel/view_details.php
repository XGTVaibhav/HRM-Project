<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

$_SESSION['last_activity'] = time();

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
 
    session_unset();
    session_destroy();
    header('location:login_user.php');
    exit();
}

$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

$logged_in_user_id = $_SESSION['$user_name'];

include 'db.php';

$query = "SELECT * FROM emp_salary WHERE month = ? AND emp_id = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, 'si', $selected_month, $logged_in_user_id);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$query_result = mysqli_stmt_get_result($stmt);

$show = mysqli_fetch_assoc($query_result);

mysqli_stmt_close($stmt);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
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
    <title>Sourcecode-Admin Dashboard</title>
    <!-- Add the html2canvas library -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

</head>

<body>
   
    <!-- <main class="mt-5 pt-3"> -->
    <section class="h-100">
        <div class="container  py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-lg-9 col-xl-7">
                
                <div class="card" id="captureCard">
   
                      <div class="rounded-top text-white d-flex flex-row " style="background-color:#2c3e50; height:200px;">
                        <div class="ms-3 ">
                        <h3><b>Employee Salary Details</b> - <span style="font-weight:normal;">Sourcecode Software </span></h3>
 
                            <ul class="list-unstyled mt-5 mb-2">
                            <li><h5><b>Payslip For:</b> <?php echo date('F Y', strtotime($show['month'])) ?? ''; ?></h5></li>

                                <li><h5><b>Employee Name:</b> <?php echo $show['emp_name'] ?? ''; ?></h5></li>
                                <li><h5><b> Employee ID:</b> <?php echo $show['emp_id'] ?? ''; ?></h5></li>
                                <li><h5><b>Present Day:</b> <?php echo $show['pday'] ?? ''; ?></h5></li>

                            </ul>
                        </div>
                      </div>                 

                      <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="mb-4"><b> Earnings </b></h3>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">Basic Salary (INR):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['basicsalary']) ? $show['basicsalary'] : 'N/A'; ?></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">Allowances (INR):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['allowances']) ? $show['allowances'] : 'N/A'; ?></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">House Rent Allowance(INR):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['hra']) ? $show['hra'] : 'N/A'; ?></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">Dearness Allowance (INR):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['da']) ? $show['da'] : 'N/A'; ?></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">Medical Allowance (INR):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['medicalallowance']) ? $show['medicalallowance'] : 'N/A'; ?></span></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="mb-4"><b> Deductions </b></h3>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">PF (%):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['pf']) ? $show['pf'] : 'N/A'; ?></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">ESI (%):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['esi']) ? $show['esi'] : 'N/A'; ?></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1">TDS (%):</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="font-italic mb-1"><span><?php echo isset($show['tds']) ? $show['tds'] : 'N/A'; ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional card for Net Salary -->
                        <div class="card mt-4 bg-light">
                            <div class="card-body">
                                <h3 class="mb-4"><b> Net Salary </b></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="font-italic mb-1">Net Salary (INR): <span><?php echo isset($show['in_hand']) ? $show['in_hand'] : 'N/A'; ?></span></p>
                                    </div>
                                    <div class="col-md-6">
                                    <p class="font-italic mb-1">Net Gross Salary: <span><?php echo isset($show['netsalary']) ? $show['netsalary'] : 'N/A'; ?></span></p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
              </div>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-center align-items-center">
            
            <div class="rounded-top text-white d-flex flex-row justify-content-between mt-2">
                <div>
                    <button id="downloadButton" class="btn btn-primary">
                        <i class="bi bi-download me-2"></i> Download as Image
                    </button>
                </div>
                <div class="ms-3">
                    <a href="payslip.php" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </section>
<!-- </main> -->

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js" integrity="sha384-Z9BEfcgqDFMPcL1AD8BttxPcY7WdYFsgRjO5i4LPFPih4JAEbmFPrxXtde3mo/OL" crossorigin="anonymous"></script>
    
    <script>
        document.getElementById('downloadButton').addEventListener('click', function () {
            const element = document.getElementById('captureCard');

            html2canvas(element).then(function (canvas) {
                const dataUrl = canvas.toDataURL("image/png");
                const link = document.createElement('a');
                link.href = dataUrl;
                link.download = 'Salary Slip.png';
                link.click();
            });
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


