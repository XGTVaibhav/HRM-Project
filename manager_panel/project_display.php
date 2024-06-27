<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in
if (!$userprofile) {
    header('location:login_manager.php');
}

// Update the last activity time in the session
$_SESSION['last_activity'] = time();

// Check if the user has been inactive for more than 1 minute
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    // Destroy the session and redirect to the login page
    session_unset();
    session_destroy();
    header('location:login_manager.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

    <title>SourceCode Manager Dashboard</title>
</head>

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


<body>



  <?php
    include "include/header_mg.php";
  ?>


<main class="mt-5 pt-3">
    <div class="container-fluid rkdisplay">
        <h2 align="center"><b>Project List</b></h2>
        <table id="example" class="table table-striped table-responsive" style="width:100%">
            <thead class="bg-info text-white">
                <tr>
                    <th width="3%">Sr_No</th>
                    <th width="5%">Emp_id</th>
                    <th width="10%">Emp_Name</th>
                    <th width="10%">Project_Name</th>
                    <th width="10%">Project_Description</th>
                    <th width="5%">Start_Date</th>
                    <th width="5%">End_Date</th>
                    <th width="5%">Manager</th>
                    <th width="20%">Team_Members</th>
                    <th width="2%">Team_Size</th>
                    <th width="5%">Meeting_Link</th>
                    <th width="5%">Status</th>

                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                include("db.php");
                $id = $_SESSION['$user_name'];
                $query = "SELECT * FROM `new_project` WHERE project_manager='$id' ORDER BY id DESC";

                $data = mysqli_query($conn, $query);

                $total = mysqli_num_rows($data);

                if ($total != 0) {
                    include "include/header_mg.php";
                    $rowNumber = 0; // Initialize the row number counter

                    while ($result = mysqli_fetch_assoc($data)) {
                        $rowNumber++; // Increment the row number

                        echo "<tr>
                            <td>" . $rowNumber . "</td>
                            <td>" . $result['emp_id'] .  "</td>
                            <td>" . $result['emp_name'] . "</td>
                            <td>" . $result['project_name'] . "</td>
                            <td>" . $result['description'] . "</td>
                            <td scope='col'>" . date('d/m/Y', strtotime($result['start_date'])) . "</td>
                            <td scope='col'>" . date('d/m/Y', strtotime($result['end_date'])) . "</td>
                            <td>" . $result['project_manager'] . "</td>
                            <td>" . $result['members'] .  "</td>            
                            <td>" . $result['team_size'] . "</td>
                            <td><a href='" . $result['links'] . "' target='_blank'>" . $result['links'] . "</a></td>
                            <td>" . $result['status'] . "</td>
                            <td>
                                <a class='btn text-white btn-info mb-2' style='font-size: 14px;' href='project_update.php?id=$result[id]'><i class='fa fa-edit'></i></a>
                                <a class='btn text-white btn-danger mb-2' style='font-size: 14px;' href='project_delete.php?id=$result[id]'><i class='fa fa-trash'></i></a>
                                <a class='btn text-white btn-success' style='font-size: 14px;' href='project_displays.php?id=$result[id]'><i class='fa fa-eye'></i></a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>


    
            <div>
                <footer class="text-black text-center py-2" style="margin-right:22%;">
            
                <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
                </footer>
            </div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
  <script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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