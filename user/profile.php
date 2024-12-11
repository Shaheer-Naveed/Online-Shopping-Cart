<?php
include('connection.php');
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['Id'])) {
    echo "<script>alert('Please log in to view your profile.'); window.location.href='../admin/login.php';</script>";
    exit;
}

// Fetch user details if ID is provided and the request is a GET request
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];  // Get user ID from the URL
    $query = "SELECT * FROM users WHERE Id = $edit_id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $profile = mysqli_fetch_assoc($result);
    
    if (!$profile) {
        echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
        exit;
    }
}

// After updating the profile, set the status and redirection URL
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (strpos($username, ' ') !== false) {
        $_SESSION['status'] = 'Username cannot contain spaces.';
        $_SESSION['status_code'] = 'error';
        $_SESSION['redirect_url'] = "profile.php?id=$id";  
        header('Location: ' . $_SESSION['redirect_url']);
        exit;
    }

    // Update user table
    $update_user_query = "
        UPDATE users
        SET Username = '$username', Email = '$email', Password = '$password'
        WHERE Id = $id";
    
    if (mysqli_query($conn, $update_user_query)) {
        // Check if the user is a customer
        $role_check_query = "SELECT Role_Id FROM users WHERE Id = $id";
        $role_result = mysqli_query($conn, $role_check_query);
        $role_row = mysqli_fetch_assoc($role_result);

        if ($role_row['Role_Id'] == 3) { // If Role_Id = 3 (customer)
            // Update customer table
            $update_customer_query = "
                UPDATE customers
                SET Username = '$username', Email = '$email', Password = '$password'
                WHERE Id = $id";
            if (!mysqli_query($conn, $update_customer_query)) {
                $_SESSION['status'] = 'Error updating customer profile: ' . mysqli_error($conn);
                $_SESSION['status_code'] = 'error';
                $_SESSION['redirect_url'] = "profile.php?id=$id";  
                header('Location: ' . $_SESSION['redirect_url']);
                exit;
            }
        }
        $_SESSION['status'] = 'Profile updated successfully!';
        $_SESSION['status_code'] = 'success';
        $_SESSION['redirect_url'] = "profile.php?id=$id";  
        header('Location: ' . $_SESSION['redirect_url']);
        exit;
    } else {
        $_SESSION['status'] = 'Error updating user profile: ' . mysqli_error($conn);
        $_SESSION['status_code'] = 'error';
        $_SESSION['redirect_url'] = "profile.php?id=$id";  
        header('Location: ' . $_SESSION['redirect_url']);
        exit;
    }
}

?>

 <body>
    <div class="contact-from-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5 mb-lg-0">
                    <div class="section-title">
                       <h1>Welcome,<span class="orange-text"><?php echo ($profile['Username']); ?></span></h1>
                    </div>
                    <div id="form_status"></div>
                    <div class="contact-form">
                        <form method="POST" action="profile.php">
                            <input type="hidden" name="id" value="<?php echo $profile['Id']; ?>">
                            <p>
                            <label>Name</label>
                            <br>
                                <input type="text"  name="username" value="<?php echo $profile['Username']; ?>" placeholder="Username" required>
                            </p>
                            <p>
                            <label>Email</label>
                            <br>
                                <input type="email"  name="email" value="<?php echo $profile['Email']; ?>" placeholder="Email" readonly>
                            </p>
                            <p> 
                                <label>Password</label>
                                <br>
                                <input type="text"  name="password" value="<?php echo $profile['Password']; ?>" placeholder="Password" required>
                            </p>
                            <p><input type="submit" value="Update" name="update" class="btn btn-dark"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include('footer.php'); ?>

<?php
// Check if SweetAlert status is set and display it
if (isset($_SESSION['status']) && $_SESSION['status']) {
    $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'profile.php'; // Default fallback redirection URL
    ?>
    <script src="assets/plugins/sweetalert/sweetalert.js"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>", // 'success' or 'error'
            button: "OK",
            customClass: {
            confirmButton: 'swal-confirm-button' // Add a custom class to the confirm button
        },
        willOpen: () => {
            // Apply custom color to the confirm button
            const confirmButton = document.querySelector('.swal-confirm-button');
            if (confirmButton) {
                confirmButton.style.backgroundColor = '#F28123'; // Set the background color
                confirmButton.style.borderColor = '#F28123'; // Optional: Set the border color
                confirmButton.style.color = 'white'; // Set text color (optional)
            }
        }
        }).then(function() {
            if ("<?php echo $_SESSION['action']; ?>" === 'update') {
            window.location.href = 'profile.php'; // Redirect to the profile page
        }
        });
    </script>
    <?php
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
    unset($_SESSION['redirect_url']);
}
?>



<?php
// Cleanup invalid records in customers table (optional)
$cleanup_query = "
    DELETE FROM customers
    WHERE Role_Id != 3";
mysqli_query($conn, $cleanup_query);

// Ensure all current customers exist in the customers table
$sync_customers_query = "
    INSERT INTO customers (Id, Username, Email, Password, Role_Id)
    SELECT Id, Username, Email, Password, Role_Id
    FROM users
    WHERE Role_Id = 3
    ON DUPLICATE KEY UPDATE
    Username = VALUES(Username),
    Email = VALUES(Email),
    Password = VALUES(Password)";
mysqli_query($conn, $sync_customers_query);
?>