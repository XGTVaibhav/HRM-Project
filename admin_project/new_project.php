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
    <title>Sourcecode-Admin Dashboard</title>
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="stylezzz.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
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

    <!-- Other CSS Links -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />        
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css" />

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
        .error {
        color: red;
        }
        ::placeholder{
            font-size: 14px;
        }
        #multiSelectDropdown
        {
            border: 1px solid;
            font-size: 14px;
        }
    </style>
    <title>SourceCode Admin Dashboard</title>
</head>

<body>

  <?php
    include "include/header_ad.php";
    ?>

<main class="mt-5 pt-3">
    <div class="container">
        <h2><b>New Project</b></h2>
        <hr>

        <div class="rkform">
            <form class="row g-3 ms-2 me-2" method="POST" id="projectForm" novalidate>
            
                <div class="col-md-6">
                    <label for="employeeid" class="form-label">Employee ID<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="employeeid" name="emp_id" placeholder="Enter Employee ID" oninput="fetchEmployeeDetails(this.value, true)">
                    <div class="error" id="emp_idError"></div>
                </div>

                <div class="col-md-6">
                    <label for="employeename" class="form-label">Employee Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="employeename" name="emp_name" placeholder="Enter Employee Name" oninput="fetchEmployeeDetails(this.value, false)">
                    <div class="error" id="employee_nameError"></div>
                </div>

                <div class="col-md-6">
                    <label for="project_name" class="form-label">Project Name<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Enter Project Name">
                    <div class="error" id="project_nameError"></div>
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Project Description<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Project Description">
                    <div class="error" id="descriptionError"></div>
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
                    <label for="project_manager" class="form-label">Project Manager<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <select class="form-control" id="project_manager" name="project_manager" >
                        <option value="">Select</option>
                        <?php
                        $query_show = mysqli_query($conn, "SELECT emp_id, emp_name, designation FROM add_employe WHERE designation = 'Manager' ORDER BY emp_name ASC");

                        while ($show = mysqli_fetch_array($query_show)) {
                        ?>
                            <option value="<?php echo $show['emp_id']; ?>"><?php echo $show['emp_id']; ?> (Name: <?php echo $show['emp_name']; ?>)</option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="error" id="project_managerError"></div>
                </div>

                <div class="col-md-6">
                    <div class="dropdown">
                        <label for="team_size" class="form-label">Team Members<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                        <button class="btn dropdown-toggle" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false" required>
                            Select Team Members
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="multiSelectDropdown">
                            <li>                                             
                                <?php
                                $query_show = mysqli_query($conn, "SELECT emp_id, emp_name, designation FROM add_employe WHERE designation <> 'Manager' ORDER BY emp_name ASC");

                                while ($show = mysqli_fetch_array($query_show)) {
                                ?>
                                    <input type="checkbox" name="members[]" value="<?php echo $show['emp_id'] . '-' . $show['emp_name']; ?>">
                                    <?php echo $show['emp_id']; ?> (<?php echo $show['emp_name']; ?>)<br><br>
                                <?php
                                }
                                ?>
                            </li>
                        </ul>
                    </div> 
                </div>

                <div class="col-md-4">
                    <label for="team_size" class="form-label">Team Size<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <input type="number" class="form-control" id="team_size" name="team_size" placeholder="Enter Team Size">
                    <div class="error" id="team_sizeError"></div>
                </div>

                <div class="col-md-4">
                    <label for="links" class="form-label">Create Meeting</label>
                    <input type="url" class="form-control" id="links" name="links" placeholder="Enter Meeting URL">
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status<span class="text-danger" style="font-size: 1.2em;">*</span></label>
                    <select id="status" class="form-control" name="status">
                        <option value="">Select</option>
                        <option value="Done">Done</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <div class="error" id="statusError"></div>
                </div>

                <div class="col-12 mb-3">
                    <center><button id="submitBtn" type="submit" class="btn btn-primary" name="submit">Submit</button></center> 
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
    $e_id = $_POST['emp_id'];
    $e_name = $_POST['emp_name'];
    $p_name=$_POST['project_name'];
    $d_name=$_POST['description'];
    $s_date=$_POST['start_date'];
    $e_date=$_POST['end_date'];
    $p_man=$_POST['project_manager'];
    $members = isset($_POST['members']) && is_array($_POST['members']) ? implode(", ", $_POST['members']) : '';
    $t_size=$_POST['team_size'];
    $link=$_POST['links'];
    $status=$_POST['status'];
    
        $querry = "INSERT INTO `new_project`(`emp_id`,`emp_name`,`project_name`,`description`,`start_date`,`end_date`,`project_manager`,`members`,`team_size`,`links`,`status`) 
                    VALUES ( '$e_id','$e_name','$p_name','$d_name','$s_date','$e_date','$p_man','$members','$t_size','$link','$status')";
        $data=mysqli_query($conn,$querry);
    
    

    if ($data) {
        // echo "Data Inserted";
        echo 

        "<script type='text/javascript'>
        Swal.fire({
        title:'Add Data successfully',
        icon:'success',
        showConfirmButton: false,
        timer:2000
        }).then(function() {
        window.location.replace('pro_display.php');
        });
        </script>";
        }
        else{
        echo "data Not Updated";
        }

    }          
?>
 
<!-- FORM VALIDATION SCRIPT -->
<script>
    const projectForm = document.getElementById('projectForm');
    const empIdInput = document.getElementById('employeeid');
    const empNameInput = document.getElementById('employeename');
    const project_name = document.getElementById('project_name');
    const description = document.getElementById('description');
    const start_date = document.getElementById('start_date');
    const end_date = document.getElementById('end_date');
    const project_manager = document.getElementById('project_manager');
    const project_team = document.getElementById('project_team');
    const team_size = document.getElementById('team_size');
    const status = document.getElementById('status');

    projectForm.addEventListener('submit', function (e) {
        if (!validateForm()) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function validateForm() {
        let valid = true;

        // Reset error messages
        setError('emp_idError', '');
        setError('employee_nameError', '');
        setError('project_nameError', '');
        setError('descriptionError', '');
        setError('start_dateError', '');
        setError('end_dateError', '');
        setError('project_managerError', '');
        // setError('project_teamError', '');
        setError('team_sizeError', '');
        setError('statusError', '');


        if (empIdInput.value.trim() === '') {
                document.getElementById('emp_idError').textContent = 'Employee ID is required';
                isValid = false;
            }

            if (empNameInput.value.trim() === '') {
                document.getElementById('employee_nameError').textContent = 'Employee Name is required';
                isValid = false;
            }
        if (project_name.value === '') {
            setError('project_nameError', 'Project Name must be filled out');
            valid = false;
        }
        if (description.value === '') {
            setError('descriptionError', 'Description must be filled out');
            valid = false;
        }
        if (start_date.value === '') {
            setError('start_dateError', 'Start Date must be filled out');
            valid = false;
        }
        if (end_date.value === '') {
            setError('end_dateError', 'End Date must be filled out');
            valid = false;
        }
        if (project_manager.value === '') {
            setError('project_managerError', 'Project Manager must be filled out');
            valid = false;
        }
    
        if (team_size.value === '') {
            setError('team_sizeError', 'Team Size must be filled out');
            valid = false;
        }
        if (status.value === '') {
            setError('statusError', 'Status must be selected');
            valid = false;
        }

        return valid;
    }

    function setError(id, message) {
        const errorElement = document.getElementById(id);
        errorElement.innerText = message;
    }
 
</script>

<!-- START DATE AND END DATE SCRIPT -->
<script>
   var startDateInput = document.getElementById("start_date");
    var endDateInput = document.getElementById("end_date");

    
    var today = new Date();
    today.setDate(today.getDate() - 1); 

    
    var minDate = today.toISOString().split("T")[0];

    
   startDateInput.min = minDate;
    endDateInput.min = minDate;

    
    startDateInput.addEventListener("change", function () {
       var selectedStartDate = new Date(startDateInput.value);
        var selectedEndDate = new Date(endDateInput.value);

        
        if (selectedStartDate <= today) {
            document.getElementById("start_dateError").innerText = "Start Date cannot be today or in the past.";
            startDateInput.value = ""; 
        } else {
            document.getElementById("start_dateError").innerText = "";
        }

       
        if (selectedEndDate < selectedStartDate) {
            document.getElementById("end_dateError").innerText = "End Date cannot be earlier than Start Date.";
            endDateInput.value = ""; 
        } else {
            document.getElementById("end_dateError").innerText = "";
        }
    });

    endDateInput.addEventListener("change", function () {
        var selectedStartDate = new Date(startDateInput.value);
        var selectedEndDate = new Date(endDateInput.value);

        
        if (selectedEndDate < selectedStartDate) {
            document.getElementById("end_dateError").innerText = "End Date cannot be earlier than Start Date.";
            endDateInput.value = ""; 
        } else {
            document.getElementById("end_dateError").innerText = "";
        }
    });
</script>



<script>
    // Get references to the select elements and the search inputs for each team member
    const selectElements = [
        document.getElementById('project_team1'),
        document.getElementById('project_team2'),
        document.getElementById('project_team3'),
        document.getElementById('project_team4'),
        document.getElementById('project_team5'),
    ];

    const searchInputs = [
        document.getElementById('search1'),
        document.getElementById('search2'),
        document.getElementById('search3'),
        document.getElementById('search4'),
        document.getElementById('search5'),
    ];

    // Add event listeners to each select element
    for (let i = 0; i < selectElements.length; i++) {
        selectElements[i].addEventListener('change', () => updateSearchInput(i));
    }

    // Function to update the search input immediately when an option is selected
    function updateSearchInput(index) {
        const select = selectElements[index];
        const searchInput = searchInputs[index];

        const selectedOptions = Array.from(select.selectedOptions);
        const selectedValues = selectedOptions.map(option => option.value);

        // Update the search input value with the selected project team members
        searchInput.value = selectedValues.join(', ');
    }
</script>

<!-- SCRIPT TO FETCH EMPLOYEE ID AND EMPLOYEE NAME -->
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the checkboxes and the team size input
        var checkboxes = document.querySelectorAll('input[name="members[]"]');
        var teamSizeInput = document.getElementById('team_size');

        // Add a change event listener to each checkbox
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                // Get the count of selected checkboxes
                var selectedCount = document.querySelectorAll('input[name="members[]"]:checked').length;

                // Update the team size input value with the selected count
                teamSizeInput.value = selectedCount;
            });
        });
    });
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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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