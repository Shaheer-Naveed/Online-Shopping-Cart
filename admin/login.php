<?php
session_start();
include('connection.php');

if (isset($_SESSION['Id'])) {
    $user_id = $_SESSION['Id'];
    $previous_session_id = $_SESSION['previous_session_id']; // From before login

    // Migrate cart items from session to user
    $migrate_query = "UPDATE cart SET User_Id = '$user_id', Session_Id = NULL WHERE Session_Id = '$previous_session_id' AND User_Id IS NULL";
    $migrate_result = mysqli_query($conn, $migrate_query);

    // Clear session data
    unset($_SESSION['previous_session_id']);
}

// Check if the user is already logged in
if (isset($_SESSION['Username'])) {
    // If the user is logged in, check the role and redirect accordingly
    if (isset($_SESSION['Role_Id'])) {
        switch ($_SESSION['Role_Id']) {
            case 3: // Customer
                // Redirect customer to the homepage in the 'user' folder
                $_SESSION['status'] = "You are already logged in as a customer!";
                $_SESSION['status_code'] = "error";
                header("Location: /Arts/user/index.php");  // Adjust path for user folder
                exit;
                break;
            case 1: // Admin
                // Redirect admin to the dashboard in the 'admin' folder
                $_SESSION['status'] = "You are already logged in as an admin!";
                $_SESSION['status_code'] = "error";
                header("Location: /Arts/admin/dashboard.php");  // Adjust path for admin folder
                exit;
                break;
            case 2: // Employee
                // Redirect employee to the dashboard in the 'admin' folder
                $_SESSION['status'] = "You are already logged in as an employee!";
                $_SESSION['status_code'] = "error";
                header("Location: /Arts/admin/dashboard.php");  // Adjust path for admin folder
                exit;
                break;
            default:
                // If role is unknown, redirect to homepage in the 'user' folder
                $_SESSION['status'] = "Unknown role detected.";
                $_SESSION['status_code'] = "error";
                header("Location: /Arts/user/index.php");  // Adjust path for user folder
                exit;
        }
    }
}
// Display error or success messages
if (isset($_SESSION['error'])) {
    echo "<script>alert('".$_SESSION['error']."');</script>";
    unset($_SESSION['error']); // Clear the error message after displaying it
} elseif (isset($_SESSION['status'])) {
    echo "<script>
        Swal.fire({
            title: '".$_SESSION['status']."',
            icon: '".$_SESSION['status_code']."',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f28123'
        }).then(function() {
            window.location.href = '".$_SESSION['Role_Id'] == 1 ? 'dashboard.php' : ($_SESSION['Role_Id'] == 2 ? 'dashboard.php' : '../user/index.php')."';
        });
    </script>";
    unset($_SESSION['status']); // Clear the success message after displaying it
}

// Login logic
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username to prevent SQL injection
    if (!preg_match("/^[a-zA-Z0-9-_]+$/", $username)) {
        $_SESSION['error'] = 'Invalid username format';
        header('Location: login.php');
        exit;
    }

    // Use prepared statements to fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Check if the entered password matches the stored password
        if ($password === $data['Password']) {
            // Set session variables based on role
            $_SESSION['Id'] = $data['Id'];
            $_SESSION['Username'] = $data['Username'];
            $_SESSION['Role_Id'] = $data['Role_Id'];

            // Redirect based on role
            switch ($data['Role_Id']) {
                case 1: // Admin
                    $_SESSION['Admin_name'] = $data['Username'];
                    $_SESSION['status'] = 'Welcome Admin!';
                    $_SESSION['status_code'] = 'success';
                    header('Location: dashboard.php');
                    break;
                case 2: // Employee
                    $_SESSION['Emp_name'] = $data['Username'];
                    $_SESSION['status'] = 'Welcome Employee!';
                    $_SESSION['status_code'] = 'success';
                    header('Location: dashboard.php');
                    break;
                case 3: // Customer
                    $_SESSION['status'] = 'Welcome Customer!';
                    $_SESSION['status_code'] = 'success';
                    header('Location: ../user/index.php');
                    break;
                default:
                    $_SESSION['error'] = 'Access denied';
                    header('Location: login.php');
            }
        } else {
            // Invalid password
            $_SESSION['error'] = 'Invalid password';
            header('Location: login.php');
        }
    } else {
        // Username not found
        $_SESSION['error'] = 'Username not found';
        header('Location: login.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/logos.png">
    <title>Login</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Mochiy+Pop+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<main class="main-content mt-5">
    <section>
        <div class="page-header min-vh-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h2 class="font-weight-bolder text-heading text-gradient">Welcome back</h2>
                                <p class="mb-0">Enter your email and password to sign in</p>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <label>Username</label>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                                    </div>
                                    <label>Password</label>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="login" class="btn btn-primary w-100 mt-4 mb-0">Log In</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account? <a href="signup.php" class="font-weight-bold" style="color:#F28123;">Sign up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved6.jpg')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>
