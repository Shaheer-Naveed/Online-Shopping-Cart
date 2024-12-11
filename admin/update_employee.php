<?php
include('connection.php');
include('header.php');

if (isset($_POST['update'])) {
    $u_id = $_POST['u_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to update employee details
    $query = "UPDATE employee SET Username = '$username', Email = '$email', Password = '$password' WHERE Id = $u_id";
    $update_result = mysqli_query($conn, $query);

    // SQL query to update the corresponding user in the 'users' table
    $update_user_query = "UPDATE users SET Username = '$username', Email = '$email', Password = '$password' WHERE Id = $u_id";
    $update_user_result = mysqli_query($conn, $update_user_query);

    // Set the SweetAlert notification message
    if ($update_result && $update_user_result) {
        $_SESSION['status'] = 'Employee and User updated successfully!';
        $_SESSION['status_code'] = 'success'; // Success alert
    } else {
        $_SESSION['status'] = 'Error updating employee or user.';
        $_SESSION['status_code'] = 'error'; // Error alert
    }

    // Redirect to trigger the alert
    echo "<script>window.location.href = 'update_employee.php';</script>";
    exit();
}

// Show SweetAlert if session variables are set
if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                title: '" . $_SESSION['status'] . "',
                icon: '" . $_SESSION['status_code'] . "',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'employee.php'; // Redirect after alert
            });
          </script>";
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>

<div class="mb-4 mt-4">
  <div class="card card-body p-3">
        <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="row">
                        <div class="col-md-10 main-title">
                            <h3 class="font-weight-bold">Update Employee</h3>
                        </div>
                        <li class="col-md-2 nav-item d-flex align-items-center">
                        <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="employee.php">View Employee</a>
                        </li>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                <?php
            // Display update form when an "update" action is requested
            if (isset($_GET['update'])) {
                $update_id = $_GET['update'];
                $query = "SELECT * FROM employee WHERE Id = $update_id";
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);
            ?>
                    <h4 class="card-title mt-4 ">Update Employee</h4>
                    <form method="post" class="">
                        <input type="hidden" name="u_id" value="<?php echo $user['Id']; ?>">
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $user['Username']; ?>" style="width:60%;">
                        </div>
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $user['Email']; ?>" style="width:60%;">
                        </div>
                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="<?php echo $user['Password']; ?>" style="width:60%;">
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>

            <?php } ?>
                </div>
        </div>            
    </div>            
</div>

<?php
include('footer.php');
?>
