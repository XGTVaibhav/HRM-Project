<?php
if(isset($_SESSION['$user_name'])) {
    $id = $_SESSION['$user_name'];
} else {
    // Redirect to login or handle this situation as per your need
}
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Carattere&family=Caveat:wght@500&family=Chonburi&family=Dancing+Script&family=DynaPuff&family=Lobster&family=Merriweather&family=Pacifico&family=Pinyon+Script&family=Raleway&family=Roboto+Serif:ital,opsz,wght@0,8..144,300;0,8..144,400;0,8..144,500;1,8..144,300;1,8..144,400&family=Satisfy&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <!-- for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">


  <style>
    .uphoto{
        height: 70px;
        width: 70px;
        /* border: 2px solid black; */
        border-radius: 50%;
    }
    .color{
       background-color: #390d54;
    }
    .emp-profile{
        height: 80px;
        width: 80px;
        /* border: 2px solid white; */
        border-radius: 50%;
padding-left: 25px;
    }
    .emp-profile img{
        background-size: 100% 100%;
        height: 80px;
        width: 80px;
        border-radius: 50%;
        margin-left: -14px;
    }
    .font h5{
        font-style:italic;

    }
    .rounded-pill {
  padding-right: .6em;
  padding-left: .6em;
}
.badge {
    position: absolute;
    right: -9px;
    top: -5px;
    color: #ffffff;
    height: 16px;
    width: 16px;
    font-weight: 500;
    font-size: 10px;
    text-align: center;
    line-height: 17px;
    display: block;
    padding: 0;
    background-color: #3BB77E;}

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
  </style>
  </head>
  <?php
include 'db.php';
$id = $_SESSION['$user_name'];
$query = "SELECT * FROM add_employe WHERE emp_id = '$id'";
$query_show = mysqli_query($conn, $query);
$show = mysqli_fetch_assoc($query_show);
?>

<?php 
	// c
	
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
  <body>
  

<nav class="navbar navbar-expand-lg navbar-dark fixed-top color">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>

            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase text-white fw-bold" href="#">
            <img src="../images/img-8.jpeg" style="height: 35px; width: 35px; margin-right: 5px; " >SOURCECODE
        </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar"
                aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="topNavBar">

                <form class="d-flex ms-auto my-3 my-lg-0">
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class='fa-solid fa-cake-candles' style="color:white;"></span>
                            (<?php echo count($notifications); ?>)
                        </a>
                        <?php if (count($notifications) > 0): ?>
                            <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="navbarDropdown">
                                <?php foreach ($notifications as $row): ?>
                                    <a class="dropdown-item pt-3 pb-3 alert alert-success"
                                        href="#"><?php echo $row; ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-white">
                            <li><a class="dropdown-item text-white bg-secondary" href="logout_user.php"><b>Log Out</b></a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="employe_profile.php">My Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../manager_panel/login_manager.php"
                                    target="_blank">Manager Login</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
</nav>


    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav color "  tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">

                    <li>
                        <div class="text-white small fw-bold text-uppercase px-3">
                            EMPLOYEE INFORMATION
                        </div>
                    </li>

                    <li>
                        <a href="user_index.php" class="nav-link px-3 active">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <div class="container-fluid font">
                        <div class="row">
                            <div class="col-lg-6 emp-profile">
                                <img src="<?php echo $show['uploadfile']; ?>" alt="Employee Image">
                            </div>
                            <div class="col-lg-6 text-white">
                                <h4><b>Welcome</b></h4>
                                <h5 style="text-align: center; padding-left: 20px;"><b><?php echo $show['emp_name']; ?></b></h5>
                            </div>
                        </div>
                    </div>


                    <li class="my-4">
                        
                    </li>

                    <li>
                        <div class="text-white small fw-bold text-uppercase px-3 mb-3">
                            Interface
                        </div>
                    </li>

                   <li>
                        <a class="nav-link px-3 text-white sidebar-link" href="employe_profile.php">
                            <span class="me-2"><i class="bi bi-person"></i></span>
                            <span>Employee</span>
                        </a>
                    </li>

                    
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="emp_attendence.php">
                            <span class="me-2"><i class="bi bi-calendar-check"></i></span>
                            <span>Attendance</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="emp_leave.php">
                            <span class="me-2"><i class="bi bi-briefcase-fill"></i></span>
                            <span>Leave</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="pro_view.php">
                            <span class="me-2"><i class="bi bi-folder"></i></span>
                            <span>Project Details</span>
                        </a>
                    </li>

                   
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" href="task_view.php">
                            <span class="me-2"><i class="bi bi-list-task"></i></span>
                            <span>My Ticket</span>
                            <div class="nav-item dropdown ms-2"> 
                                <?php
                                // include 'db.php';
                                $id = $_SESSION['$user_name'];
                                $orderSql = "SELECT * FROM new_task WHERE status = 'Pending' && emp_id = '$id' ";

                                $orderQuery = mysqli_query($conn, $orderSql);
                                $countOrder = mysqli_num_rows($orderQuery);
                                ?>
                                <span class="badge rounded-pill"><?php echo $countOrder; ?></span>
                                <?php if ($countOrder > 0) { ?>
                                    <i class="fa-solid fa-bell fa-shake fa-lg" style="color: #f7f5fa;"></i>
                                <?php } else { ?>
                                    <i class="fa-regular fa-bell" style="color: #f7f5fa;"></i>
                                <?php } ?>
                            </div>
                        </a>
                    </li>


                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="emp_rating.php">
                            <span class="me-2"><i class="bi bi-graph-up"></i></span>
                            <span>Performance</span> 
                        </a>
                    </li>
                        
                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" data-bs-toggle="collapse" href="#layouts3">
                            <span class="me-2"><i class="bi bi-folder"></i></span>
                            <span>HR</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>

                        <div class="collapse" id="layouts3">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="emp_notice.php" class="nav-link text-white px-3">
                                        <span class="me-2"><i class="bi bi-exclamation-circle"></i></span>
                                        <span>Notice</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="nav-link px-3 text-white sidebar-link1" href="emp_activity.php">
                                        <span class="me-2"><i class="bi bi-bell-fill"></i></span>
                                        <span>Activity</span>
                                        <div class="nav-item dropdown ms-2"> 
                                            <?php
                                            include 'db.php';
                                            $orderSql = "SELECT * FROM emp_activity";
                                            $orderQuery = mysqli_query($conn, $orderSql);
                                            $countOrder = mysqli_num_rows($orderQuery);
                                            ?>
                                            <span class="badge rounded-pill"> <?php echo $countOrder; ?></span>
                                            <?php if ($countOrder > 0) { ?>
                                                <i class="fa-solid fa-bell fa-shake fa-lg" style="color: #f7f5fa;"></i>
                                            <?php } else { ?>
                                                <i class="fa-regular fa-bell" style="color: #f7f5fa;"></i>
                                            <?php } ?>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="show_timeshit.php">
                            <span class="me-2"><i class="bi bi-bell-fill"></i></span>
                            <span>Timesheet</span>
                            <div class="nav-item dropdown ms-2"> 
                                <?php
                                include 'db.php';
                                $orderSql = "SELECT * FROM timesheet";
                                $orderQuery = mysqli_query($conn, $orderSql);
                                $countOrder = mysqli_num_rows($orderQuery);
                                ?>
                                <span class="badge rounded-pill"> <?php echo $countOrder; ?></span>
                                <?php if ($countOrder > 0) { ?>
                                    <i class="fa-solid fa-bell fa-shake fa-lg" style="color: #f7f5fa;"></i>
                                <?php } else { ?>
                                    <i class="fa-regular fa-bell" style="color: #f7f5fa;"></i>
                                <?php } ?>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link px-3 text-white sidebar-link" href="payslip.php">
                            <span class="me-2"><i class="bi bi-person"></i></span>
                            <span>Payslip</span>
                        </a>
                    </li>

                    <li>
                        <a href="changepass.php" class="nav-link text-white px-3">
                            <span class="me-2"><i class="bi bi-key"></i></span>
                            <span>Change Password</span>
                        </a>
                    </li>


                    <li>
                        <a href="add_query.php" class="nav-link text-white px-3">
                            <span class="me-2"><i class="bi bi-question-square"></i></span>
                            <span>Queries</span>
                        </a>
                    </li>


                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="show_holiday.php">
                            <span class="me-2"><i class="bi bi-bell-fill"></i></span>
                            <span>Holiday</span>
                            <div class="nav-item dropdown ms-2"> 
                                <?php
                                include 'db.php';
                                $orderSql = "SELECT * FROM add_holiday";
                                $orderQuery = mysqli_query($conn, $orderSql);
                                $countOrder = mysqli_num_rows($orderQuery);
                                ?>
                                <span class="badge rounded-pill"> <?php echo $countOrder; ?></span>
                                <?php if ($countOrder > 0) { ?>
                                    <i class="fa-solid fa-bell fa-shake fa-lg" style="color: #f7f5fa;"></i>
                                <?php } else { ?>
                                    <i class="fa-regular fa-bell" style="color: #f7f5fa;"></i>
                                <?php } ?>
                            </div>
                        </a>
                    </li>


                    <li>
                        <a class="nav-link px-3 text-white sidebar-link1" href="emp_docs.php">
                            <span class="me-2"><i class="bi bi-file-earmark-text"></i></span>
                            <span>My Document</span>
                        </a>
                    </li>

                    <li>
                        <a href="logout_user.php" class="nav-link text-white px-3">
                            <span class="me-2"><i class="bi bi-box-arrow-right"></i></span>
                            <span>Log Out</span>
                        </a>
                    </li>

                  
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
