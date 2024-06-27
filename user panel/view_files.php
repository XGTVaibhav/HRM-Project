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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    header("Location: view_files.php?id=$task_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SourceCode User Dashboard</title>

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
</head>
<body>
    <?php include "include/header_us.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <img src="<?php echo $file_path; ?>" alt="File Image" class="img-fluid" style="max-height: 400px; width: 100%; margin-top: 5%;">

                <form action="update_image.php?id=<?php echo $task_id; ?>" method="post" enctype="multipart/form-data" class="mt-3" id="updateForm" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="new_image" class="form-label"><b>Choose New Image:-</b></label>
                        <input type="file" class="form-control" id="new_image" name="new_image" accept="image/*" required>
                        <small class="text-danger" id="imageError" style="display: none;">Please choose a new image.</small>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <input type="submit" name="update" value="Update" class="btn btn-primary">
                        <div class="ms-2"></div> 
                        <a href="javascript:history.go(-1);" class="btn btn-secondary">Back</a>
                    </div>
                </form>



            </div>
        </div>
    </div>

    <script>
        document.getElementById('updateForm').addEventListener('submit', function () {
            // Add a delay to ensure the form is submitted before redirecting
            setTimeout(function () {
                window.location.href = 'task_view.php?id=<?php echo $task_id; ?>';
            }, 100);
        });
    </script>
    <script>
    function validateForm() {
        var newImage = document.getElementById('new_image');

        // Check if a file is selected
        if (newImage.files.length === 0) {
            document.getElementById('imageError').style.display = 'block';
            return false; // Prevent form submission
        } else {
            document.getElementById('imageError').style.display = 'none';
            return true; // Allow form submission
        }
    }
</script>
</body>
</html>
