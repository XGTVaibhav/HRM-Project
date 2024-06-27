<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Carattere&family=Caveat:wght@500&family=Chonburi&family=Dancing+Script&family=DynaPuff&family=Lobster&family=Merriweather&family=Pacifico&family=Pinyon+Script&family=Raleway&family=Roboto+Serif:ital,opsz,wght@0,8..144,300;0,8..144,400;0,8..144,500;1,8..144,300;1,8..144,400&family=Satisfy&display=swap" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap JS with Popper.js (for dropdowns, modals, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>
    .uphoto
    {
        height: 70px;
        width: 70px;
        border: 2px solid black;
        border-radius: 50%;
    }
    .color
    {
       background-color: #390d54;
    }

    .nav-link .bi-bell, .dropdown-toggle::after 
    {
        color: white;
    }
  
    .notification-active::before 
    {
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    background-color: #ff0000;
    border-radius: 50%;
    top: 0;
    right: 0;
    transform: translate(50%, -50%);
    }

    .notification-count 
    {
    position: absolute;
    top: 4px;
    right: 10px;
    font-size: 12px;
    background-color: #ff0000;
    color: #fff;
    border-radius: 50%;
    padding: 2px 6px;
    }

    .rounded-pill 
    {
    padding-right: .6em;
    padding-left: .6em;
    }

    .badge1 
    {
        position: absolute;
        right: 0%;
        top: -8px;
        
        left: 10px;
        color: #ffffff;
        height: 16px;
        width: 16px;
        font-weight: 500;
        font-size: 10px;
        text-align: center;
        line-height: 17px;
        display: block;
        padding: 0;
        background-color: #3BB77E;
    }
        .badge 
        {
        position: absolute;
        right: 0%;
        top:-1%;
        color: #ffffff;
        height: 16px;
        width: 16px;
        font-weight: 500;
        font-size: 10px;
        text-align: center;
        line-height: 17px;
        display: block;
        padding: 0;
        background-color: #3BB77E;
    }
        
    .navbar-brand {
        font-weight: bold;
    }

    .form-check-label {
        margin-left: 10px;
    }

    .form-check-input:checked + .form-check-label {
        color: #ffffff;
    }

    /* Light Theme */
    body.light-mode {
        background-color: #ffffff;
        color: #000000;
    }

    /* Dark Theme */
    body.dark-mode {
        background-color: #000000;
        color: #ffffff;
    }


        /* Media query for small screens (up to 576px) */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 16px;
            }

            .form-check-label {
                margin-left: 0;
            }
        }

        /* Media query for medium screens (between 577px and 992px) */
        @media (min-width: 577px) and (max-width: 992px) {
            .navbar-brand {
                font-size: 20px;
            }
        }

        /* Media query for large screens (993px and above) */
        @media (min-width: 993px) {
            .navbar-brand {
                font-size: 24px;
            }
        }

  </style>
   <?php 

	
	$notifications=[];
	$current_month_day=date("m-d");
	$sql="select * from add_employe where DATE_FORMAT(emp_dob, '%m-%d')='{$current_month_day}'";
	$res=$conn->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_assoc()){    
			$age=(date("Y")-date("Y",strtotime($row["emp_dob"])))+1;
			$notifications[]="<i class='bi bi-bell-fill'></i> Wish <b>{$row["emp_name"]}</b> a Happy Birthday!<br> This is <b>{$row["emp_name"]}</b>'s Birthday .  date of birth is <b>".date("d-m-Y",strtotime($row["emp_dob"]))."</b>";
		}
	}
?>

 
  <!-- top navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top color">
    <div class="container-fluid">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>

        <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase text-white fw-bold" href="#">
            <img src="../images/img-8.jpeg" style="height: 35px; width: 35px; margin-right: 5px; " >SOURCECODE
        </a>



        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNavBar">
            <form class="d-flex ms-auto my-2 my-lg-0">
                <!-- Your form content -->
            </form>

            <ul class="navbar-nav ml-auto" >

                <li class="nav-item">
                    <div class="form-check form-switch mt-2">
                    <label class="form-check-label text-white ms-auto float-right" for="themeSwitch"><b>Theme </b></label>
                        <input class="form-check-input" type="checkbox" id="themeSwitch" aria-label="Theme switch">
                    </div>
                    <!-- Label is now below the form switch -->
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class='fa-solid fa-cake-candles' style="color:white;"></span>(<?php echo count($notifications); ?>)
                    </a>
                    <?php if (count($notifications) > 0): ?>
                        <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="navbarDropdown">
                            <?php foreach ($notifications as $row): ?>
                                <a class="dropdown-item pt-3 pb-3 alert alert-success" href="#"><?php echo $row; ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </li>

                <li class="nav-item dropdown ms-2">
                    <?php
                    include 'db.php';
                    $orderSql = "SELECT * FROM add_query WHERE status = 'Pending'";
                    $orderQuery = mysqli_query($conn, $orderSql);
                    $countOrder = mysqli_num_rows($orderQuery);
                    ?>

                    <a class="nav-link btn-icon" href="manage_query.php">
                        <span class="badge rounded-pill"> <?php echo $countOrder; ?></span>
                        <?php if ($countOrder > 0): ?>
                            <i class="fa-solid fa-bell fa-shake fa-lg" style="color: #f7f5fa;"></i>
                        <?php else: ?>
                            <i class="fa-regular fa-bell" style="color: #f7f5fa;"></i>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                        <li>
                            <a class="dropdown-item text-white bg-secondary" href="logout_admin.php"><b>Log Out</b></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav color "  tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-1">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                    <div class="text-white small fw-bold text-uppercase px-3" style="padding-top: 5px;">
                        USER INFORMATION
                    </div>

                    </li>

                    <li>
                        <a href="admin_index.php" class="nav-link px-3 active">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="my-4">
                    </li>

                    <li>
                        <div class="text-white small fw-bold text-uppercase px-3 mb-3">
                            Interface
                        </div>
                    </li>
                    
                    <!-- ADD EMPLOYEE  -->
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts">
                            <span class="me-2"><i class="bi bi-people"></i></span>
                            <span>Employee</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="layouts">
                            <ul class="navbar-nav ps-3 text-white">
                                <li>
                                    <a href="add_employe.php" class="nav-link text-white px-3">
                                    <span class="me-2"><i class="bi bi-person-plus"></i></span>
                                      
                                        <span>Add Employee</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="display.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-gear"></i></span>
                                        <span>Manage Employee</span>
                                    </a>
                                </li>
                               
                            </ul>
                        </div>
                    </li>

                    <!-- ADD ATTENDANCE -->
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" data-bs-toggle="collapse" href="#layouts1">
                            <span class="me-2"><i class="bi bi-calendar-check"></i></span>
                            <span>Attendance</span>
                            <span class="ms-auto">
                                <span class="right-icon1">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="layouts1">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="add_attendance.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-file-earmark-check"></i></span>
                                        <span>Daily Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="attendance_report.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                                        <span>Attendance Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!--ADD LEAVE  -->
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" data-bs-toggle="collapse" href="#layouts2">
                            <span class="me-2"><i class="bi bi-briefcase-fill"></i></span>
                            <span>Leave </span>
                            <div class="nav-item dropdown ms-2">
                            <!-- <span id="bell-icon-container"> -->
                            <?php
                            include 'db.php';
                            $orderSql = "SELECT * FROM leaveform where status='' ";
                            $orderQuery = mysqli_query($conn, $orderSql);
                            $countOrder = mysqli_num_rows($orderQuery);
                            ?>
                            <!-- <a class="nav-link btn-icon" href="emp_activity.php"> -->
                            <span class="badge1 rounded-pill"> <?php echo $countOrder; ?></span>
                            <?php if ($countOrder = mysqli_num_rows($orderQuery) > 0) { ?>
                                        <i class="fa-solid fa-bell fa-shake fa-lg" style="color: #f7f5fa;"></i>
                                    <?php } else { ?>
                                        <i class="fa-regular fa-bell" style="color: #f7f5fa;"></i>
                                    <?php } ?>
                                            <!-- </span> -->

                            </div>
                            <span class="ms-auto">
                                <span class="right-icon1">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="layouts2">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="add_leave.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-plus"></i></span>
                                        <span>Add Leave</span>
                                    </a>
                                    
                                </li>
                               
                            </ul>
                        </div>
                    </li>

                    <!-- ADD PROJECT -->
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#projectsMenu">
                            <span class="me-2"><i class="bi bi-folder"></i></span>
                            <span>Projects</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>

                        <div class="collapse" id="projectsMenu">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="new_project.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-file-earmark-plus"></i></span>
                                        <span>Add Project</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="pro_display.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-folder-fill"></i></span>
                                        <span>Manage Project</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                            <!-- ADD TICKET -->
                            <li>
                                <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts4">
                                    <span class="me-2"><i class="bi bi-list-task"></i></span>
                                    <span>Ticket</span>
                                    <span class="ms-auto">
                                        <span class="right-icon">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </span>
                                </a>
                                <div class="collapse" id="layouts4">
                                    <ul class="navbar-nav ps-3">
                                        <li>
                                            <a href="pro_task.php" class="nav-link text-white px-3">
                                                <span class="me-2"><i class="bi bi-card-checklist"></i></span>
                                                <span>Raise Ticket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="task_display.php" class="nav-link text-white px-3">
                                                <span class="me-2"><i class="bi bi-book-fill"></i></span>
                                                <span>Manage Ticket</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <!-- ADD HOLIDAY -->
                            <li>
                                <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts5">
                                    <span class="me-2"><i class="bi bi-calendar-event"></i></span>
                                    <span>Holiday</span>
                                    <span class="ms-auto">
                                        <span class="right-icon">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </span>
                                </a>
                                <div class="collapse" id="layouts5">
                                    <ul class="navbar-nav ps-3">
                                        <li>
                                            <a href="add_holiday.php" class="nav-link text-white px-3">
                                                <span class="me-2"><i class="bi bi-plus"></i></span>
                                                <span>Add Holiday</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="manage_holiday.php" class="nav-link text-white px-3">
                                                <span class="me-2"><i class="bi bi-book-fill"></i></span>
                                                <span>Manage Holiday</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        <!-- ADD TIMESHEET -->
                        <li>
                            <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts6">
                                <span class="me-2"><i class="bi bi-clock"></i></span>
                                <span>Timesheet</span>
                                <span class="ms-auto">
                                    <span class="right-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </span>
                            </a>
                            <div class="collapse" id="layouts6">
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="add_timeshit.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-plus"></i></span>
                                            <span>Add Link</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- ADD PERFORMANCE -->
                        <li>
                            <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts7">
                                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                                <span>Performance</span>
                                <span class="ms-auto">
                                    <span class="right-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </span>
                            </a>
                            <div class="collapse" id="layouts7">
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="emp_performance.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-calendar"></i></span>
                                            <span>Monthly Performance</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="emp_rating.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                                            <span>Performance Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- ADD PAYROLL -->
                        <li>
                        
                            <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#payroll">
                                <span class="me-2"><i class="bi bi-cash"></i></span>
                                <span>Payroll</span>
                                <span class="ms-auto">
                                    <span class="right-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </span>
                            </a>
                            <div class="collapse" id="payroll">
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="emp_salary.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-file-earmark"></i></span>
                                            <span>Employee Salary</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="manage_salary.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-file-earmark-check"></i></span>
                                            <span>Manage Salary</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>



                    <!-- ADD ACTIVITY LOG -->
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#activity-log">
                            <span class="me-2"><i class="bi bi-journal-text"></i></span>
                            <span>Activity Log</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="activity-log">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="emp_notice.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-exclamation-circle"></i></span>
                                        <span>Notice</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="emp_activity.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-journal-text"></i></span>
                                        <span>Activity Log</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- ADD DOCUMENTATION -->
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts9">
                            <span class="me-2"><i class="bi bi-file-earmark"></i></span>
                            <span>Documentation</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="layouts9">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="emp_Docs.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                                        <span>Employee Documentation</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!--ADD QUERIES  -->
                    <a href="manage_query.php" class="nav-link text-white px-3">
                        <span class="me-2"><i class="bi bi-question-square"></i></span>
                        <span>Queries</span>
                    </a>

                    <!-- FAQ -->
                    <a href="faq.php" class="nav-link text-white px-3">
                        <span class="me-2"><i class="bi bi-info-square"></i></span>
                        <span>FAQ</span>
                    </a>

                    <!-- LICENSE -->
                    <a href="license.php" class="nav-link text-white px-3">
                        <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                        <span>License</span>
                    </a>

                    <!-- LOGOUT -->
                    <a href="logout_admin.php" class="nav-link text-white px-3">
                        <span class="me-2"><i class="bi bi-box-arrow-right"></i></span>
                        <span>Log Out</span>
                    </a>
                        
                  
                </ul>
            </nav>
        </div>
    </div>
  
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Include this script after the existing scripts in your HTML file -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if the user has a preference stored in local storage
        const darkModeEnabled = localStorage.getItem('darkModeEnabled') === 'true';

        // Function to toggle dark mode
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');

            // Save the user's preference in local storage
            const isDarkModeEnabled = body.classList.contains('dark-mode');
            localStorage.setItem('darkModeEnabled', isDarkModeEnabled);
        }

        // Apply dark mode if it was enabled before
        if (darkModeEnabled) {
            toggleDarkMode();
        }

        // Add an event listener to the theme switch checkbox
        const themeSwitch = document.getElementById('themeSwitch');
        if (themeSwitch) {
            themeSwitch.addEventListener('change', toggleDarkMode);
        }
    });
</script>
</body>
</html>