<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/logos.png">
  <title>Employee Signup</title>
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
              <p class="text-lead text-white">Signup And Join Our Team.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0 w-100">
              <div class="card-header text-center pt-4">
                <h5>Register as Employee</h5>
              </div>
              <div class="card-body">
                <form method="post">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
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
      echo "<script>
              Swal.fire({
                title: 'Error!',
                text: 'Username must be alphanumeric and between 3-20 characters.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            </script>";
  } elseif (!preg_match($email_regex, $email)) {
      echo "<script>
              Swal.fire({
                title: 'Error!',
                text: 'Invalid email format.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            </script>";
  } elseif (!preg_match($password_regex, $password)) {
      echo "<script>
              Swal.fire({
                title: 'Error!',
                text: 'Password must contain at least 1 lowercase letter, 1 number, and be at least 8 characters long.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            </script>";
  } else {
      // Check if username or email already exists
      $c_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
      $c_result = mysqli_query($conn, $c_query);
      if (mysqli_num_rows($c_result) > 0) {
          echo "<script>
                  Swal.fire({
                    title: 'Error!',
                    text: 'Username or Email already exists.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                </script>";
      } else {
          // Insert the new employee user
          $role_id = 2; // Assuming 'Employee' role
          $status="Employee";
          $user_query = "INSERT INTO users (Role_Id, Username, Email, Password, Status) VALUES ('$role_id', '$username', '$email', '$password', '$status')";
          if (mysqli_query($conn, $user_query)) {
            $employee_query = "INSERT INTO employee (Role_Id, Username, Email, Password) VALUES ('$role_id', '$username', '$email', '$password')";
            if (mysqli_query($conn, $employee_query)) {
                // Success alert
                echo "<script>
                        Swal.fire({
                          title: 'Signup Successful!',
                          text: 'Signup was successful, please login!',
                          icon: 'success',
                          confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = 'dashboard.php'; // Redirect after success
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                          title: 'Error!',
                          text: 'Error inserting employee data.',
                          icon: 'error',
                          confirmButtonText: 'OK'
                        });
                      </script>";
            }
          } else {
            echo "<script>
                    Swal.fire({
                      title: 'Error!',
                      text: 'Error inserting user data.',
                      icon: 'error',
                      confirmButtonText: 'OK'
                    });
                  </script>";
          }
      }
  }
  
}
?>

</body>
</html>
