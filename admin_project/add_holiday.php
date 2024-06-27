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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="stylezzz.css">
    <title>Sourcecode-Admin Dashboard</title>

  <style>
    .error {
        color: red;
    }

   ::placeholder {
        font-size: 14px; 
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

  <?php
    include "include/header_ad.php";
    ?>

<main class="mt-5 pt-3">
<div class="container">
    <h2><b>Add Holiday</b></h2>
    <hr>
    <form action="#" method="POST" id="holidayForm" novalidate>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="fromDate">From Date:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <input type="date" class="form-control" id="fromDate" name="from_date" placeholder="Select from date" required>
                <div class="error" id="from_date_error"></div>
            </div>

            <div class="form-group col-md-6">
                <label for="toDate">To Date:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <input type="date" class="form-control" id="toDate" name="to_date" placeholder="Select to date" required>
                <div class="error" id="to_date_error"></div>
            </div>
        </div>

        <div class="form-group col-md-14">
            <label for="eventDescription">Description:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
            <textarea class="form-control" id="eventDescription" name="holiday_name" placeholder="Enter description" required></textarea>
            <div class="error" id="holiday_name_error"></div>
        </div>

        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</main>

<div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
   
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>


<script>
    document.getElementById("holidayForm").addEventListener("submit", function (event) {
        // Check required fields and display error messages
        const from_date = document.getElementById("fromDate");
        const to_date = document.getElementById("toDate");
        const holiday_name = document.getElementById("eventDescription");

        if (!from_date.value) {
            displayError("from_date_error", "Please select From Date.");
            event.preventDefault();
        } else {
            clearError("from_date_error");
        }

        if (!to_date.value) {
            displayError("to_date_error", "Please select To Date.");
            event.preventDefault();
        } else {
            clearError("to_date_error");
        }

        if (!holiday_name.value) {
            displayError("holiday_name_error", "Description is required.");
            event.preventDefault();
        } else {
            clearError("holiday_name_error");
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

    // Add validation to prevent selecting past dates
    const today = new Date().toISOString().split("T")[0]; // Get today's date in yyyy-mm-dd format
    document.getElementById("fromDate").setAttribute("min", today);
    document.getElementById("toDate").setAttribute("min", today);

</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    // error_reporting(0);
// Check if the form is submitted
if (isset($_POST['submit'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $holiday_name = $_POST['holiday_name'];

    // Check if the entry already exists
    $checkQuery = "SELECT * FROM `add_holiday` WHERE `from_date` = '$from_date' AND `to_date` = '$to_date'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Entry already exists, show an error message
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Entry',
                text: 'A holiday with the same dates already exists.',
            });
        </script>";
    } else {
        // Entry does not exist, proceed to insert into the database
        $sql = "INSERT INTO `add_holiday` (`from_date`, `to_date`, `holiday_name`) VALUES ('$from_date', '$to_date', '$holiday_name')";
        $data = mysqli_query($conn, $sql);

        if ($data) {
            // Show a success SweetAlert and redirect
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Holiday added Successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'manage_holiday.php';
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
}
?>
