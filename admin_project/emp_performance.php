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

    <!-- Bootstrap CSS CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!-- Bootstrap JS CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />
     <!-- <link rel="stylesheet" href="style1.css"> -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <title>Sourcecode-Admin Dashboard</title>
</head>

    <style>
        .form-control::placeholder
        {
        font-size: 14px;
    }
        .error {
            color: red;
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
    <h2><b>Employee Performance Form</b></h2><hr>

    <form action="#" method="POST" id="validateForm" novalidate>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Employee ID<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <input type="text" class="form-control" id="employeeid" name="emp_id" placeholder="Enter Employee-Id" oninput="fetchEmployeeName(this.value)" >
                <div class="error" id="emp_id_error"></div>
            </div>

            <div class="form-group col-md-6">
                <label>Employee Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <input type="text" name="emp_name" id="employeename" class="form-control" placeholder="Enter employee name" oninput="fetchEmployeeId(this.value)">
                <div class="error" id="emp_name_error"></div>
            </div>

            <div class="form-group col-md-6">
                <label>Date<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <input type="date" class="form-control" id="date" name="date" placeholder="date" required>
                <div class="error" id="date_error"></div>
            </div>

            <div class="form-group col-md-6">
                <label>Department<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select name="dept" class="form-control" required>
                    <option value="" selected disabled>Choose...</option>
                    <option value="Software Engineer">Software Engineer</option>
                    <option value="Software Developer">Software Developer</option>
                    <option value="HR Department">HR Department</option>
                    <option value="Project Manager">Project Manager</option>
                </select>

                <div class="error" id="dept_error"></div>
            </div>

            <div class="form-group col-md-6">
                <label>Shift<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select name="shift" class="form-control" required>
                    <option value="" selected disabled>Choose...</option>
                    <option value="General Shift">General Shift</option>
                    <option value="Day Shift">Day Shift</option>
                    <option value="Night Shift">Night Shift</option>
                </select>

                <div class="error" id="shift_error"></div>
            </div>

            <div class="form-group col-md-6">
                <label>Rating<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                <select name="emp_status" class="form-control" required>
                    <option value="" selected disabled>Choose...</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>

                <div class="error" id="rating_error"></div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</main>

<script>
    document.getElementById("validateForm").addEventListener("submit", function (event) {
        const empId = document.getElementsByName("emp_id")[0];
        const empName = document.getElementsByName("emp_name")[0];
        const date = document.getElementsByName("date")[0];
        const dept = document.getElementsByName("dept")[0];
        const shift = document.getElementsByName("shift")[0];
        const rating = document.getElementsByName("emp_status")[0];

        if (!empId.value) {
            displayError("emp_id_error", "Please enter an Employee ID.");
            event.preventDefault();
        } else {
            clearError("emp_id_error");
        }

        if (!empName.value) {
            displayError("emp_name_error", "Please enter an Employee Name.");
            event.preventDefault();
        } else {
            clearError("emp_name_error");
        }

        if (!date.value) {
            displayError("date_error", "Please select a Date.");
            event.preventDefault();
        } else {
            clearError("date_error");
        }

        if (dept.value === "") {
            displayError("dept_error", "Please select a Department.");
            event.preventDefault();
        } else {
            clearError("dept_error");
        }

        if (shift.value === "") {
            displayError("shift_error", "Please select a Shift.");
            event.preventDefault();
        } else {
            clearError("shift_error");
        }

        if (rating.value === "") {
            displayError("rating_error", "Please select a Rating.");
            event.preventDefault();
        } else {
            clearError("rating_error");
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
    document.getElementById("date").setAttribute("min", today);

</script>

<?php
  include "db.php";

  if (isset($_POST['submit'])) {
      $employee_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
      $date = mysqli_real_escape_string($conn, $_POST['date']);
  
      // Check if a record with the same Employee ID and Date already exists
      $checkQuery = "SELECT * FROM emp_rating WHERE emp_id = '$employee_id' AND date = '$date'";
      $checkResult = mysqli_query($conn, $checkQuery);
  
      if (mysqli_num_rows($checkResult) > 0) {
          // Record already exists, show an error
          echo "<script>
              Swal.fire({
                  icon: 'error',
                  title: 'Duplicate Record',
                  text: 'A record with the same Employee ID and Date already exists.',
              });
          </script>";
      } else {
          // Record doesn't exist, proceed with insertion
          $name = mysqli_real_escape_string($conn, $_POST['emp_name']);
          $dept = mysqli_real_escape_string($conn, $_POST['dept']);
          $shift = mysqli_real_escape_string($conn, $_POST['shift']);
          $status = mysqli_real_escape_string($conn, $_POST['emp_status']);
  
          $sql = "INSERT INTO `emp_rating`(`emp_id`,`emp_name`,`date`,`dept`, `shift`, `emp_status`) VALUES ('$employee_id','$name','$date','$dept','$shift','$status')";
  
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
                      window.location.href = 'emp_performance.php';
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

<?php

$query = "SELECT * FROM emp_rating ORDER BY id DESC";
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);

if ($total != 0) {
?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
      <center>  <h2><b>Manage Monthly Performance</b></h2></center> 
        <hr>
        <div class="table-responsive">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr_No</th>
                        <th>Emp_ID</th>
                        <th>Emp_Name</th>
                        <th>Month/Year</th>
                        <th>Emp_Department</th>
                        <th>Emp_Shift</th>
                        <th>Emp_Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    while ($result = mysqli_fetch_assoc($data)) {

                        echo "<tr>
                            <td>" . $no . "</td>
                            <td>" . $result['emp_id'] . "</td>
                            <td>" . $result['emp_name'] . "</td>
                            <td>" . date('d/m/Y', strtotime($result['date'])) . "</td>
                            <td>" . $result['dept'] . "</td>
                            <td>" . $result['shift'] . "</td>
                            <td>" . $result['emp_status'] . "</td>
                            <td>
                                <div class='btn-group'>
                                    <a href='emp_updateperformance.php?id=" . $result['id'] . "' class='btn btn-info text-white'><i class='fa fa-edit' style='font-size: 14px;'></i></a>
                                    <a href='emp_deleteperformance.php?id=" . $result['id'] . "' class='btn btn-danger text-white' style='background-color: #ed112e; margin-left: 20px;'><i class='fa fa-trash' style='font-size: 14px;'></i></a>
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
} else {
    echo "No records found";
}
?>


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

    
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

    <script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>

<script>
    function fetchEmployeeName(employeeId) {
    // Make an AJAX request to get the employee name
    $.ajax({
        url: 'get_employee_name.php',
        method: 'POST',
        data: { employeeId: employeeId },
        success: function (response) {
            // Update the Employee Name input field with the fetched name
            $('#employeename').val(response);
            clearError('empIdError'); // Clear any previous error
        },
        error: function () {
            displayError('empIdError', 'Failed to fetch employee name.');
        }
    });
}
</script>


<script>
function fetchEmployeeId(employeeName) {
    $.ajax({
        url: 'get_id.php',
        method: 'POST',
        data: { employeeName: employeeName },
        success: function (response) {
            if (response !== "Employee ID not found") {
                $('#employeeid').val(response);
                clearError('empIdError');
            } else {
                displayError('empIdError', 'Employee ID not found');
            }
        },
        error: function () {
            displayError('empIdError', 'Failed to fetch employee ID.');
        }
    });
}
</script>

</body>
</html>