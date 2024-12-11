<?php
include('connection.php');
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['Id'])) {
    echo "<script>alert('Please log in to view your profile.'); window.location.href='login.php';</script>";
    exit;
}

// Fetch user details (admin or employee) if ID is provided and the request is a GET request
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];  // Get user ID from the URL
} else {
    $edit_id = $_SESSION['Id']; // Use the logged-in user's ID if no ID is provided in the URL
}

$query = "SELECT * FROM users WHERE Id = $edit_id LIMIT 1";
$result = mysqli_query($conn, $query);
$profile = mysqli_fetch_assoc($result);

if (!$profile) {
    echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
    exit;
}

// Update profile if form is submitted via POST
if (isset($_POST['update'])) {
    $id = $_POST['id']; // Get the ID from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input (no spaces in username)
    if (strpos($username, ' ') !== false) {
        echo "<script>alert('Username cannot contain spaces.'); window.location.href='profile.php?id=$id';</script>";
        exit;
    }

    // Update the users table
    $update_user_query = "
        UPDATE users
        SET Username = '$username', Email = '$email', Password = '$password'
        WHERE Id = $id";
    if (mysqli_query($conn, $update_user_query)) {
        // Check Role_Id to determine where to update
        $role_check_query = "SELECT Role_Id FROM users WHERE Id = $id";
        $role_result = mysqli_query($conn, $role_check_query);
        $role_row = mysqli_fetch_assoc($role_result);

        if ($role_row['Role_Id'] == 2) { // If Role_Id = 2 (employee)
            // Update the employees table
            $update_employee_query = "
                UPDATE employee
                SET Username = '$username', Email = '$email', Password = '$password'
                WHERE Id = $id";
            if (mysqli_query($conn, $update_employee_query)) {
                // SweetAlert notification for success
                echo "<script>
                        Swal.fire({
                            title: 'Employee profile updated successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = 'profile.php?id=$id'; // Redirect after alert
                        });
                      </script>";
            } else {
                // SweetAlert notification for error
                echo "<script>
                        Swal.fire({
                            title: 'Error updating employee profile: " . mysqli_error($conn) . "',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                      </script>";
            }
        } else {
            // For admin (Role_Id = 1), no updates in the employees table
            echo "<script>
                    Swal.fire({
                        title: 'Admin profile updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'profile.php?id=$id'; // Redirect after alert
                    });
                  </script>";
        }
    } else {
        // SweetAlert notification for update failure
        echo "<script>
                Swal.fire({
                    title: 'Error updating user profile: " . mysqli_error($conn) . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->

<?php
// Check if the 'status' and 'message' query parameters are set in the URL
if (isset($_GET['status']) && isset($_GET['message'])) {
    $status = $_GET['status'];
    $message = urldecode($_GET['message']);
    ?>
    
    <script>
        // Trigger the SweetAlert notification
        Swal.fire({
            title: "<?php echo $message; ?>", // Show message
            icon: "<?php echo $status; ?>", // success or error icon
            confirmButtonText: "OK",
            confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            window.location.href = 'profile.php'; // Redirect after the alert
        });
    </script>
    
<?php
}
?>




<div class="card card-body p-3">
    <div class="white_card_header">
        <div class="box_header m-0">
            <div class="row">
                <div class="col-md-12 main-title">
                    <h2>Your Profile</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="white_card_body">
        <?php if (!empty($profile)): ?>
            <div class="section-title my-3">
                <h2>Welcome, <?php echo $profile['Username']; ?></h2>
            </div>
            <form method="POST" action="profile.php">
                <input type="hidden" name="id" value="<?php echo $profile['Id']; ?>">
                <div class="col-md-12 my-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" style="width:70%;" value="<?php echo $profile['Username']; ?>" placeholder="Username" required>
                </div>
                <div class="col-md-12 my-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" style="width:70%;" value="<?php echo $profile['Email']; ?>" placeholder="Email" required>
                </div>   
                <div class="col-md-12 my-3">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" class="form-control" style="width:70%;" value="<?php echo $profile['Password']; ?>" placeholder="Password" required>
                </div>
                <input type="submit" value="Update" name="update" class="btn btn-primary">
            </form>
        <?php else: ?>
            <h1>User not found</h1>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>


<?php
// Cleanup invalid records in employees table (optional)
$cleanup_query_employees = "
    DELETE FROM employee
    WHERE Role_Id != 2";
mysqli_query($conn, $cleanup_query_employees);

// Sync employees (Role_Id = 2) into the employees table
$sync_employees_query = "
    INSERT INTO employee (Id, Username, Email, Password, Role_Id)
    SELECT Id, Username, Email, Password, Role_Id
    FROM users
    WHERE Role_Id = 2
    ON DUPLICATE KEY UPDATE
    Username = VALUES(Username),
    Email = VALUES(Email),
    Password = VALUES(Password)";
mysqli_query($conn, $sync_employees_query);
?>