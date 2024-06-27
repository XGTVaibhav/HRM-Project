<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sourcecode-Admin Dashboard</title>

    <link rel="stylesheet" href="style_admin.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .fa-user {
      margin-right: 10px; /* Adjust the value as needed */
    }
</style>
<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100  ">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 ">
                    <div class="card bg-dark text-white ecrd shadow-lg rounded">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase"><i class="fa-solid fa-user"></i>Admin Login</h2>

                                <form action="#" method="POST" id="adminForm" novalidate>

               <div class="input-group form-white mb-3">
                      <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                     </span>
                    <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" placeholder="Email" />
                    
               </div>
               <div class="error" id="email_error"></div>

                                  <div class="input-group form-white mb-3">
                                    <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                    </span>
                                        <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" placeholder="Password" />
                                       
                                    </div>
                                    <div class="error" id="password_error"></div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>
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

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $pwd   = $_POST['password'];

        $query = "SELECT * FROM admin_login Where email ='$email' && password ='$pwd' ";
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
                        window.location.href = "admin_index.php";
                    });';
            echo '</script>';
        } else {
            // Show SweetAlert for unsuccessful login
            echo '<script type="text/javascript">';
            echo 'Swal.fire({
                        title: "Login Failed",
                        text: "Invalid email or password",
                        icon: "error",
                        confirmButtonText: "OK",
                        customClass: {
                            popup: "small-sweetalert"
                        }
                    });';
            echo '</script>';
        }
    }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("adminForm").addEventListener("submit", function (event) {
                const email = document.getElementById("typeEmailX");
                const password = document.getElementById("typePasswordX");

                if (!email.value) {
                    displayError("email_error", "Email is required.");
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
</body>

</html>