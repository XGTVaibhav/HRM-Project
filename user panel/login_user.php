<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sourcecode-User Dashboard</title>

  <link rel="stylesheet" href="style_admin.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <!-- Include SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("loginForm").addEventListener("submit", function (event) {
        // Check required fields and display error messages
        const email = document.getElementById("typeEmailX");
        const password = document.getElementById("typePasswordX");

        if (!email.value) {
          displayError("email_error", "Username is required.");
          event.preventDefault();
        } else {
          clearError("email_error");
        }

        if (!password.value) {
          displayError("password_error", "Password is required.");
          event.preventDefault();
        } else {
          clearError("password_error");
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
    });
  </script>

  <style>
    .btn button {
      height: 40px;
      width: 200px;
      float: left;
      margin-bottom: 40px;
    }

    .btn button a {
      text-decoration: none;
      color: black;
      font-size: 18px;
      font-weight: 600;
    }

    .logo {
      font-size: 35px;
      font-family: Merriweather;
      font-weight: bold;
      color: red;
      margin-bottom: 30px;
    }

    .logo span {
      color: green;
    }
    
    .fa-user {
      margin-right: 10px; /* Adjust the value as needed */
    }
  </style>

</head>

<body>

  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100  ">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5 ">
          <div class="card bg-dark text-white ecrd shadow-lg rounded">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">
                <h1 class="logo"> <img src="../images/img-8.jpeg" alt="Logo" height="35" style="margin-right: 10px;">Source<span>Code</span></h1>
                
                <h2 class="fw-bold mb-2 text-uppercase"><i class="fa-solid fa-user"></i>USER Login</h2>
                <!-- <p class="text-white-50 mb-5">Please enter your login and password!</p> -->

                <form action="#" method="POST" id="loginForm" novalidate>

                <div class="input-group form-white mb-3">
                      <span class="input-group-text">
                        <i class="fa-solid fa-user"></i>
                     </span>
                    <input type="text" name="email" id="typeEmailX" class="form-control form-control-lg" placeholder="User-Id" />
                   
                  </div>
                  <div class="error" id="email_error"></div>

                  <div class="input-group form-white mb-3">
                                    <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                    </span>
                    <input type="password" name="pass" id="typePasswordX" class="form-control form-control-lg" placeholder="Password" />
                   
                  </div>
                  <div class="error" id="password_error"></div>

                  <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit">Login</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  include("db.php");

  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pwd   = $_POST['pass'];

    $query = "SELECT * FROM add_employe Where emp_id ='$email' && emp_password ='$pwd' ";
    $data  = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);

    if ($total == 1) {
      $_SESSION['$user_name'] = $email;

      // Show SweetAlert for successful login
      echo '<script type="text/javascript">';
      echo 'Swal.fire({
        title: "Login Successful",
        text: "Redirecting to the dashboard...",
        icon: "success",
        showConfirmButton: false,
        timer: 2000,
        customClass: {
            popup: "small-sweetalert"
        }
                }).then(function() {
                  window.location.href = "user_index.php";
                });';
      echo '</script>';
    } else {
      // Show SweetAlert for unsuccessful login
      echo '<script type="text/javascript">';
      echo 'Swal.fire({
                  title: "Login Failed",
                  text: "Invalid username or password",
                  icon: "error",
                  confirmButtonText: "OK",
                  customClass: {
                    popup: "extra-small-sweetalert"
                  }
                });';
      echo '</script>';
    }
  }
  ?>

</body>

</html>