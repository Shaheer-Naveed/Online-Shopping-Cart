<?php
include('connection.php');
include('header.php');
?> 

<div class="col-md-12 mb-4 mt-4 ">
    <div class="card card-body p-3 ">
        <div class="row">
            <div class="col-md-10 main-title">
                <h2>Add Product</h2>
            </div>
            <li class="col-md-2 nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="view_product.php">View Product</a>
            </li>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="pro_name" placeholder="Enter Product Name">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label">Product Category</label>
                            <select name="pro_cat" class="form-control">
                                <option disabled selected>---Select Category---</option>
                                <?php
                                $sql = "SELECT * FROM add_category";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label">Product Sub Category</label>
                            <select name="pro_sub_cat" class="form-control">
                                <option disabled selected>---Select Sub Category---</option>
                                <?php
                                $sql = "SELECT * FROM add_sub_category";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="pro_img">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label">Product Price</label>
                            <input type="text" class="form-control" name="pro_price" placeholder="Enter Product Price">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label">Warranty</label>
                            <input type="text" class="form-control" name="pro_warranty" placeholder="Enter Product Warranty">
                        </div>
                        <div class="col-md-12 mb-5">
                            <label class="form-label">Product Description</label>
                            <textarea name="pro_des" rows="3" class="form-control" placeholder="Enter Product Description" style="word-wrap: break-word; width: 100%; resize: vertical;"></textarea>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary" name="product">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');

if (isset($_POST['product'])) {
    $pro_name = $_POST['pro_name'];
    $pro_cat = $_POST['pro_cat'];
    $pro_sub_cat = $_POST['pro_sub_cat'];
    $price = $_POST['pro_price']; 
    $warranty = $_POST['pro_warranty'];
    $code = mt_rand(1, 99999);  
    $pro_id = "56" . str_pad($code, 5, "0", STR_PAD_LEFT);  
    $description = $_POST['pro_des'];
    $image_name = $_FILES['pro_img']['name'];
    $temp_name = $_FILES['pro_img']['tmp_name'];
    $image_type = $_FILES['pro_img']['type'];
    $image_size = $_FILES['pro_img']['size'];
    $folder = "image/";

    // Retrieve category name
    $cat_query = "SELECT Category FROM add_category WHERE Id = '$pro_cat'";
    $cat_result = mysqli_query($conn, $cat_query);
    $category_name = mysqli_fetch_assoc($cat_result)['Category'];

    // Retrieve sub-category name
    $sub_cat_query = "SELECT Category FROM add_sub_category WHERE Id = '$pro_sub_cat'";
    $sub_cat_result = mysqli_query($conn, $sub_cat_query);
    $subcategory_name = mysqli_fetch_assoc($sub_cat_result)['Category'];

    if ($image_type == "image/png" || $image_type == "image/jpg" || $image_type == "image/jpeg") {
        $path = $folder . $image_name;

        if (move_uploaded_file($temp_name, $path)) {
            $q = "INSERT INTO add_product(Product_Code, Product_Name, Product_Category, Product_Sub_Category, Price, Warranty, Description, Product_Image) VALUES
            ('$pro_id', '$pro_name', '$pro_cat', '$pro_sub_cat', '$price', '$warranty', '$description', '$path')";
            $result = mysqli_query($conn, $q);

            if ($result) {
                $_SESSION['status'] = 'Product added successfully!';
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = 'Failed to add product to the database.';
                $_SESSION['status_code'] = 'error';
            }
        } else {
            $_SESSION['status'] = 'Failed to upload the image.';
            $_SESSION['status_code'] = 'error';
        }
    } else {
        $_SESSION['status'] = 'Invalid image type. Only PNG, JPG, and JPEG are allowed.';
        $_SESSION['status_code'] = 'error';
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
            window.location.href = 'add_product.php'; // Redirect after the alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>  
