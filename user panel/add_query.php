<?php
session_start();

include("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}




include("db.php");

$userprofile = $_SESSION['$user_name'];

// Check if the user is logged in
if (!$userprofile) {
    header('location:login_user.php');
}

// Update the last activity time in the session
$_SESSION['last_activity'] = time();

// Check if the user has been inactive for more than 1 minute
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 180)) {
    // Destroy the session and redirect to the login page
    session_unset();
    session_destroy();
    header('location:login_user.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sourcecode-User Dashboard</title>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- Google Fonts CDN Link (example fonts) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap Icons CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <!-- Custom CSS (replace with your actual CSS files) -->
    <link rel="stylesheet" href="stylezzz.css">
    <link rel="stylesheet" href="style_admin.css">

    <!-- SweetAlert2 CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
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
    include "include/header_us.php"; 
  ?>

<main class="mt-3 pt-5">
    <div class="container ">
      <h2><b>Write Your Query</b></h2><hr>


      <form action="#" method="POST" id="queryForm" novalidate>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="emp_id">Employee ID:</label>
              <input type="text" class="form-control" id="emp_id" placeholder="Enter Employee ID" name="emp_id"
                value="<?php echo $show['emp_id']; ?>" readonly>
              <div class="error" id="emp_id_error"></div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="emp_name">Employee name:</label>
              <input type="text" class="form-control" id="emp_name" placeholder="Enter Employee Name" name="emp_name"
                value="<?php echo $show['emp_name']; ?>" readonly>
              <div class="error" id="emp_name_error"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="contact">Contact:</label>
              <input type="text" class="form-control" id="contact" name="contact" required
                placeholder="Enter contact number" value="<?php echo $show['emp_mob1']; ?>" readonly>
              <div class="error" id="contact_error"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email"
                value="<?php echo $show['email']; ?>" readonly>
              <div class="error" id="email_error"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="query_date">Date:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
              <!-- <input type="date" class="form-control" id="querydate" name="ondate" required> -->
              <input type="date" class="form-control" id="querydate" name="ondate" required
                min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
              <div class="error" id="query_date_error"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="query_subject">Subject:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
              <input type="text" class="form-control" id="querysubject" name="subject" required
                placeholder="Enter subject">
              <div class="error" id="query_subject_error"></div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="query_message">Message:<span class="text-danger" style="font-size: 1.2em;">*</span></label>
          <textarea class="form-control" id="querymessage" rows="3" name="message" required
            placeholder="Enter your message"></textarea>
          <div class="error" id="query_message_error"></div>
        </div>

        <br>

        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary">Add Query</button>
        </div>
      </form>
    </div>

  </main>


<script>
    const queryForm = document.getElementById('queryForm');
    const empId = document.getElementById('emp_id');
    const empName = document.getElementById('emp_name');
    const contact = document.getElementById('contact');
    const email = document.getElementById('email');
    const querySubject = document.getElementById('querysubject');
    const queryMessage = document.getElementById('querymessage');
    const queryDate = document.getElementById('querydate');

    queryForm.addEventListener('submit', function (e) {
        if (!validateForm()) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function validateForm() {
        let valid = true;
        resetErrorMessages();

        if (empId.value.trim() === '') {
            setError('emp_id_error', 'Employee ID is required');
            valid = false;
        }

        if (empName.value.trim() === '') {
            setError('emp_name_error', 'Employee Name is required');
            valid = false;
        }

        if (contact.value.trim() === '') {
            setError('contact_error', 'Contact is required');
            valid = false;
        }

        if (email.value.trim() === '') {
            setError('email_error', 'Email is required');
            valid = false;
        } else if (!isValidEmail(email.value.trim())) {
            setError('email_error', 'Enter a valid email address');
            valid = false;
        }

        if (querySubject.value.trim() === '') {
            setError('query_subject_error', 'Subject is required');
            valid = false;
        }

        if (queryMessage.value.trim() === '') {
            setError('query_message_error', 'Message is required');
            valid = false;
        }

        if (queryDate.value.trim() === '') {
            setError('query_date_error', 'Date is required');
            valid = false;
        } else if (!isValidDate(queryDate.value.trim())) {
            setError('query_date_error', 'Enter a valid date (YYYY-MM-DD)');
            valid = false;
        }

        return valid;
    }

    function setError(id, message) {
        const errorElement = document.getElementById(id);
        errorElement.innerText = message;
    }

    function resetErrorMessages() {
        setError('emp_id_error', '');
        setError('emp_name_error', '');
        setError('contact_error', '');
        setError('email_error', '');
        setError('query_subject_error', '');
        setError('query_message_error', '');
        setError('query_date_error', '');
    }

    function isValidEmail(email) {
        // Regular expression for basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidDate(date) {
        // Regular expression for basic date validation (YYYY-MM-DD)
        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        return dateRegex.test(date);
    }
</script>


<?php
    $e_id = $_SESSION['$user_name'];
    $query = "SELECT * FROM add_query WHERE emp_id= '$e_id'";
    $result = $conn->query($query);
    $conn->close();
?>

<?php
   include "db.php";
    if (isset($_POST['submit'])) {
        $empid   = test_input($_POST['emp_id']);
        $empname = test_input($_POST['emp_name']);
        $contact = test_input($_POST['contact']);
        $email   = test_input($_POST['email']);
        $subject = test_input($_POST['subject']);
        $message = test_input($_POST['message']);
        $date    = test_input($_POST['ondate']);

        $status = 'Pending'; // Set the status to 'Pending'

        // Validate required fields
        if (empty($empid) || empty($empname) || empty($subject) || empty($email) || empty($contact) || empty($message) || empty($date)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Form Submission Failed',
                        text: 'Please fill in all the fields.',
                    });
                </script>";
        } else {
            $query = "INSERT INTO `add_query`(`emp_id`, `emp_name`, `subject`, `email`, `contact`, `message`, `ondate`, `status`)
                        VALUES ('$empid','$empname','$subject','$email','$contact','$message','$date','$status')"; // Include the status field

            $data = mysqli_query($conn, $query);

            if ($data) {
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Form Submitted Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'add_query.php';
                        });
                    </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Form Submission Failed',
                            text: 'Failed to submit the form.',
                        });
                    </script>";
            }
        }
    }
?>

<main class="mt-5 pt-3">
    <div class="container">
        <center><h2><b>Your Queries</b></h2></center><hr>
        <div class="table-responsive">
            <div class="table-wrapper">
                <table id="querytable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include("db.php");

                    $employeeId = $_SESSION['$user_name']; // Assuming the employee ID is stored in the session

                    $query = "SELECT * FROM `add_query` WHERE emp_id = '$employeeId' ORDER BY id DESC";

                    $data = mysqli_query($conn, $query);
                    $total = mysqli_num_rows($data);
                    $counter = 1;

                    if ($total != 0) {
                        while ($result = mysqli_fetch_assoc($data)) {
                            echo "<tr>
                                    <td>" . (isset($result['ondate']) ? date('d/m/Y', strtotime($result['ondate'])) : '') . "</td>
                                    <td>" . $result['subject'] . "</td>
                                    <td>" . $result['message'] . "</td>
                                    <td>" . $result['status'] . "</td>
                                </tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<div>
<footer class="text-black text-center py-2" style="margin-right:22%;">
    <strong>Copyright &copy; 2023-<a href="#">SourceCode Software Pvt. Ltd</a>.</strong> All rights reserved.
    </footer>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {
        $('#querytable').DataTable({
            "paging": true,
            "pageLength": 10,
        });
    });
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