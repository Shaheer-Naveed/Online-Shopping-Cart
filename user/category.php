<?php
include('connection.php');
include('header.php');

// Get the category ID from the URL, if set
$cat_id = isset($_GET['id']) ? $_GET['id'] : null;

// If a category ID is provided, fetch the category name
if ($cat_id) {
    $cat = "SELECT Category FROM add_category WHERE id = $cat_id";
    $cat_r = mysqli_query($conn, $cat);
    $cat_data = mysqli_fetch_assoc($cat_r);
} else {
    // Default category name if no category is selected
    $cat_data['Category'] = 'All Products';
}

// Query to get products
$query = "SELECT add_product.Id, add_product.Product_Code, add_product.Product_Name, add_category.Category AS Product_Category, 
          add_sub_category.Category AS Product_Sub_Category, add_product.Price, add_product.Warranty, add_product.Description, 
          add_product.Product_Image 
          FROM add_product 
          JOIN add_category ON add_product.Product_Category = add_category.Id 
          JOIN add_sub_category ON add_product.Product_Sub_Category = add_sub_category.Id";

// If a category ID is selected, filter by category
if ($cat_id) {
    $query .= " WHERE add_product.Product_Category = $cat_id";
}

$result = mysqli_query($conn, $query);
?>

<div class="contact-from-section mt-150 mb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <div class="section-title mb-60 text-center wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
                    <h3 class="mb-5"><span class="orange-text"><?php echo $cat_data['Category']; ?></span></h3>
                </div>
            </div>
        </div>

        <!-- Category Filter Sidebar -->
            <div class="filter text-center mt-3 mb-5">
                    <div class="single-listing ">
                        <div class="select-job-items2">
                            <select name="select2" onchange="redirectToPage()" style="height:5vh;width:20vw;font-family:'Poppins',sans-serif;font-weight:bolder;text-align:center;padding:5px;">
                                <option  disabled selected> ---Select Category---</option>
                                <?php
                                // Fetch all categories for the dropdown
                                $category_query = "SELECT * FROM add_category";
                                $category_result = mysqli_query($conn, $category_query);
                                while ($row = mysqli_fetch_assoc($category_result)) { 
                                    $selected = ($cat_id == $row['Id']) ? 'selected' : '';
                                    echo "<option value='category.php?id={$row['Id']}' $selected>{$row['Category']}</option>";
                                }
                                ?>
                            </select>
                    </div>
                </div>
            </div>

                        <div class="row product-lists">
                        <!-- Product listing within the loop -->
                        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="single-product-item mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                                    <div class="popular-img">
                                        <img src="../admin/<?php echo $data['Product_Image']; ?>" height="300px">
                                    </div>
                                    <h3><?php echo $data['Product_Name']; ?></h3>
                                    <p class="product-price">Rs:<?php echo $data['Price']; ?></p>
                                    <div class="row">
                                        
                                        <div class="col-md-6 ms-5">
                                            <form method="post" action="cart.php">
                                                <input type="hidden" name="product_id" value="<?php echo $data['Id']; ?>"> 
                                                <input type="number" id="quantity-<?php echo $product['Id']; ?>" name="quantity" min="1" value="1" required>
                                                <button class="boxed-btn" name="add_to_cart"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6" style="margin-top:66px;">
                                            <a class="boxed-btn" href="product-info.php?id=<?php echo $data['Id']; ?>"><i class="fas fa-eye"></i> View Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<script>
// Redirect to selected category page
function redirectToPage() {
    var selectedCategory = document.querySelector('select[name="select2"]').value;
    if (selectedCategory) {
        window.location.href = selectedCategory;  // Redirect to the selected category page
    }
}
</script>
