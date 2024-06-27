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
$query = "SELECT * FROM add_employe ORDER BY id DESC"; // Fetch rows in descending order by 'id'
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
    #backButton {
        text-align: center;
        border: 1px solid #fff;
        background-color: #449eda;
        color: #fff;
        border-radius: 5px;
        width: 80px;
        font-weight: 700;
    }

    table {
        background-color: #c4f2e5;
        color: #090a0a;
    }

    .button a {
        text-decoration: none;
        height: 35px;
        float: left;
        background-color: green;
        color: white;
        margin-left: 10px;
        width: 40px;
        padding: 6px;
        border-radius: 5px;
        padding-left: 13px;
        /* padding-right: 10px; */
    }

    .delete {
        background-color: red;
        margin-left: 40px;
    }

    td img {
        height: 100px;
        width: 100px;
    }

    .dataTables_length {
        float: left;
    }

    i {
        color: white;
    }

    .view {
        background-color: yellow;
    }
</style>
</head>

<body>

    <?php
        include "include/header_ad.php";
    ?>

    <?php 
        include("db.php");
        $query = "SELECT * FROM add_employe ORDER BY id DESC";
        $data = mysqli_query($conn,$query);
        $total= mysqli_num_rows($data);
        if($total !=0)
    ?>

                
  <main class="mt-5 pt-3">
    <div class="container">
        <h2 class="text-dark" style="text-align: center;"><b> Manage Employee Profile</b></h2>
        <hr>
        <div class="table-responsive">
            <div class="table-wrapper">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr style="background-color: #a795f5;" width="100%">
                            <th width="10%">Sr_No</th>
                            <th width="10%">Emp_Id</th>
                            <th width="10%">Emp_Photo</th>
                            <th width="15%">Emp_Name</th>
                            <th width="20%">Emp_Email</th>
                            <th width="15%">Emp_Designation</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1; // Initialize row number
                        while ($result = mysqli_fetch_assoc($data)) {
                            echo "<tr style='height:40px;'>
                                <td>" . $no . "</td>
                                <td>" . $result['emp_id'] . "</td>
                                <td>
                                    <img src='" . $result['uploadfile'] . "' alt='Emp_Photo' style='width: 50px; height: 50px;'>
                                </td>
                                <td>" . $result['emp_name'] . "</td>
                                <td>" . $result['email'] . "</td>
                                <td>" . $result['designation'] . "</td>
                                <td class='button'>
                                    <a href='update.php?id=" . $result['id'] . "&photo=" . $result['uploadfile'] . "&na=" . $result['emp_name'] . "&em=" . $result['email'] . "&deg=" . $result['designation'] . "' style='background-color:#09ada8;'><i class='fa fa-edit'></i></a>
                                    <a href='delete.php?id=" . $result['id'] . "&photo=" . $result['uploadfile'] . "&na=" . $result['emp_name'] . "&em=" . $result['email'] . "&deg=" . $result['designation'] . "' style='background-color:#ed112e;margin-left:20px;' onclick='return sam()'><i class='fa fa-trash'></i></a>
                                    <a href='View.php?id=" . $result['id'] . "&uploadfile=" . $result['uploadfile'] . "&na=" . $result['emp_name'] . "&em=" . $result['email'] . "&deg=" . $result['designation'] . "'><i class='fa fa-eye'></i></a>
                                </td>
                            </tr>";
                            $no++; // Increment row number
                        }
                        if ($no == 1) {
                            echo "<tr><td colspan='7'>No records found</td></tr>";
                        }
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