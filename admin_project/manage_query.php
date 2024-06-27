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
<?php
include 'db.php';

//error_reporting(0);
$query = "SELECT * FROM add_query ORDER BY id DESC"; // Fetch rows in descending order by 'id'
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);
?>
<?php
// Assuming you have a query parameter 'id' representing the query ID
if (isset($_GET['id'])) {
    $queryId = $_GET['id'];

    // Update the status to 'Checked'
    $updateSql = "UPDATE add_query SET status = 'Checked' WHERE id = $queryId";
    mysqli_query($conn, $updateSql);
    
    // Redirect back to the page after updating
    header("Location: manage_query.php");
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
            integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style_admin.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />
    <title>Sourcecode-Admin Dashboard</title>
	

	<style>
		h2 {
		text-align: center;
		padding-top: 30px;
		
	}

	#backButton {
		text-align: center;
		border: 1px solid #fff;
		background-color: #449eda;
		color: #fff;
		border-radius: 5px;
		width: 80px;
		font-weight: 700;

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

    <?php
        include "include/header_ad.php";
    ?>     

<main class="mt-5 pt-3">
        <div class="container">
            <h2><b>Manage Queries</b></h2>
            <hr>
            <div class="table-responsive">
                <div class="table-wrapper">
                    
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                <th style="width: 3%;">Sr_No</th>
                                <th style="width: 5%;">Emp_id</th>
                                <th style="width: 15%;">Emp_name</th>
                                <th style="width: 10%;">Contact_No</th>
                                <th style="width: 15%;">Email_Id</th>
                                <th style="width: 10%;">Subject</th>
                                <th style="width: 20%;">Message</th>
                                <th style="width: 8%;">Date</th>
                                <th style="width: 13%;">Status</th>
                                <th style="width: 10%;">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1; // Initialize row number
                                $query = "SELECT * FROM add_query ORDER BY id DESC"; // Fetch rows in descending order by 'id'
                                $data = mysqli_query($conn, $query);
                                $total = mysqli_num_rows($data);

                                while ($result = mysqli_fetch_assoc($data)) {
                                    echo "<tr>
                                            <td>" . $no . "</td>
                                            <td>" . $result['emp_id'] . "</td>
                                            <td>" . $result['emp_name'] . "</td>
                                            <td>" . $result['contact'] . "</td>
                                            <td>" . $result['email'] . "</td>
                                            <td>" . $result['subject'] . "</td>
                                            <td>" . $result['message'] . "</td>
                                            <td>" . (isset($result['ondate']) ? date('d/m/Y', strtotime($result['ondate'])) : '') . "</td>
                                            <td>";

                                            if ($result['status'] == 'Done') {
                                                echo '<a href="query_status.php?id=' . $result['id'] . '&status=Reject" class="btn btn-success text-white"> Done <i class="fa fa-check" style="font-size: 14px;"></i></a>';
                                            } elseif ($result['status'] == 'Reject') {
                                                echo '<a href="query_status.php?id=' . $result['id'] . '&status=Done" class="btn btn-danger text-white"> Reject <i class="fa fa-times" style="font-size: 14px;"></i></a>';
                                            } else {
                                                echo '<a href="query_status.php?id=' . $result['id'] . '&status=Done" class="btn btn-warning text-white"> Pending <i class="fa fa-clock" style="font-size: 14px;"></i></a>';
                                            }

                                    echo "</td>
                                        <td>
                                            <a href='query_delete.php?id=" . $result['id'] . "' class='btn btn-danger text-white' style='background-color:#ed112e; margin-left:20px;'><i class='fa fa-trash' style='font-size: 14px;'></i></a>
                                        </td>
                                        </tr>";
                                    $no++; // Increment row number
                                }

                                if ($no == 1) {
                                    echo "<tr><td colspan='8'>No records found</td></tr>";
                                }
                                ?>


                            </tbody>
                        </table>
                </div>
            </div>
            <div class="form-group d-flex justify-content-center align-items-center">
            <a id="backButton" href="admin_index.php" class="btn btn-outline-white btn-md mt-2 ml-sm-2">Back</a>

            </div>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
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