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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="stylezzz.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

<title>SourceCode User Dashboard</title>
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
 
 marquee{
    font-size:20px;
    color:red;
 }
 a{
    text-decoration:none;
    color:black;
 }
 .card a{
    text-decoration: none;
    color: black;
 }
 .card-body{
    background-color:  #e4e8e3;
 }

 #bell-icon i{
    color: red;
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
   max-height: 150px;/* Adjust as needed */
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
    include "include/header_us.php";
    ?>

    <!-- navigation & offcanvas ends -->

   

    <main class="mt-5 pt-3 ">

    <marquee direction="left" behavior="scroll" scrollamount="5">
    <?php
    // Connect to your MySQL database
    $conn = new mysqli("localhost", "root", "", "db_hrmsoftwere");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch notices from the database
    $sql = "SELECT * FROM emp_notice";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo 	'<span id="bell-icon" style="color: black;"><i class="fa-regular fa-hand-point-right" style="color: #db1a2e;"></i>&nbsp;&nbsp;&nbsp; </span>'   . $row["emp_notice"] .'&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp  &nbsp;&nbsp;&nbsp  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp  &nbsp;&nbsp;&nbsp  &nbsp;&nbsp;&nbsp';
        }
    }

    // Close the database connection
    $conn->close();
    ?>

</marquee>
      <div class="container-fluid" class="time">
      <div id="datetime" ></div>
      </div>  
    
        <div class="container-fluid  sam1">
            <div >
                <h4 class="text-white py-2" ><b>SOURCECODE SOFTWARE PVT.LTD </b></h4>
            </div>



            <div class="row sam-1">
            <div class="col-md-3 ">
                    <div class="card  border border-dark text-dark box-color h-100">
                        <a href="pro_view.php">
                    <div class="card-body py-2">
                    <img src="../images/img-6.jpeg" alt="Employee Image" class="card-image">
                    <?php
                           require 'db.php';
                            
                           $id = $_SESSION['$user_name'];
                        //    $query = "SELECT * FROM new_project WHERE emp_id = '$id'";
                $query  = "SELECT * FROM new_project WHERE status = 'Pending' && emp_id = '$id' ";

                           $query_show = mysqli_query($conn, $query);
                           $total=mysqli_num_rows($query_show);
                           
                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h3>Total Project</h3>
                        </div>
                        
                    </div>
                    </a>
                </div>
                <div class="col-md-3 ">
                    <div class="card  border border-dark text-dark box-color h-80">
                    <a href="task_view.php">
                        <div class="card-body py-2">
                        <img src="../images/img-3.jpeg" alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                            
                           $id = $_SESSION['$user_name'];
                        //    $query = "SELECT * FROM new_task WHERE emp_id = '$id'";
                $query  = "SELECT * FROM new_task WHERE status = 'Pending' && emp_id = '$id' ";

                           $query_show = mysqli_query($conn, $query);
                           $total=mysqli_num_rows($query_show);
                           
                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h4>Pending Ticket</h4>
                        </div>
                        
                    </div>
</a>
                </div>
                <div class="col-md-3 ">
                    <div class="card border border-dark text-dark box-color h-60">
                    <a href="show_timeshit.php">
                        <div class="card-body py-2">
                            
                        <img src="../images/img-2.jpeg" alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                           $query ="SELECT id FROM timesheet ORDER BY id";
                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h4>TimeSheet</h4>
                        </div>
                        
                    </div>
</a>
                </div>
                
                <div class="col-md-3 ">
                    <div class="card  border border-dark text-dark box-color h-60">
                    <a href="emp_notice.php">
                        <div class="card-body py-2">
                            
                        <img src="../images/img-7.jpeg" alt="Employee Image" class="card-image">
                        <?php
                           require 'db.php';
                           $query ="SELECT id FROM emp_notice ORDER BY id";
                           $query_run = mysqli_query($conn,$query);
                            
                           $row = mysqli_num_rows($query_run);

                           echo '<h1>' .$row.'</h1>'
                           ?>
                            <h4>Notice</h4>
                        </div>
                       
                    </div>
                    </a>
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