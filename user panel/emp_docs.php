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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="style_admin.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    
    <!-- SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <!-- jQuery JavaScript library -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    
    <!-- DataTables JavaScript libraries -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    
    <!-- Bootstrap 4.5.0 JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>SourceCode User Dashboard</title>
    <style>
        .form-control::placeholder {
            font-size: 14px;
        }

        

        img {
            width: 150px;
            height: 150px;
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
    <?php
    include "db.php";
    $query = "SELECT * FROM emp_docs ORDER BY id DESC";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);
    if ($total != 0) {
    ?>
    <?php include "include/header_us.php"; ?>
    
    
    <?php
    include "db.php";
    $query = "SELECT * FROM emp_docs WHERE emp_id = '$id' ORDER BY id DESC";
    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);

    if ($total != 0) {
    ?>
    <?php
    include "include/header_us.php";
    ?>
    <main class="mt-5 pt-3">
        <div class="container-fluid ">
            <h2 style="text-align: center;" ><b>Manage Employee Document's</b></h2>
                <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                    <th style="width: 10%;">Emp_ID</th>             
                    <th style="width: 15%;">Adhaar Card</th>
                    <th style="width: 15%;">Pan Card</th>
                    <th style="width: 15%;">Graduation Certificate</th>
                    <th style="width: 15%;">10th Certificate</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    $no = 1;
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                       
                        <td>" . $result['emp_id'] . "</td>
                      
                        <td > 
                              <img src=".$result['myfile']." >
                        </td>

                        <td > 
                              <img src=".$result['myfile1']." >
                        </td>

                        <td > 
                              <img src=".$result['myfile2']." >
                        </td>

                        <td > 
                              <img src=".$result['myfile3']." >
                        </td>

                       
                        </tr>";
                        $no++;
                    }}
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

<?php
        $no = 1;
        while ($result = mysqli_fetch_assoc($data)) {
            echo "<form action='#?id=" . $result['id'] . "'>
        <div class='row mb-3'>
            <div class='col-md-6'>
                <div class='d-flex'>
                    <label for='adhaarcard'  style='width: 200px;'><b>Adhaar Card:</b></label>
                    <img src='" . $result['myfile'] . "' style='max-width: 150px; max-height: 150px;'>
                </div>
            </div>
        
            <div class='col-md-6'>
                <div class='d-flex'>
                    <label for='pancard'  style='width: 200px;'><b>Pan Card:</b></label>
                    <img src='" . $result['myfile1'] . "' style='max-width: 150px; max-height: 150px;'>
                </div>
            </div>
        </div>

        <div class='row mb-3'>
            <div class='col-md-6'>
                <div class='d-flex'>
                    <label for='graduationcer'  style='width: 200px;'><b>Graduation Certificate:</b></label>
                    <img src='" . $result['myfile2'] . "' style='max-width: 150px; max-height: 150px;'>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='d-flex'>
                    <label for='10thcer' style='width: 200px;'><b>10th Certificate:</b></label>
                    <img src='" . $result['myfile3'] . "' style='max-width: 150px; max-height: 150px;'>
                </div>
            </div>
        </div>
        
            </form>";
            $no++;
        }}
?>



<?php
    include "db.php";
    if (isset($_POST['submit'])) {
        $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
        $emp_name = mysqli_real_escape_string($conn, $_POST['emp_name']);
        $filename = $_FILES["myfile"]["name"];
        $tempname = $_FILES["myfile"]["tmp_name"];
        $folder = "../files&img/" . $filename;
        move_uploaded_file($tempname, $folder);
        $filename = $_FILES["myfile1"]["name"];
        $tempname = $_FILES["myfile1"]["tmp_name"];
        $folder1 = "../files&img/" . $filename;
        move_uploaded_file($tempname, $folder1);
        $filename = $_FILES["myfile2"]["name"];
        $tempname = $_FILES["myfile2"]["tmp_name"];
        $folder2 = "../files&img/" . $filename;
        move_uploaded_file($tempname, $folder2);
        $filename = $_FILES["myfile3"]["name"];
        $tempname = $_FILES["myfile3"]["tmp_name"];
        $folder3 = "../files&img//" . $filename;
        move_uploaded_file($tempname, $folder3);
        $sql = "INSERT INTO `emp_docs`(`emp_id`,`emp_name`,`myfile`,`myfile1`,`myfile2`,`myfile3`) VALUES ('$emp_id','$emp_name','$folder','$folder1','$folder2','$folder3')";
        $data = mysqli_query($conn, $sql);
        if ($data) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Record Inserted Successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'emp_documents.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Data not inserted',
                    text: 'Something went wrong!',
                });
            </script>";
        }
    }
?>

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