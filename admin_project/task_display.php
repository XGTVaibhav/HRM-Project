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
$query = "SELECT * FROM new_task ORDER BY id DESC"; // Fetch rows in descending order by 'id'
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);

if ($total != 0)
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sourcecode-Admin Dashboard</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
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

<?php 
    include("db.php");

    $query = "SELECT * FROM add_employe";
    $data = mysqli_query($conn,$query);

    $total= mysqli_num_rows($data);


    if($total !=0)
    {
?>

<body>
  <?php
    include "include/header_ad.php";
  ?>

               
<main class="mt-5 pt-3">
    <div class="container rkdisplay">
    <h2 align="center" style="color: black;"><b>Ticket List</b></h2><hr>
    <table id="example" class="table table-striped table-responsive " style="width:100%">
        <thead>
            <tr>
                <th>Sr_No</th>
                <th>Emp_ID</th> 
                <th>Emp_Name</th>
                <th>Project_Name</th>
                <th>Project_Description</th>
                <th>Assign_Ticket</th>
                <th>Start_Date</th>
                <th>End_Date</th>
                <th>Upload</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
            include("db.php");

            $query = "SELECT * FROM `new_task` ORDER BY id DESC";
            $data = mysqli_query($conn, $query);

            $total = mysqli_num_rows($data);

            if ($total != 0) {
                include "include/header_ad.php";
                $rowNumber = 0; // Initialize the row number counter
                while ($result = mysqli_fetch_assoc($data)) {
                    $rowNumber++; // Increment the row number
                    echo "<tr>
                            <td>" . $rowNumber . "</td> <!-- Display the row number -->
                            
                            <td>" . $result['emp_id'] . "</td>
                            <td>" . $result['emp_name'] . "</td>
                            <td>" . $result['project_name'] . "</td>
                            <td>" . $result['description'] . "</td>
                            <td>" . $result['a_task'] . "</td>
                            <td scope='col'>" . date('d/m/Y', strtotime($result['start_date'])) . "</td>
                            <td scope='col'>" . date('d/m/Y', strtotime($result['end_date'])) . "</td>
                            <td> <img src='" . $result['upload'] . "' height='100px' width='100px'></td>
                            <td>" . $result['status'] . "</td>
                            <td >

                                <div class='btn-group'>
                                    <a href='task_update.php?id=" . $result['id'] . "' class='btn btn-info text-white' style='margin-left: 20px;'><i class='fa fa-edit' style='font-size: 14px;'></i></a>
                                    <a href='task_view.php?id=" . $result['id'] . "' class='btn btn-success text-white' style='margin-left: 20px;'><i class='fa fa-eye' style='font-size: 14px;'></i></a>
                                    <a href='task_delete.php?id=" . $result['id'] . "' class='btn btn-danger text-white' style='background-color: #ed112e; margin-left: 20px;'><i class='fa fa-trash' style='font-size: 14px;'></i></a>
                                </div>
                            </td>
                        </tr>";
                        }
                    } 
                    else 
                    {
                        echo "No records found";
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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>


</body>

</html>