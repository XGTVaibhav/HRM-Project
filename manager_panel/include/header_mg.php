<?php
include("db.php");
?>

<!-- for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
    .uphoto {
        height: 70px;
        width: 70px;
        border: 2px solid black;
        border-radius: 50%;
    }

    .color {
        background-color: #48424f;
    }

    .nav-link .bi-bell,
    .dropdown-toggle::after {
        color: white;
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

    /* CSS for the bell icon notification */
</style>

<?php 
	
	
	$notifications=[];
	$current_month_day=date("m-d");
	$sql="select * from add_employe where DATE_FORMAT(emp_dob, '%m-%d')='{$current_month_day}'";
	$res=$conn->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_assoc()){    
			$age=(date("Y")-date("Y",strtotime($row["emp_dob"])))+1;
			$notifications[]="<i class='bi bi-bell-fill'></i> Wish <b>{$row["emp_name"]}</b> a Happy Birthday!<br> This is <b>{$row["emp_name"]}</b>'s Birthday";
		}
	}
?>

 
<!-- top navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top color">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
            aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase text-white fw-bold" href="#">
        <img src="../images/img-8.jpeg" alt="Logo" height="35" style="margin-right: 10px;">SOURCECODE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar"
            aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
            <form class="d-flex ms-auto my-3 my-lg-0">
                <!-- Your search form here -->
            </form>
            <ul class="navbar-nav">
            <li class="nav-item">
                    <div class="form-check form-switch mt-2">
                    <label class="form-check-label text-white ms-auto float-right" for="themeSwitch"><b>Theme </b></label>
                        <input class="form-check-input" type="checkbox" id="themeSwitch" aria-label="Theme switch">
                    </div>
                    <!-- Label is now below the form switch -->
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                        <li><a class="dropdown-item text-white bg-secondary" href="logout_admin.php"><b>Log Out</b></a></li>
                        <li>
                            <!-- Add any additional dropdown items here -->
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- top navigation bar -->


<!-- offcanvas -->
<div class="offcanvas offcanvas-start sidebar-nav color "  tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">

                    <li>
                        <div class="text-white small fw-bold text-uppercase px-3">
                            MANAGER INFORMATION
                        </div>
                    </li>

                    <li>
                        <a href="manager_index.php" class="nav-link px-3 active">
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

                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts3">
                            <span class="me-2"><i class="bi bi-folder"></i></span>
                            <span>Project</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        
                        <div class="collapse" id="layouts3">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="assign_project.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-file-earmark-plus"></i></i></span>
                                        <span>Add Project</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="project_display.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-folder-fill"></i></i></span>
                                        <span>Manage Project</span>
                                    </a>
                                </li>

                             </ul>
                        </div>

                        <li>
                            <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts4">
                                <span class="me-2"><i class="bi bi-list-task"></i></span>
                                <span>Tickets</span>
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
                                            <span>Manage Tickets</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

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
                                        <a href="performance_emp.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-calendar"></i></span>
                                            <span>Monthly Performance</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="performance_rating.php" class="nav-link text-white px-3">
                                            <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                                            <span>Performance Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a href="logout_admin.php" class="nav-link px-3 text-white sidebar-link">
                            <span class="me-2"><i class="bi bi-box-arrow-right"></i></span>
                            <span>Logout</span>
                            </a>
                        </li>
                    </ul>
            </nav>
        </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
   
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