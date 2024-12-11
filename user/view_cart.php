<?php
include('connection.php'); // Include the database connection
include('header.php'); // Include the header file
// Define $result for the cart query
$result = null;

// Check if the user is logged in or if it's a guest
if (isset($_SESSION['Id'])) {
    // If logged in, use the User_Id
    $user_id = $_SESSION['Id'];
    $sql = "SELECT c.*, p.Product_Name, p.Price, p.Product_Image FROM cart c
            JOIN add_product p ON c.Product_Id = p.Id
            WHERE c.User_Id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing query: ' . $conn->error); // Handle any MySQL prepare errors
    }
    $stmt->bind_param("i", $user_id);
} else {
    // If not logged in, use the Session_Id for guest users
    $session_id = session_id();
    $sql = "SELECT c.*, p.Product_Name, p.Price, p.Product_Image FROM cart c
            JOIN add_product p ON c.Product_Id = p.Id
            WHERE c.Session_Id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing query: ' . $conn->error); // Handle any MySQL prepare errors
    }
    $stmt->bind_param("s", $session_id);
}

// Execute the query and check for errors
$stmt->execute();
if ($stmt->errno) {
    die('Error executing query: ' . $stmt->error); // Capture and display query errors
}
$result = $stmt->get_result();

// Check if the query was successful
if ($result === false) {
    die('Error retrieving results: ' . $conn->error); // Capture any result fetching errors
}

if (isset($_GET['remove_i'])) {
    $product_id = $_GET['remove_i'];

    // Remove the product from the cart
    $sql = "DELETE FROM cart WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing delete query: ' . $conn->error); // Handle MySQL prepare error
    }

    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    // Set session message for SweetAlert based on success or failure
    if ($stmt->affected_rows > 0) {
        $_SESSION['status'] = 'Item removed successfully!';
        $_SESSION['status_code'] = 'success';
    } else {
        $_SESSION['status'] = 'Failed to remove item!';
        $_SESSION['status_code'] = 'error';
    }

    // Redirect back to the cart page after action
    header('Location: cart.php');
    exit();
}
?>

<!-- SweetAlert Integration -->
<script src="assets/plugins/sweetalert/sweetalert.js"></script>
<script>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['status_code'])): ?>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
        }).then(function() {
            window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>'; // Redirect after the alert
        });
        <?php
        // Clear session message after showing alert
        unset($_SESSION['status'], $_SESSION['status_code']);
        ?>
    <?php endif; ?>
</script>

<!-- Cart Section -->
<div class="cart-section mt-150 mb-150">
    <div class="container"> 
        <div class="row">
        <div class="col-lg-4 col-md-12 ">
        <div class="section-title text-center">	
						<h3><span class="orange-text">Your </span> Cart</h3>
					</div>
        </div>
    </div> 
        <div class="row">
      
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <form action="cart.php" method="POST">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-no">No.</th>
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalPrice = 0;
                                $counter = 1; // Initialize counter for sequence number
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $total = $row['Quantity'] * $row['Price'];
                                        $totalPrice += $total;
                                        // Handle image path correctly
                                        $productImage = !empty($row['Product_Image']) ? '../admin/' . $row['Product_Image'] : '../admin/default.jpg';
                                        ?>
                                        <tr class="table-body-row">
                                            <!-- Display sequential number in the "No." column -->
                                            <td class="product-no"><?php echo $counter++; ?></td> <!-- Increment the counter for each row -->
                                            <td class="product-image">
                                                <img src="<?php echo $productImage; ?>" alt="<?php echo $row['Product_Name']; ?>" style="height:50px;width:100px;" />
                                            </td>                                                  
                                            <td class="product-name"><?php echo $row['Product_Name']; ?></td>
                                            <td class="product-price">Rs:<?php echo number_format($row['Price'], 2); ?></td>                    
                                            <td class="product-quantity"><?php echo number_format($row['Quantity']); ?></td>                    
                                            <td class="product-total">Rs:<?php echo number_format($total, 2); ?></td>
                                            <td class="product-remove">
                                                <form action="cart.php" method="POST">
                                                    <input type="hidden" name="product_id" value="<?php echo $row['Id']; ?>"> <!-- Pass the product ID correctly -->
                                                    <button class="boxed-btn" name="remove_from_cart" type="submit">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No items in your cart</td></tr>";
                                }
                                ?>
                            </tbody>

                        </table>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Total</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="total-data">
                                <td><strong>Subtotal: </strong></td>
                                <td>Rs:<?php echo number_format($totalPrice, 2); ?></td>
                            </tr>
                            <tr class="total-data">
                                <td><strong>Total: </strong></td>
                                <td>Rs:<?php echo number_format($totalPrice , 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="cart-buttons">
                        <a href="checkout.php" class="boxed-btn black">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Cart Section -->

<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

<?php
include('footer.php'); // Include the footer
?>
