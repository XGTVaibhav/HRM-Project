<?php
session_start();

include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in
if (!$userprofile) {
    header('location:login_manager.php');
}

// Update the last activity time in the session
$_SESSION['last_activity'] = time();

// Check if the user has been inactive for more than 1 minute
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    // Destroy the session and redirect to the login page
    session_unset();
    session_destroy();
    header('location:login_manager.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style_admin.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  
    <script src="sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="stylezzz.css">
   <style>
    .error{
      color: red;
    }

    ::placeholder{
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
<title>Sourcecode-Manager Dashboard</title>
</head>

<body>


  <?php
    include "include/header_mg.php";
    ?>

  <main class="mt-5 pt-3">

 
    <div class="container">
    <h2><b>New Ticket</b></h2>
        <div class="rkform">
        <form class="row g-3 ms-2 me-2" method="POST" enctype="multipart/form-data" id="taskForm" novalidate>        <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Employee ID<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="employeeid" name="emp_id" placeholder="Enter Employee-Id" oninput="fetchEmployeeDetails(this.value, true)">
                    <div class="error" id="emp_idError"></div>
                </div>

                <div class="col-md-6">
                    <label for="project_name" class="form-label">Employee Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="employeename" name="emp_name" placeholder="Enter Employee Name" oninput="fetchEmployeeDetails(this.value, false)">
                    <div class="error" id="employee_nameError"></div>
                </div>

    <div class="col-md-6">
        <label for="project_name" class="form-label">Project Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
        <select class="form-control" id="project_name" name="project_name">
            <option value="">Select a project</option>
            <?php
            $i = 1;
            $query_show = mysqli_query($conn, "SELECT * FROM new_project ORDER BY project_name ASC");
            while ($show = mysqli_fetch_array($query_show)) {
            ?>
                <option value="<?php echo $show['project_name']; ?>"><?php echo $show['project_name']; ?></option>
            <?php
            $i++;
            }
            ?>
        </select>
        <div class="error" id="project_nameError"></div>
    </div>
    <div class="col-md-6">
        <label for="description" class="form-label">Project Description<span class="text-danger" style="font-size: 1.2em;">*</span></label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Enter your project description">
        <div class="error" id="descriptionError"></div>
    </div>
    <div class="col-md-6">
        <label for="a_task" class="form-label">Assign Ticket<span class="text-danger" style="font-size: 1.2em;">*</span></label>
        <input type="text" class="form-control" id="a_task" name="a_task" placeholder="Enter your Assign Ticket">
        <div class="error" id="a_taskError"></div>
    </div>

    <div class="col-md-6">
                    <label for="project_manager" class="">Project Manager<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <select class="form-control" id="project_manager" name="project_manager" >
                    <option value="">Select</option>
                    <?php
                        $i = 1;
                        $query_show = mysqli_query($conn, "SELECT emp_id, emp_name, designation FROM add_employe WHERE designation = 'Manager' ORDER BY emp_name ASC");

                        while ($show = mysqli_fetch_array($query_show)) {
                        ?>
                            <option value="<?php echo $show['emp_id']; ?>"><?php echo $show['emp_id']; ?> (Name:<?php echo $show['emp_name']; ?>)</option>
                        <?php
                            $i++;
                        }
                        ?>

                    </select>
                    <div class="error" id="project_managerError"></div>
                </div>

                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                    <div class="error" id="start_dateError"></div>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                    <div class="error" id="end_dateError"></div>
                </div>
                <div class="col-md-6">
                <label for="upload" class="form-label">Upload</label>
                <input type="file" class="form-control" id="upload" name="upload" accept="image/*" onchange="validateFileSize(this)">
                <div class="error" id="uploadError"></div>
            </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <select id="status" class="form-control" name="status">
                        <option value="">Select a status</option>
                        <option value="Done">Done</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <div class="error" id="statusError"></div>
                </div>
                <div class="col-12 mb-3">
                    <center><button type="submit" class="btn btn-primary" name="submit">Add Task</button></center>
                </div>
            </form>

        </div>
    </div>
</main>

            <div>
                <footer class="text-black text-center py-2" style="margin-right:22%;">
            
                <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
                </footer>
            </div>

<?php 
if (isset($_POST['submit'])) {
  $e_id=$_POST['emp_id'];
  $e_name=$_POST['emp_name'];
    $p_name=$_POST['project_name'];
    $d_name=$_POST['description'];
    $a_task=$_POST['a_task'];
    $p_manager=$_POST['project_manager'];
    $s_date=$_POST['start_date'];
    $e_date=$_POST['end_date'];
    
    
      

    $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes

    if ($_FILES['upload']['size'] <= $maxFileSize) {
        $filename = $_FILES["upload"]["name"];
      $tempname = $_FILES["upload"]["tmp_name"];
      $folder = "../files&img/" . $filename;
    move_uploaded_file($tempname, $folder);
    echo"<img src='$folder' height='100px' width='100px'>";
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


    $status=$_POST['status'];

    

   $querry= "INSERT INTO `new_task`(`emp_id`, `emp_name`, `project_name`, `description`,`a_task`,`project_manager`,`start_date`, `end_date`,  `upload`, `status`) VALUES ('$e_id','$e_name','$p_name','$d_name','$a_task','$p_manager','$s_date','$e_date',' $folder','$status')";

   $data=mysqli_query($conn,$querry);

   if ($data) {
   
    echo 
    "<script type='text/javascript'>
    Swal.fire({
    title:'Add Details successfully',
    icon:'success',
    showConfirmButton: false,
    timer:2000
    }).then(function() {
    window.location.replace('task_display.php');
    });
    </script>";
   }
   else{
    echo "data Not inserted";
   }
  
}
  ?>
<script>
const taskForm = document.getElementById('taskForm');
const emp_id = document.getElementById('employeeid');
const employee_name = document.getElementById('employeename');
const project_name = document.getElementById('project_name');
const description = document.getElementById('description');
const a_task = document.getElementById('a_task');
const start_date = document.getElementById('start_date');
const end_date = document.getElementById('end_date');
const status = document.getElementById('status');

taskForm.addEventListener('submit', function (e) {
    let isValid = true;

    // Reset error messages
    resetErrors();

    if (emp_id.value.trim() === '') {
        setError('emp_idError', 'Employee ID is required.');
        isValid = false;
    }

    if (employee_name.value.trim() === '') {
        setError('employee_nameError', 'Employee Name is required.');
        isValid = false;
    }

    if (project_name.value === '') {
        setError('project_nameError', 'Project Name is required.');
        isValid = false;
    }

    if (description.value.trim() === '') {
        setError('descriptionError', 'Project Description is required.');
        isValid = false;
    }

    if (a_task.value.trim() === '') {
        setError('a_taskError', 'Assign Task is required.');
        isValid = false;
    }

    if (start_date.value.trim() === '') {
        setError('start_dateError', 'Start Date is required.');
        isValid = false;
    }

    if (end_date.value.trim() === '') {
        setError('end_dateError', 'End Date is required.');
        isValid = false;
    }

    if (status.value === '') {
        setError('statusError', 'Status is required.');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault(); // Prevent form submission if validation fails
    }
});

function setError(id, message) {
    const errorElement = document.getElementById(id);
    errorElement.innerText = message;
}

function resetErrors() {
    setError('emp_idError', '');
    setError('employee_nameError', '');
    setError('project_nameError', '');
    setError('descriptionError', '');
    setError('a_taskError', '');
    setError('start_dateError', '');
    setError('end_dateError', '');
    setError('statusError', '');
}
</script>




<script>
    // Get the Start Date and End Date input elements
    var startDateInput = document.getElementById("start_date");
    var endDateInput = document.getElementById("end_date");

    // Calculate the minimum date (yesterday)
    var today = new Date();
    today.setDate(today.getDate() - 1); // Set the date to yesterday

    // Format the minimum date as "YYYY-MM-DD"
    var minDate = today.toISOString().split("T")[0];

    // Set the minimum date for both inputs
    startDateInput.min = minDate;
    endDateInput.min = minDate;

    // Add an event listener to validate the selected dates
    startDateInput.addEventListener("change", function () {
        var selectedStartDate = new Date(startDateInput.value);
        var selectedEndDate = new Date(endDateInput.value);

        // Check if the selected start date is before or equal to yesterday
        if (selectedStartDate <= today) {
            document.getElementById("start_dateError").innerText = "Start Date cannot be today or in the past.";
            startDateInput.value = ""; // Clear the input field
        } else {
            document.getElementById("start_dateError").innerText = "";
        }

        // Check if the selected end date is earlier than the start date
        if (selectedEndDate < selectedStartDate) {
            document.getElementById("end_dateError").innerText = "End Date cannot be earlier than Start Date.";
            endDateInput.value = ""; // Clear the input field
        } else {
            document.getElementById("end_dateError").innerText = "";
        }
    });

    endDateInput.addEventListener("change", function () {
        var selectedStartDate = new Date(startDateInput.value);
        var selectedEndDate = new Date(endDateInput.value);

        // Check if the selected end date is earlier than the start date
        if (selectedEndDate < selectedStartDate) {
            document.getElementById("end_dateError").innerText = "End Date cannot be earlier than Start Date.";
            endDateInput.value = ""; // Clear the input field
        } else {
            document.getElementById("end_dateError").innerText = "";
        }
    });
</script>


<script>
    // Get references to the dropdown and search box
    var dropdown = document.getElementById("project_name");
    var searchBox = document.getElementById("searchBox");

    // Add an event listener to the dropdown
    dropdown.addEventListener("change", function() {
        // Get the selected option from the dropdown
        var selectedOption = dropdown.options[dropdown.selectedIndex];

        // Update the search box with the selected option's value
        searchBox.value = selectedOption.value;
    });
    </script>

<script>
function fetchEmployeeDetails(input, isId) {
    const targetInput = isId ? "#employeename" : "#employeeid";
    const errorElementId = isId ? "employee_nameError" : "emp_idError";

    const requestData = isId ? { employeeId: input } : { employeeName: input };

    $.ajax({
        url: 'fetch_employee_details.php',
        method: 'POST',
        data: requestData,
        success: function (response) {
            if (response === "Employee not found") {
                displayError(errorElementId, 'Employee not found');
            } else {
                $(targetInput).val(response);
                clearError(errorElementId);
            }
        },
        error: function () {
            displayError(errorElementId, 'Failed to fetch employee details.');
        }
    });
}
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Popper.js and Bootstrap JS Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>
  <script src="./js/dataTables.bootstrap5.min.js"></script>
  <script src="./js/script.js"></script>
  <script>
function validateFileSize(input) {
    var maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

    if (input.files.length > 0) {
        var fileSize = input.files[0].size;

        if (fileSize > maxFileSize) {
            document.getElementById("uploadError").innerHTML = "File size exceeds 5MB. Please choose a smaller file.";
            input.value = ""; // Clear the input field
        } else {
            document.getElementById("uploadError").innerHTML = "";
        }
    }
}
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