<?php
include('connection.php');
session_start();

// Handle Add to Cart logic
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $picture = 'default.jpg'; // You may modify this to be dynamic based on the product image

    // Check if product exists in the database
    $query = "SELECT * FROM add_product WHERE Id = $product_id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['status'] = 'Invalid product. Please try again.';
        $_SESSION['status_code'] = 'error';
    } else {
        // Check if user is logged in or use session ID
        $user_id = isset($_SESSION['Id']) ? $_SESSION['Id'] : null;
        $session_id = $user_id ? null : session_id();

        // Check if product is already in the cart
        $query = "SELECT * FROM cart WHERE Product_Id = $product_id AND (User_Id = '$user_id' OR Session_Id = '$session_id')";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Update the quantity if the product is already in the cart
            $query = "UPDATE cart SET Quantity = Quantity + $quantity WHERE Product_Id = $product_id AND (User_Id = '$user_id' OR Session_Id = '$session_id')";
            if (mysqli_query($conn, $query)) {
                $_SESSION['status'] = 'Product quantity updated in the cart.';
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = 'Failed to update cart. Please try again.';
                $_SESSION['status_code'] = 'error';
            }
        } else {
            // Add product to the cart if it's not already there
            $query = "INSERT INTO cart (User_Id, Session_Id, Product_Id, Picture, Quantity) VALUES ('$user_id', '$session_id', $product_id, '$picture', $quantity)";
            if (mysqli_query($conn, $query)) {
                $_SESSION['status'] = 'Product added to the cart.';
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = 'Failed to add product to the cart. Please try again.';
                $_SESSION['status_code'] = 'error';
            }
        }
    }

    // Redirect back to the product info page with status
    header('Location: product-info.php?id=' . $product_id);
    exit();
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
