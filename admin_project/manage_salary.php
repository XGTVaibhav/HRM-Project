<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in


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
 include "include/header_ad.php";
?>

<main class="mt-5 pt-3">   
    <div class="container ">
        <div class="d-flex justify-content-center ">
            <h2><b>Manage Employee Salary</b></h2>
        </div>   
        <hr>
        <div class="table-responsive">
            <div class="table-wrapper">
            <table class="table table-striped" style="width:100%" id="employeeTable">
                    <thead>
                        <tr>
                            <th>Emp_ID</th>
                            <th>Emp_Name</th>
                            <th>Month</th>
                            <th>Basic_Salary</th>
                            <th>Conveyance</th>
                            <th>Allowances</th>
                            <th>HRA</th>
                            <th>MA</th>
                            <th>DA</th>
                            <th>ESI</th>
                            <th>PF</th>
                            <th>TDS</th>
                            <th>Net_Salary</th>.
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    <?php
                        // Sample database connection
                        $servername = "localhost";
                        $username   = "root";
                        $password   =  "";
                        $dbname     =  "db_hrmsoftwere";
                        
                           $conn = mysqli_connect($servername,$username,$password,$dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $query = "SELECT * FROM emp_salary ORDER BY id DESC";
                        $data = mysqli_query($conn, $query);
                        $total = mysqli_num_rows($data);

                        if ($total != 0) {
                            $results = array();
                            $rowNumber = 1;

                            while ($result = mysqli_fetch_assoc($data)) {
                                $results[] = $result;
                            }

                            foreach ($results as $result) {
                                echo "<tr style='height:40px;'>
                                    <td>" . $result['emp_id'] . "</td>
                                    <td>" . $result['emp_name'] . "</td>
                                    <td>" . $result['month'] . "</td>
                                    <td>" . (isset($result['basicsalary']) ? $result['basicsalary'] : '') . "</td>
                                    <td>" . (isset($result['conveyance']) ? $result['conveyance'] : '') . "</td>
                                    <td>" . (isset($result['allowances']) ? $result['allowances'] : '') . "</td>
                                    <td>" . (isset($result['hra']) ? $result['hra'] : '') . "</td>
                                    <td>" . (isset($result['medicalallowance']) ? $result['medicalallowance'] : '') . "</td>
                                    <td>" . (isset($result['da']) ? $result['da'] : '') . "</td>
                                    <td>" . (isset($result['esi']) ? $result['esi'] : '') . "</td>
                                    <td>" . (isset($result['pf']) ? $result['pf'] : '') . "</td>
                                    <td>" . (isset($result['tds']) ? $result['tds'] : '') . "</td>
                                    <td>" . (isset($result['netsalary']) ? $result['netsalary'] : '') . "</td>
                                    <td>
                                        <div class='btn-group'>
                                            <a href='salary_update.php?id=" . $result['id'] . "' class='btn btn-info text-white mr-2'>
                                                <i class='fa fa-edit' style='font-size: 14px;'></i> 
                                            </a>
                                            <a href='salary_delete.php?id=" . $result['id'] . "' class='btn btn-danger text-white mr-2' style='background-color:#ed112e;'>
                                                <i class='fa fa-trash' style='font-size: 14px;'></i> 
                                            </a>
                                            <a href='salary_view.php?id=" . $result['id'] . "' class='btn btn-success text-white' style='background-color:green;'>
                                                <i class='fa fa-eye' style='font-size: 14px;'></i> 
                                            </a>
                                        </div>
                                
                                    </td>

                                    </tr>";
                            
                                $rowNumber++;
                            }
                            
                            
                        } else {
                            echo "<tr><td colspan='13'>No records Found</td></tr>";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

            <div>
                <footer class="text-black text-center py-2" style="margin-right:22%;">
            
                <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
                </footer>
            </div>

<script>
        $(document).ready(function () {
            $('#employeeTable').DataTable({
                "pagingType": "full_numbers", // Enable pagination with numbers and "Previous" / "Next" buttons
                "lengthMenu": [10, 25, 50, 75, 100], // Set the page length options
                "pageLength": 10, // Set the default page length
                "order": [], // Disable initial sorting
            });
        });
    </script>
 
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