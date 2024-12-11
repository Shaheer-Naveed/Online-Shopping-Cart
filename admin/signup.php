<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/logos.png">
  <title>Signup</title>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body>
  <main class="main-content mt-0">
    <section class="min-vh-100 mb-8">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('../admin/assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">Welcome!</h1>
              <p class="text-lead text-white">Signup And Enjoy Shopping In Our Website.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card" style="width:150%;margin-left:-5vw;">
              <div class="card-header text-center pt-4">
                <h3>Register with</h3>
              </div>
              <div class="card-body">
                <form method="post">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="username">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="email">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="p-2" style="font-size:10px;">Password must contain at least 1 lowercase letter, 1 number, and be at least 8 characters long.</span>
                    <p></p>
                  </div>
                  <div class="text-center">
                    <button name="signup" type="submit" class="btn btn-primary w-100">Signup</button>
                  </div>
                  <p class="text-sm mt-3 mb-0">Already have an account? <a href="login.php" class="text-dark font-weight-bolder">Log in</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="footer py-5">
      <div class="container">
        <div class="row">
          <div class="col-8 mx-auto text-center mt-1">
            <p class="mb-0 text-secondary">
              Copyright © <script>
                document.write(new Date().getFullYear())
              </script> Soft by Creative Tim.
            </p>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <?php
include('connection.php');

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Simple regex for validation
    $username_regex = "/^[a-zA-Z0-9]{3,20}$/"; // Only alphanumeric characters
    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; // Standard email format
    $password_regex = "/^(?=.*[a-z])(?=.*\d)[A-Za-z\d@!#$%^&*(),.?\":{}|<>]{8,}$/"; // Updated regex

    if (!preg_match($username_regex, $username)) {
      $_SESSION['status'] = "Error!";
      $_SESSION['status_code'] = "error";
      $_SESSION['status_message'] = "Username must be alphanumeric and between 3-20 characters.";
  } elseif (!preg_match($email_regex, $email)) {
      $_SESSION['status'] = "Error!";
      $_SESSION['status_code'] = "error";
      $_SESSION['status_message'] = "Invalid email format.";
  } elseif (!preg_match($password_regex, $password)) {
      $_SESSION['status'] = "Error!";
      $_SESSION['status_code'] = "error";
      $_SESSION['status_message'] = "Password must contain at least 1 lowercase letter, 1 number, and be at least 8 characters long.";
  } else {
      // Check if username or email already exists
      $c_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
      $c_result = mysqli_query($conn, $c_query);
      if (mysqli_num_rows($c_result) > 0) {
          $_SESSION['status'] = "Error!";
          $_SESSION['status_code'] = "error";
          $_SESSION['status_message'] = "Username or Email already exists.";
      } else {
          // Insert the new user
          $role_id = 3; // Assuming 'Customer' role
          $user_query = "INSERT INTO users (Role_Id, Username, Email, Password, Status) VALUES ('$role_id', '$username', '$email', '$password', 'Customer')";
          if (mysqli_query($conn, $user_query)) {
              $customer_query = "INSERT INTO customers (Role_Id, Username, Email, Password) VALUES ('$role_id', '$username', '$email', '$password')";
              if (mysqli_query($conn, $customer_query)) {
                  $_SESSION['status'] = "Signup Successful!";
                  $_SESSION['status_code'] = "success";
                  $_SESSION['status_message'] = "Signup was successful, please login!";
              } else {
                  $_SESSION['status'] = "Signup Failed!";
                  $_SESSION['status_code'] = "error";
                  $_SESSION['status_message'] = "Error inserting customer data: " . mysqli_error($conn);
              }
          } else {
              $_SESSION['status'] = "Signup Failed!";
              $_SESSION['status_code'] = "error";
              $_SESSION['status_message'] = "Error inserting user data: " . mysqli_error($conn);
          }
      }
  }
  
}
?>

<?php
if (isset($_SESSION['status']) && $_SESSION['status']) {
    $status = $_SESSION['status'];
    $status_message = $_SESSION['status_message'];
    $status_code = $_SESSION['status_code'];

    // Check if the status code is success or error
    if ($status_code == "success") {
        echo "<script>
            Swal.fire({
                title: '$status',
                text: '$status_message',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'login.php'; // Redirect after success
            });
        </script>";
    } else if ($status_code == "error") {
        echo "<script>
            Swal.fire({
                title: '$status',
                text: '$status_message',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'signup.php'; // Stay on the signup page after error
            });
        </script>";
    }

    // Unset session data to avoid repeated alerts
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
    unset($_SESSION['status_message']);
}
?>


</body>

</html>
