<?php

include('connection.php');
include('header.php');
?>

<div class="col-md-12 mb-4 mt-4 ">
<div class="card card-body p-3 ">
        <div class="white_card_header">
          <div class="box_header m-0">
            <div class="row">
              <div class="col-md-10 main-title">
                <h2 >Add Category</h2>
              </div>
              <li class="col-md-2 nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-0"  href="view_cat.php">View Category</a>
              </li>
            </div>
          </div>
        </div>
        <div class="white_card_body">
          <div class="card-body">
            <form method="post">
              <div class="row ">
                <div class="col-md-12 mb-5">
                  <label class="form-label" >Category Name</label>
                  <input type="text" class="form-control" name="cat_name"  placeholder="Enter Category Name" style=" width:60%;">
                </div>
                <div class="col-md-12 mb-5">
                  <label class="form-label" >Status</label>
                  <select  class="form-control" name="cat_status" style=" width:30%;">
                    <option disabled selected>---Choose Status---</option>
                    <option>Active</option>
                    <option>Deactive</option>
                  </select>
                </div>
           
              </div>
              <button type="submit" class="btn btn-primary" name="category">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>

    </div>
</div>

<?php

include('footer.php');

if (isset($_POST['category'])) {
    $name = $_POST['cat_name'];
    $status = $_POST['cat_status'];

    if (!preg_match("/^[a-zA-Z0-9\s]+$/", $name)) {
        // Setting session variables for SweetAlert
        $_SESSION['status'] = 'Invalid Category name. Only letters, numbers, and spaces are allowed.';
        $_SESSION['status_code'] = 'error';
    } else {
        $q = "INSERT INTO add_category (Category, Status) VALUES ('$name', '$status')";
        $result = mysqli_query($conn, $q);

        if ($result) {
            // Setting session variables for SweetAlert on success
            $_SESSION['status'] = 'Category Added Successfully';
            $_SESSION['status_code'] = 'success';
        } else {
            // Setting session variables for SweetAlert on error
            $_SESSION['status'] = 'Error adding category: ' . mysqli_error($conn);
            $_SESSION['status_code'] = 'error';
        }
    }
}

?>

<?php
// Check if SweetAlert status is set and display it
if (isset($_SESSION['status']) && $_SESSION['status']) {
    ?>
    <script src="assets/plugins/sweetalert/sweetalert.js"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
            confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            window.location.href = 'add_cat.php'; // Redirect after the alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>