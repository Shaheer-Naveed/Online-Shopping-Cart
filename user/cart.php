<?php
session_start();
include('connection.php'); // Include your database connection

// Debugging: Display PHP errors (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $picture = $_POST['picture'] ?? 'default.jpg';
    $session_id = session_id();
    $user_id = $_SESSION['Id'] ?? null; // User ID, or null if not logged in

    // If the user is logged in, use User_Id, otherwise use Session_Id for guests
    if ($user_id) {
        // For logged-in users, use User_Id in the cart
        $check_query = "SELECT * FROM cart WHERE Product_Id = '$product_id' AND User_Id = '$user_id'";
    } else {
        // For guest users, use Session_Id in the cart
        $check_query = "SELECT * FROM cart WHERE Product_Id = '$product_id' AND Session_Id = '$session_id'";
    }

    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Update product quantity if it already exists in the cart
        if ($user_id) {
            $update_query = "UPDATE cart SET Quantity = Quantity + '$quantity' WHERE Product_Id = '$product_id' AND User_Id = '$user_id'";
        } else {
            $update_query = "UPDATE cart SET Quantity = Quantity + '$quantity' WHERE Product_Id = '$product_id' AND Session_Id = '$session_id'";
        }
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            $_SESSION['status'] = "Product quantity updated in cart!";
            $_SESSION['status_code'] = "success";
            $_SESSION['action'] = 'add_to_cart';  // Set the action
        } else {
            $_SESSION['status'] = "Failed to update quantity!";
            $_SESSION['status_code'] = "error";
        }
    } else {
        // Insert new product into cart
        if ($user_id) {
            // For logged-in users, set User_Id and remove Session_Id
            $insert_query = "INSERT INTO cart (User_Id, Session_Id, Product_Id, Picture, Quantity) 
                             VALUES ('$user_id', NULL, '$product_id', '$picture', '$quantity')";
        } else {
            // For guest users, use Session_Id
            $insert_query = "INSERT INTO cart (User_Id, Session_Id, Product_Id, Picture, Quantity) 
                             VALUES (NULL, '$session_id', '$product_id', '$picture', '$quantity')";
        }
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            $_SESSION['status'] = "Product added to cart!";
            $_SESSION['status_code'] = "success";
            $_SESSION['action'] = 'add_to_cart';  // Set the action
        } else {
            $_SESSION['status'] = "Failed to add product to cart!";
            $_SESSION['status_code'] = "error";
        }
    }

    // Redirect to avoid form resubmission and trigger SweetAlert
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Remove Item from Cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];

    // Remove the product from the cart
    $q = "DELETE FROM cart WHERE Id = '$product_id'";
    $result = mysqli_query($conn, $q);

    if ($result) {
        // Success message
        $_SESSION['status'] = "Item removed successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['action'] = 'remove_from_cart';  // Set the action
    } else {
        // Error message
        $_SESSION['status'] = "Failed to remove item!";
        $_SESSION['status_code'] = "error";
    }

    // Redirect to avoid form resubmission and show SweetAlert
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Display SweetAlert if there's a session status
if (isset($_SESSION['status'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "<?php echo $_SESSION['status']; ?>",
                icon: "<?php echo $_SESSION['status_code']; ?>",
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: 'swal-confirm-button' // Add a custom class to the confirm button
                },
                willOpen: () => {
                    // Apply custom color to the confirm button
                    const confirmButton = document.querySelector('.swal-confirm-button');
                    if (confirmButton) {
                        confirmButton.style.backgroundColor = '#F28123'; // Set background color
                        confirmButton.style.borderColor = '#F28123'; // Optional: Set the border color
                        confirmButton.style.color = 'white'; // Set text color (optional)
                    }
                }
            }).then(() => {
                // Redirect based on action
                const action = "<?php echo $_SESSION['action']; ?>";
                if (action === 'remove_from_cart') {
                    window.location.href = 'view_cart.php'; // Redirect to view_cart.php
                } else if (action === 'add_to_cart') {
                    window.location.href = 'shop.php'; // Redirect to shop.php
                }
            });
        </script>
    </body>
    </html>
    <?php 
    unset($_SESSION['status']); // Clear session status to avoid duplicate alerts
    unset($_SESSION['status_code']);
    unset($_SESSION['action']); // Clear the action after the alert
}
?>
