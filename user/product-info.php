<?php
include('connection.php');
include('header.php');

// Check if a product ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']); // Sanitize input to prevent SQL injection

    // Query to fetch the product details
    $sql = "SELECT * FROM add_product WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id); // Bind the product ID to the query

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch the product details
        } else {
            echo "<p>Product not found.</p>";
            exit;
        }
    } else {
        echo "<p>Error retrieving product details.</p>";
        exit;
    }
} else {
    echo "<p>Invalid product ID.</p>";
    exit;
}
?>

<?php
// Check if SweetAlert status is set and display it
if (isset($_SESSION['status']) && $_SESSION['status']) {
    ?>
    <!-- Include SweetAlert 2 (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Show SweetAlert based on session data
        Swal.fire({
            title: "<?php echo $_SESSION['status']; ?>", // The message to display
            icon: "<?php echo $_SESSION['status_code']; ?>", // The type of icon (success, error, etc.)
            confirmButtonText: 'OK',
        }).then(function() {
            // Redirect to a different page after the alert
            window.location.href = '<?php echo isset($_SESSION['status_code']) && $_SESSION['status_code'] == 'success' ? 'shop.php' : 'product-info.php?id=' . $_GET['id']; ?>';
        });
    </script>
    <?php
    // Clear the session status variables after displaying the alert
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>


<div class="product-section mt-150 mb-150">
    <div class="section-title text-center">    
        <h3><span class="orange-text">Product</span> Details</h3>
    </div>
    <div class="row bg-light">
        <div class="container my-5">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6 mt-5">
                    <?php
                    $productImage = !empty($row['Product_Image']) ? '../admin/' . $row['Product_Image'] : '../admin/default.jpg';
                    ?>
                    <img src="<?php echo ($productImage); ?>" alt="<?php echo ($row['Product_Name']); ?>" class="img-fluid" style="height:60vh;width:100vw;">
                </div>

                <!-- Product Details -->
                <div class="col-md-6">
                    <div class="section-title text-center">
                        <h3 style="font-size:3rem;"><?php echo ($row['Product_Name']); ?></h3>
                    </div>
                    <div>
                        <h3 class="my-3" style="color:#F28123;">Description</h3>
                        <p style="font-family:'Poppins',sans-serif;font-weight:bolder; font-size:1.3rem;"><?php echo($row['Description']); ?></p>
                        <hr>
                    </div>
                    <div>
                        <h3 class="my-3" style="color:#F28123;">Price</h3>
                        <span style="font-family:'Poppins',sans-serif;font-weight:bolder; font-size:1.3rem;">Rs: <?php echo ($row['Price']); ?></span>
                        <hr>
                    </div>

                    <!-- Add to Cart Form -->
                    <form method="post" action="pro_cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['Id']; ?>"> 
                        <input type="number" id="quantity-<?php echo $product['Id']; ?>" name="quantity" min="1" value="1" required>
                        <button class="boxed-btn" name="add_to_cart"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
