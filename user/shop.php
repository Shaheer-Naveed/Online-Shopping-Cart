<?php
include('connection.php');
include('header.php');

// Initialize the search query variable
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Modify the SQL query to filter based on the search query
$query = "SELECT add_product.Id, add_product.Product_Code, add_product.Product_Name, add_category.Category AS Product_Category, add_sub_category.Category AS Product_Sub_Category, add_product.Price, add_product.Warranty, add_product.Description, add_product.Product_Image 
          FROM add_product
          JOIN add_category ON add_product.Product_Category = add_category.Id
          JOIN add_sub_category ON add_product.Product_Sub_Category = add_sub_category.Id
          WHERE add_product.Product_Name LIKE '%$searchQuery%'"; // Filter by product name
$result = mysqli_query($conn, $query);

// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Count the number of products found
$productCount = mysqli_num_rows($result);
?>
<!-- products -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Our</span> Shop</h3>
                </div>

                <!-- Search Form -->
                <form class="d-flex w-100 my-5" role="search" method="GET" action="">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" aria-label="Search" style="height:50px;border:2px solid orange;font-family:'Poppins',sans-serif;">
                    <button class="boxed-btn mx-3" type="submit">Search</button>
                </form>

                <?php
                // Display message if no products are found
                if ($searchQuery && $productCount == 0) {
                    echo "<h1>No Products Found</h1>";
                }
                ?>
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
                            <div class="col-md-6" style="margin-top:62px;">
                                <a class="boxed-btn" href="product-info.php?id=<?php echo $data['Id']; ?>"><i class="fas fa-eye"></i> View Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

<?php
include('footer.php');
?>