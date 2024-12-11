<?php
include('connection.php');
include('header.php');
?>

<div class="col-md-12 mb-4 mt-4">
    <div class="card card-body p-3">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="row">
                    <div class="col-md-10 main-title">
                        <h2 class="font-weight-bold">Add Sub Category</h2>
                    </div>
                    <li class="col-md-2 nav-item d-flex align-items-center">
                        <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="view_sub_cat.php">View Sub Category</a>
                    </li>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <label class="form-label">Category Name</label>
                            <select name="p_cat" class="form-control" style="width:60%;">
                                <option>Select Category</option>
                                <?php
                                $sql = "SELECT * FROM add_category";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-5">
                            <label class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" name="cat_name" placeholder="Enter Sub Category Name" style="width:60%;">
                        </div>
                        <div class="col-md-12 mb-5">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="cat_status" style="width:30%;">
                                <option disabled selected>---Choose Status---</option>
                                <option>Active</option>
                                <option>Deactive</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="sub_cat">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');

if (isset($_POST['sub_cat'])) {
    $p_cat_id = $_POST['p_cat'];    
    $name = $_POST['cat_name'];      
    $status = $_POST['cat_status'];  

    if (!preg_match("/^[a-zA-Z0-9\s]+$/", $name)) {
        echo "<script>alert('Invalid Sub Category name. Only letters, numbers, and spaces are allowed.');</script>";
    } else {
        $sql = "SELECT Category FROM add_category WHERE Id = '$p_cat_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $p_cat_name = $row['Category'];  

            $q = "INSERT INTO add_sub_category (Parent_Category, Category, Status) 
                  VALUES ('$p_cat_name', '$name', '$status')";

            if (mysqli_query($conn, $q)) {
                $_SESSION['status'] = "Sub Category Added Successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Error adding sub category: " . mysqli_error($conn);
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "Parent Category not found";
            $_SESSION['status_code'] = "error";
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
            window.location.href = 'add_sub_cat.php'; // Redirect after the alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
