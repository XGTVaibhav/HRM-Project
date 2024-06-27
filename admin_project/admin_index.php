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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

    <title>Sourcecode-Admin Dashboard</title>
    <style>
      
       #datetime{
        text-align: right;
        font-size: 22px;
        font-weight: bold;
       }
        .sam1{
        position: relative;
       height: 200px;
        background-color:#5c2280;
    }
 .box-color{
    background-color: #e4e8e3;
 }
 .card a{
    text-decoration: none;
    color: black;
 }
 
 .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        background-color: #f5e1f9; /* Light purple background */
        border: 2px solid #c8a2c8; /* Darker purple border */
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-body {
        text-align: center;
    }

    .card a {
        text-decoration: none;
        color: #333; /* Dark text color */
    }

    .card h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: #6a0572; /* Dark purple heading color */
    }

    .card h3 {
        font-size: 1.5rem;
        color: #4a0360; /* Slightly lighter purple text color */
    }

    .card-image {
   max-width: 100%; /* Adjust as needed */
   max-height: 50%;/* Adjust as needed */
   object-fit: cover; /* Ensures the image covers the entire space */
   border-radius: 16px; /* Match the card's border-radius */
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

    <!-- navigation & offcanvas starts -->

    <?php
    include "include/header_ad.php";
    ?>

    <!-- navigation & offcanvas ends -->


    <main class="mt-5 pt-3 ">
      <div class="container-fluid" class="time">
      <div id="datetime" ></div>
      </div>  
    
        <div class="container-fluid  sam1">
            <div >
                <h4 class="text-white py-2" ><b>SOURCECODE SOFTWARE PVT.LTD</b></h4>
            </div>



            <div class="row sam-1">
                <div class="col-md-3 ">
                    <div class="card  border border-dark text-dark box-color h-100">
                       <a href="display.php">
                        <div class="card-body py-2">
                            <!-- Total employee -->

                            <img src="../images/img-4.jpeg" alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                           $query ="SELECT id FROM add_employe ORDER BY id";
                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h3>Total Employees</h3>
                        </div>
                       
                    </div>
                    </a>
                </div>
                <div class="col-md-3 ">
                    <div class="card  border border-dark text-dark box-color h-100">
                        <a href="pro_display.php">
                    <div class="card-body py-2">

                    
                    <img src="../images/img-6.jpeg" alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                        //    $query ="SELECT id FROM new_project ORDER BY id";
                $query  = "SELECT * FROM new_project WHERE status = 'Pending' ";

                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h3>Total Projects</h3>
                        </div>
                        
                    </div>
                    </a>
                </div>
                <div class="col-md-3 ">
                    <div class="card border border-dark text-dark box-color h-100">
                      <a href="task_display.php">
                    <div class="card-body py-2">
                    <img src="../images/img-3.jpeg" alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                        //    $query ="SELECT id FROM new_task ORDER BY id";
                      

                $query  = "SELECT * FROM new_task WHERE status = 'Pending' ";

                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h3>Total Tickets</h3>
                        </div>
                        
                    </div>
</a>
                </div>
                <div class="col-md-3 ">

                    <div class="card  border border-dark text-dark box-color h-100">
                        <a href="manage_query.php">
                        <div class="card-body py-2">

                        <img src="../images/img-5.jpeg"  alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                        //    $query ="SELECT id FROM add_query ORDER BY id";
                $query  = "SELECT * FROM add_query WHERE status = 'Pending' ";

                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h3>New Queries</h3>
                        </div>
                        </a>
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

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <script>
        function updateDateTime() {
            // Get the current date and time
            const now = new Date();

            // Format the date and time
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                // timeZoneName: 'short'
            };

            const formattedDateTime = now.toLocaleDateString('en-US', options);

            // Update the HTML element with the formatted date and time
            document.getElementById('datetime').textContent = formattedDateTime;
        }

        // Update the date and time initially
        updateDateTime();

        // Update the date and time every second (1000 milliseconds)
        setInterval(updateDateTime, 1000);
    </script>

<!-- Force Logout -->
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