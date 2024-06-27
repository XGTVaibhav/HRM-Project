<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];
if (!$userprofile) {
    header('location: login_admin.php');
    exit();
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Fetch the file path from the database based on the task ID
    $query = "SELECT upload FROM new_task WHERE id = '$task_id'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $file_path = $row['upload'];
    } else {
        echo "Error fetching file path from the database.";
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
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sourcecode-Admin Dashboard</title>

    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

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


    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />        
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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
<body>
    <?php include "include/header_ad.php"; ?>
<main>
    <div class="container text-center mt-5">
        <img src="<?php echo $file_path; ?>" alt="File Image" class="img-fluid" style="max-height: 400px; width: 80%; margin-top: 5%; padding-left: 10%;">
    </div>

    <div class="d-flex justify-content-center mt-3">
        <a href="javascript:history.go(-1);" class="btn btn-secondary">Back</a>
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
