<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];
if (!$userprofile) {
    header('location: login_user.php');
    exit(); 
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    
    $query = "SELECT * FROM new_task WHERE id = '$task_id'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $file_path = $row['upload'];
      //  $task_name = $row['task_name'];
        // Add more fields as needed
    } else {
        echo "Error fetching task information from the database.";
        exit(); 
    }
} else {
    echo "Task ID not provided in the URL.";
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SourceCode User Dashboard</title>

    <!-- Bootstrap CSS CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />
</head>
<body>
    <?php include "include/header_us.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <img src="<?php echo $file_path; ?>" alt="File Image" class="img-fluid" style="max-height: 400px; width: 100%; margin-top: 5%;">

                <div class="mt-3">
                    <!-- <h2><?php //echo $task_name; ?></h2> -->
                    <!-- Display other task information as needed -->
                    <!-- <p>Task ID: <?php //echo $task_id; ?></p> -->
                    <!-- Add more fields as needed -->
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <a href="javascript:history.go(-1);" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
