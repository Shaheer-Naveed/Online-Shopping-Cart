<?php
include('connection.php');
include('header.php');
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $product_name = $_POST['pro_name'];
    $product_category = $_POST['pro_cat'];
    $product_sub_category = $_POST['pro_sub_cat'];
    $price = $_POST['price'];
    $warranty = $_POST['warranty'];
    $description = $_POST['desc'];
    $current_image = $_POST['current_image']; // Preserve current image path

    // Validate product name
    if (!preg_match("/^[a-zA-Z0-9\s]+$/", $product_name)) {
        $_SESSION['status'] = 'Invalid product name. Only letters, numbers, and spaces are allowed.';
        $_SESSION['status_code'] = 'error';
        echo "<script>window.location.href='view_product.php?update=$id';</script>";
        exit();
    } else {
        // Handle the image upload
        if (!empty($_FILES['pro_img']['name'])) {
            $target_dir = "image/";
            if (!is_dir($target_dir)) {
                error_log("Uploads directory does not exist: " . realpath($target_dir));
                $_SESSION['status'] = 'Uploads directory does not exist.';
                $_SESSION['status_code'] = 'error';
                echo "<script>window.location.href='view_product.php?update=$id';</script>";
                exit();
            }
        
            $target_file = $target_dir . basename($_FILES['pro_img']['name']);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            // Validate allowed types
            $allowed_types = ['jpg', 'jpeg', 'png'];
            if (!in_array($imageFileType, $allowed_types)) {
                $_SESSION['status'] = 'Invalid file type. Only JPG, JPEG, and PNG allowed.';
                $_SESSION['status_code'] = 'error';
                echo "<script>window.location.href='view_product.php?update=$id';</script>";
                exit();
            }
        
            // Debugging output
            error_log("Temporary file path: " . $_FILES['pro_img']['tmp_name']);
            error_log("Target file path: " . $target_file);
        
            // Move uploaded file
            if (move_uploaded_file($_FILES['pro_img']['tmp_name'], $target_file)) {
                $current_image = $target_file; // Update image path
            } else {
                error_log("Failed to move uploaded file to: " . $target_file);
                $_SESSION['status'] = 'Failed to upload new image.';
                $_SESSION['status_code'] = 'error';
                echo "<script>window.location.href='view_product.php?update=$id';</script>";
                exit();
            }
        }
        

        // Update the product in the database
        $update_query = "
            UPDATE add_product 
            SET Product_Name = '$product_name', 
                Product_Category = '$product_category', 
                Product_Sub_Category = '$product_sub_category', 
                Price = '$price', 
                Warranty = '$warranty', 
                Description = '$description', 
                Product_Image = '$current_image'
            WHERE Id = $id";

        $result = mysqli_query($conn, $update_query);

        if ($result) {
            $_SESSION['status'] = 'Product updated successfully!';
            $_SESSION['status_code'] = 'success';
        } else {
            $_SESSION['status'] = 'Failed to update product: ' . mysqli_error($conn);
            $_SESSION['status_code'] = 'error';
        }

        // Redirect to the product view page using JavaScript
        echo "<script>window.location.href='view_product.php';</script>";
        exit();
    }
}
?>

<!-- SweetAlert Script -->
<?php
// Check if SweetAlert status is set and display it
if (isset($_SESSION['status']) && $_SESSION['status']) {
    ?>
    <script src="assets/plugins/sweetalert/sweetalert.js"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>", // Show status message
            icon: "<?php echo $_SESSION['status_code']; ?>", // Show success or error icon
            button: "OK",
        }).then(function() {
            window.location.href = 'view_product.php'; // Redirect after alert
        });
    </script>
    <?php 
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
                        <h3 class="font-weight-bold">Update Product</h3>
                    </div>
                    <li class="col-md-2 nav-item d-flex align-items-center">
                    <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="view_product.php">View Product</a>
                    </li>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
            <?php
                if (isset($_GET['update'])) {
                    $edit_id = $_GET['update'];
                    $query = "SELECT * FROM add_product WHERE Id = $edit_id";
                    $result = mysqli_query($conn, $query);
                    $pro = mysqli_fetch_assoc($result);
                ?>
                    <div class="card-body mt-4">
                    <h4 class="card-title">Update Product</h4>
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $pro['Id']; ?>">
                        <div class="form-group mb-3">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="pro_name" value="<?php echo $pro['Product_Name']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                        <label>Product Category</label>
                        <select name="pro_cat" class="form-control" required>
                            <option disabled selected>---Select Category---</option>
                            <?php
                            $category_query = "SELECT * FROM add_category";
                            $category_result = mysqli_query($conn, $category_query);
                            while ($row = mysqli_fetch_assoc($category_result)) {
                                $selected = ($row['Id'] == $pro['Product_Category']) ? 'selected' : '';
                                echo "<option value='" . $row['Id'] . "' $selected>" . $row['Category'] . "</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="form-group mb-3">
                        <label>Product Sub Category</label>
                        <select name="pro_sub_cat" class="form-control" required>
                            <option disabled selected>---Select Sub Category---</option>
                            <?php
                            $sub_category_query = "SELECT * FROM add_sub_category";
                            $sub_category_result = mysqli_query($conn, $sub_category_query);
                            while ($row = mysqli_fetch_assoc($sub_category_result)) {
                                $selected = ($row['Id'] == $pro['Product_Sub_Category']) ? 'selected' : '';
                                echo "<option value='" . $row['Id'] . "' $selected>" . $row['Category'] . "</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" value="<?php echo $pro['Price']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Warranty</label>
                            <input type="text" class="form-control" name="warranty" value="<?php echo $pro['Warranty']; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>Description</label>
                            <textarea name="desc" rows="5" class="form-control" style="word-wrap: break-word; width: 100%; resize: vertical;"><?php echo $pro['Description']; ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Current Product Image Path</label>
                            <!-- Read-only field to display the current image path -->
                            <input type="text" class="form-control" value="<?php echo $pro['Product_Image']; ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label>Change Product Image</label>
                            <!-- File input for uploading a new image -->
                            <input type="file" class="form-control" name="pro_img">
                            <!-- Hidden input to preserve the current image path -->
                            <input type="hidden" name="current_image" value="<?php echo $pro['Product_Image']; ?>">
                        </div>
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                    </form>
                    </div>
               
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

