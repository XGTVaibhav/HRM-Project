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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          
      
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="style_admin.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
   
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="stylezzz.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title>SourceCode Admin Dashboard</title>
   
</head>
<style>
  .form-control::placeholder {
    font-size: 14px;
  }

  .error {
    color: red;
  }

  img {
    width: 100px;
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
    include "include/header_ad.php";
    ?>

<main class="mt-5 pt-3">
        <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data" id="noticeForm" novalidate>
            <h2><b>Employee Notice</b></h2><hr>
            <div class="form-row">
               <div class="form-group col-md-6">
                    <label>Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" id="dateInput" placeholder="First Name"  name="date" value="<?php echo isset($show['date']) ? $show['date'] : ''; ?>" required>
                    <div class="error" id="fromdate_error"></div>
                </div>

                <div class="form-group col-md-6">
                    <label>Subject:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" id="event-description"  class="form-control" id="firstName" placeholder="Enter subject" rows="4" name="subject" required><?php echo isset($show['subject']) ? $show['subject'] : ''; ?></input>
                    <div class="error" id="subject_error"></div>
                </div>

                <div class="form-group col-md-6">
                    <label>Employee File</label><br>
                    <input type="file" id="myfile" class="form-control-file" id="firstName" placeholder="add file" name="myfile">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
                    <div class="error" id="file_error"></div> <!-- 5 MB in bytes -->
                </div>

                <div class="form-group col-md-6">
                    <label>Employee Notice:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text"id="event-description" class="form-control" id="firstName" placeholder="Enter notice" rows="4" name="emp_notice" required><?php echo isset($show['emp_notice']) ? $show['emp_notice'] : ''; ?></input>
                    <div class="error" id="notice_error"></div>
                </div>

                <div class="form-group col-md-12 text-center">
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
           
    </form>
    </div>
</main>

 
<script>
    document.getElementById("noticeForm").addEventListener("submit", function (event) {
        const date = document.getElementsByName("date")[0];
        const subject = document.getElementsByName("subject")[0];
       
        const notice = document.getElementsByName("emp_notice")[0];
        

        if (!date.value) {
            displayError("fromdate_error", "Please select date.");
            event.preventDefault();
        } else {
            clearError("fromdate_error");
        }

        if (!subject.value) {
            displayError("subject_error", "Please enter subject.");
            event.preventDefault();
        } else {
            clearError("subject_error");
        }

        

        if (notice.value === "") {
            displayError("notice_error", "Please enter notice.");
            event.preventDefault();
        } else {
            clearError("notice_error");
        }

        
    });

    function displayError(id, message) {
        const errorElement = document.getElementById(id);
        errorElement.textContent = message;
        errorElement.style.color = "red";
    }

    function clearError(id) {
        const errorElement = document.getElementById(id);
        errorElement.textContent = "";
    }
 </script>

<script>
    const dateInput = document.getElementById('dateInput');
    const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

    // Set the min attribute to today's date
    dateInput.setAttribute('min', today);
</script>


<?php
include "db.php";
$query = "SELECT * FROM emp_notice ORDER BY id DESC";
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);

if ($total != 0) {
    ?>
    <?php
    include "include/header_ad.php";
    ?>
    <main class="mt-5 pt-3">
        <div class="container-fluid ">
           <center> <h2><b>Manage Employee Notice</b></h2></center><hr>
                <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr_No</th>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Emp_File</th>
                        <th>Emp_Notice</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    $no = 1;
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "<tr>
                        <td>" . $no . "</td>
                        <td>" . date('d/m/Y', strtotime($result['date'])) . "</td>
                        <td>" . $result['subject'] . "</td>

                        <td > 
                              <img src=".$result['myfile']." >
                        </td>

                        <td>" . $result['emp_notice'] . "</td>
                        <td>
                        <div class='btn-group'>
                        <a href='emp_updatenotice.php?id=" . $result['id'] . "' class='btn btn-info text-white'><i class='fa fa-edit' style='font-size: 14px;'></i></a>
                        <a href='emp_deletenotice.php?id=" . $result['id'] . "' class='btn btn-danger text-white' style='background-color: #ed112e; margin-left: 20px;'><i class='fa fa-trash' style='font-size: 14px;'></i></a>
                        </div>

                        </td>
                        </tr>";
                        $no++;
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
<?php
}
?>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    


    <script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
    });
    </script>

<script>
    document.getElementById("noticeForm").addEventListener("submit", function (event) {
        const adhar = document.getElementsByName("myfile")[0];
        

        if (adhar.files.length > 0 && adhar.files[0].size > 5 * 1024 * 1024) {
            displayError("file_error", "file size must be less than 5MB.");
            event.preventDefault();
        } else {
            clearError("file_error");
        }

    });

    // Other functions (displayError, clearError) as in your original code.
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

<?php
include "db.php";

if (isset($_POST['submit'])) {
    $fromdate = mysqli_real_escape_string($conn, $_POST['date']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);

    $folder = ""; // Initialize the folder variable

    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {
        $maxFileSize = 5242880; // 5 MB in bytes

        // Check if the uploaded file size is within the limit
        if ($_FILES['myfile']['size'] <= $maxFileSize) {
            $filename = $_FILES["myfile"]["name"];
            $tempname = $_FILES["myfile"]["tmp_name"];
            $folder = "../files&img/" . $filename;

            // Move the uploaded file to the destination folder
            if (move_uploaded_file($tempname, $folder)) {
                // File uploaded successfully
            } else {
                // Error moving the uploaded file
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'File Upload Failed',
                        text: 'There was an issue with file upload.',
                    });
                </script>";
            }
        } else {
            // File size exceeds the limit
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'File Size Exceeds Limit',
                    text: 'Please upload a file up to 5 MB in size.',
                });
            </script>";
        }
    }

    $notice = mysqli_real_escape_string($conn, $_POST['emp_notice']);

    $sql = "INSERT INTO `emp_notice`(`date`, `subject`, `myfile`, `emp_notice`) VALUES ('$fromdate', '$subject', '$folder', '$notice')";

    $data = mysqli_query($conn, $sql);

    if ($data) {
        // Show a success SweetAlert and redirect
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Record Inserted Successfully',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'emp_notice.php';
            });
        </script>";
    } else {
        // Show an error SweetAlert
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