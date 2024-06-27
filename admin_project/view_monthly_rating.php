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

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
	
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="stylezzz.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />

	
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


	
</head>
<style type="text/css">
        /* Your internal CSS styles go here */
       
    /* Your internal CSS styles go here */
    body {
        background-color: #f0f0f0;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    h1 {
        color: #333;
        text-align: center;
    }

    p {
        font-size: 18px;
        line-height: 1.5;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* CSS for the table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ccc;
    }

    th, td {
        padding: 10px;
        text-align: left;
        
    }

    th {
        background-color: #f2f2f2;
        font-weight: 900;
    }

    

    /* tr:nth-child(even) {
        background-color: #f5f5f5;
    } */


    </style>
<body>
    
<?php
    include "include/header_ad.php";
    ?>

<main class="mt-5 pt-4"> 
	<div class="container">
<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_admin";
error_reporting(0);

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Process form data
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $employee_id = $_GET["employee_id"];
   
    $month = $_GET["date"];
    
    
    // Query to retrieve monthly attendance
    $sql = "SELECT date,name,dept,shift, status FROM rating WHERE employee_id = '$employee_id' AND DATE_FORMAT(date, '%Y-%m') = '$month'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<h2>Monthly Rating</h2>";
        echo "<h2>Employee ID: $employee_id</h2>";
       echo "<table border='1'>";
        echo "<tr>
        <th>Year/Month/Day</th>
        <th>Name</th>
        <th>Department</th>
        <th>Shift</th>
        <th>Rating</th>
       
        </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["dept"] . "</td>";
            echo "<td>" . $row["shift"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            
            // echo "<td><a href='performance_form.php?id=" . $row["id"] . "'><i class='bi bi-pencil'></i></a></td>";
             //echo "<td><a href='deleteperformance.php?id=" . $row["id"] . "'><i class='bi bi-trash'></i></a></td>";
        
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No rating records found for this employee in the selected month.";
    }
}

// Close the database connection
$conn->close();
?>
 </div>
</main>
</body>

</html>