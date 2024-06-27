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
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sourcecode-Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<style>
    h1 {
            font-size: 30px;
            margin-top: 34px;
            margin-bottom: 24px;

        }

        .emp {
            align-items: center;
            justify-content: center;
            border: 2px solid black;
            padding: 10px;
        }

        .emp h1 {
            text-align: center;
            
        }
            
        label {
            font-weight: bold;
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

<body>
    <?php
    include 'connection.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM db_table WHERE id = '$id'";
    $query_show = mysqli_query($conn, $query);
    $show = mysqli_fetch_assoc($query_show);
    ?>

    <?php
    include "header_ad.php";
    ?>

    <main>
        <div class="col-md-6 offset-md-3 mt-5">
            <div class="container emp">

                <h1>Employee Documentation</h1>
                <form action="#" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputID">Employee ID</label>
                        <input type="text" name="emp_id" class="form-control" value="<?php echo $show['emp_id']; ?>"
                            id="exampleInputEmpID" placeholder="Enter your employee id" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Full Name</label>
                        <input type="text" name="emp_name" class="form-control" value="<?php echo $show['emp_name']; ?>"
                            id="exampleInputName" aria-describedby="emailHelp" placeholder="Enter your name" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $show['email']; ?>"
                            id="exampleInputEmail" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputNo">Contact No</label>
                        <input type="tel" name="contact_no" class="form-control" value="<?php echo $show['contact_no']; ?>" id="phonenumber"
                            placeholder="Enter your Contact Number" Required>
                    </div>

                    <hr>
                    <div class="form-group mt-3">
                        <label class="exampleFormControlaFile2 mr-2">Upload your Aadhar Card:</label>
                        <input type="file" class="form-control-file" name="uploadfile" id="exampleFormControlaFile3">
                        <?php echo $show['uploadfile']; ?>
                    </div>

                    <hr>
                    <div class="form-group mt-3">
                        <label class="mr-2">Upload your Pan Card:</label>
                        <input type="file" name="uploadfile1">
                        <?php echo $show['uploadfile1']; ?>
                    </div>


                    <hr>
                    <div class="form-group mt-3">
                        <label class="mr-2">Upload your graduation Certificate:</label>
                        <input type="file" name="uploadfile2">
                        <?php echo $show['uploadfile2']; ?>
                    </div>
                    <hr>

                    <div class="form-group mt-3">
                        <label class="mr-2">Upload your 10th Marksheet:</label>
                        <input type="file" name="uploadfile3">
                        <?php echo $show['uploadfile3']; ?>
                    </div>
                    <hr>

                    <div class="form-group mt-3">
                        <label class="mr-2">Upload your 12th Marksheet:</label>
                        <input type="file" name="uploadfile4">
                        <?php echo $show['uploadfile4']; ?>
                    </div>

                    <hr>
                    <input type="submit" class="btn btn-primary" name="register" value="Back" href="http://localhost/Dashboard%201/display1.php">
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

    if (isset($_POST['register'])) {
        $empname = $_POST['emp_id'];
        $name = $_POST['emp_name'];
        $mail = $_POST['email'];
        $empno = $_POST['contact_no'];
        $filename = $_FILES["uploadfile"]["name"];
        $filename1 = $_FILES["uploadfile1"]["name"];
        $filename2 = $_FILES["uploadfile2"]["name"];
        $filename3 = $_FILES["uploadfile3"]["name"];
        $filename4 = $_FILES["uploadfile4"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $tempname1 = $_FILES["uploadfile1"]["tmp_name"];
        $tempname2 = $_FILES["uploadfile2"]["tmp_name"];
        $tempname3 = $_FILES["uploadfile3"]["tmp_name"];
        $tempname4 = $_FILES["uploadfile4"]["tmp_name"];
        $folder = "images/" . $filename;
        $folder1 = "images/" . $filename1;
        $folder2 = "images/" . $filename2;
        $folder3 = "images/" . $filename3;
        $folder4 = "images/" . $filename4;
        move_uploaded_file($tempname, $folder);
        move_uploaded_file($tempname1, $folder1);
        move_uploaded_file($tempname2, $folder2);
        move_uploaded_file($tempname3, $folder3);
        move_uploaded_file($tempname4, $folder4);

        $query = "UPDATE db_table SET emp_id='$empname', emp_name='$name', email='$mail', contact_no='$empno', uploadfile='$folder', uploadfile1='$folder1', uploadfile2='$folder2', uploadfile3='$folder3', uploadfile4='$folder4' WHERE `id` = '$id'";
        $query_show = mysqli_query($conn, $query);

        if ($query_show) {

            echo "<script type='text/javascript'>
            alert('View Page Dispalyed..');
            </script>";
            ?>
            <meta http-equiv="refresh" content="0; url = http://localhost/Dashboard%201/display1.php" />
            <?php
        } else {
            echo "Unable to Update";
        }
    }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
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