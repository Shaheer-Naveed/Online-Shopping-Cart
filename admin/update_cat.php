<?php
include('connection.php');
include('header.php');

// Handle update form submission
if (isset($_POST['update'])) {
    $c_id = $_POST['c_id'];
    $c_name = $_POST['cat_name'];
    $status = $_POST['cat_status'];

    $query = "UPDATE add_category SET Category = '$c_name', Status = '$status' WHERE id = $c_id";
    
    if (mysqli_query($conn, $query)) {
        // Set success message for SweetAlert
        $_SESSION['status'] = "Category updated successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        // Set error message for SweetAlert
        $_SESSION['status'] = "Error updating category.";
        $_SESSION['status_code'] = "error";
    }

    // Redirect to reload the page and show SweetAlert
    echo "<script>window.location.href='view_cat.php';</script>";
    exit(); // Prevent further code execution
}

?>
<!-- SweetAlert Script -->
<?php
// Show SweetAlert2 for update/delete actions
if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            confirmButtonText: 'OK',
            confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            // Optionally, you can redirect or reload the page
            window.location.href = 'view_cat.php'; // Or any page you want to redirect to
        });
    </script>
    <?php
    // Unset the session variables after showing the alert
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>

<!-- Handle form for category update -->
<?php
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $query = "SELECT * FROM add_category WHERE id = $edit_id";
    $result = mysqli_query($conn, $query);
    $cat = mysqli_fetch_assoc($result);
?>
<div class="mb-4 mt-4">
  <div class="card card-body p-3">
    <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="row">
                    <div class="col-md-10 main-title">
                        <h3 class="font-weight-bold">Update Category</h3>
                    </div>
                    <li class="col-md-2 nav-item d-flex align-items-center">
                    <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="view_cat.php">View Category</a>
                    </li>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
            <form method="post">
                <input type="hidden" name="c_id" value="<?php echo $cat['Id']; ?>">
                <div class="form-group mb-3">
                <label>Category</label>
                <input type="text" class="form-control" name="cat_name" value="<?php echo $cat['Category']; ?>" style="width:60%;">
                <label>Status</label>
                <select class="form-control" name="cat_status" style="width:30%;">
                    <option disabled selected>---Choose Status---</option>
                    <option>Active</option>
                    <option>Deactive</option>
                </select>
                </div>
                <button type="submit" name="update" class="btn btn-success">Update</button>
            </form>
            <?php } ?>
    </div>
  </div>
</div>

<?php
include('footer.php');
?>


