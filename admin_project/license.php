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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sourcecode-Admin Dashboard</title>

    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />

    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />        
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

    <!-- Your custom styles if needed -->
    <style>
        .card {
            margin: 20px 0;
        }
    </style>

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
    include "include/header_ad.php";
?>

<main class="mt-5 pt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="card">
                    <div class="card-body">
                    <h1 class="text-center"><strong>License</strong></h1><hr>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="text-bold text-dark mt-3">What You Are <span class="text-success">Allowed</span> To Do With HRM-Software..?</h4>
                        <ul>
                        <li><b>Employee Data Management:</b> You are allowed to use the software to store and manage employee information, such as personal details, contact information, job history, etc.</li>

                        <li><b>Payroll Processing:</b> Many HRM software solutions allow you to process payroll, including calculating wages, taxes, and generating payslips.</li>

                        <li><b>Time and Attendance Tracking:</b> You can use the software to track employee working hours, attendance, and related data.</li>

                        <li><b>Performance Management:</b> HRM software often includes features for performance evaluations, goal setting, and tracking employee performance.</li>

                        <li><b>Recruitment:</b> You can utilize the software for managing the recruitment process, including posting job vacancies, receiving applications, and managing candidate information.</li>

                        <li><b>Compliance:</b> HRM software may assist you in ensuring compliance with labor laws and regulations.<li>

                        <li><b>Reporting and Analytics:</b> You are typically allowed to use the reporting and analytics features to gather insights into HR metrics and make informed decisions.</li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="text-bold text-dark mt-3">What You Are <span class="text-danger">Not Allowed</span> To Do With HRM-Software..?</h4>
                       <li> Unauthorized Access or Use: You are not allowed to access or use the HRM software in any way that is not explicitly permitted by the terms of the agreement.</li>

                       <li> Reverse Engineering: You may not reverse engineer, decompile, or disassemble the HRM software. This means you cannot attempt to derive the source code, structure, or algorithms used in the software.</li>

                       <li> Distribution or Resale: You are typically not allowed to distribute, sell, sublicense, or otherwise transfer the HRM software or any rights associated with it without the explicit permission of the software provider.</li>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="text-bold text-dark mt-3">What You <span class="text-warning">Must</span> Do When Using HRM-Software..?</h4>
                        <ul>
                            <li>Include the license notice in all copies of the work.</li>
                        </ul>
                    </div>
                </div>

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
