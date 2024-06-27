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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <link rel="stylesheet" href="stylezzz.css">
    <title>Sourcecode-Admin Dashboard</title>

    
  <style>


 ::placeholder {
        font-size: 14px;
    }

</style>

</head>

<body>

  <!-- navigation & offcanvas starts -->

  <?php
   // include "include/header_ad.php";
?>
 <main class="container mt-5 pt-3">
 
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h2 class="mb-4"><b>Verify OTP and Change Password</b></h2>
            <form action="change_password.php" method="post">
                <div class="form-group">
                    <label for="otp">Enter OTP:</label>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Enter New Password:</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group">
             <center>       <button type="submit" class="btn btn-primary">Change Password</button></center>
                </div>
            </form>
        </div>
    </div>
</main>



<!-- change_password.php -->
<?php
// session_start();

// Function to verify OTP
function verifyOTP($enteredOTP) {
    // TODO: Retrieve the saved OTP from the database based on the email address
    $savedOTP = 123456; // Replace with the actual saved OTP

    return $enteredOTP == $savedOTP;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOTP = $_POST["otp"];
    $newPassword = $_POST["new_password"];

    // TODO: Retrieve the email address from the session or the form submission
    $email = 'user@example.com'; // Replace with the actual email address

    if (verifyOTP($enteredOTP)) {
        // TODO: Update the password in the database for the given email address
        // $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        // Update the password in the database using the email address
        // Example: mysqli_query($conn, "UPDATE users SET password='$newPasswordHash' WHERE email='$email'");
        echo 'Password changed successfully';
    } else {
        echo 'Invalid OTP. Please try again.';
    }
}
?>

</body>
</html>