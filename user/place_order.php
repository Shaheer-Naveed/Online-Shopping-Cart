<?php
session_start();
include('connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Server-side validation
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($state) || empty($zip)) {
        echo "<script>alert('Please fill all fields.'); window.location.href='checkout.php';</script>";
        exit;
    }

    // Phone number validation
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Invalid phone number.'); window.location.href='checkout.php';</script>";
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email.'); window.location.href='checkout.php';</script>";
        exit;
    }

    // Fetch cart details for order processing
    $user_id = $_SESSION['Id']; // Assuming user is logged in
    $cart_query = "SELECT p.Product_Name, c.Quantity, p.Price 
                   FROM cart c
                   JOIN add_product p ON c.Product_Id = p.Id
                   WHERE c.User_Id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_query);

    if (!$cart_result) {
        die('Error fetching cart: ' . mysqli_error($conn));
    }

    // Calculate subtotal
    $subtotal = 0;
    $order_items = [];
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $product_name = $row['Product_Name'];
        $quantity = $row['Quantity'];
        $price = $row['Price'];
        $subtotal += $price * $quantity;

        $order_items[] = [
            'product_name' => $product_name,
            'quantity' => $quantity,
            'price' => $price,
        ];
    }

    // Shipping cost (fixed)
    $shipping = 50;
    $total = $subtotal + $shipping;

    // Insert order into `orders` table
    $order_query = "INSERT INTO orders (User_Id, Name, Email, Phone, Address, City, State, Zip, Subtotal, Shipping, Total, Order_Date) 
                    VALUES ('$user_id', '$name', '$email', '$phone', '$address', '$city', '$state', '$zip', '$subtotal', '$shipping', '$total', NOW())";

    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn); // Get last inserted order ID

        // Insert order items into `ordered_items` table
        foreach ($order_items as $item) {
            $product_name = $item['product_name'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $item_query = "INSERT INTO ordered_items (Order_Id, Product_Name, Quantity, Price) 
                           VALUES ('$order_id', '$product_name', '$quantity', '$price')";
            mysqli_query($conn, $item_query);
        }

        // Clear the user's cart
        $clear_cart_query = "DELETE FROM cart WHERE User_Id = '$user_id'";
        mysqli_query($conn, $clear_cart_query);

        // Send confirmation email (optional)
        $subject = "Order Confirmation";
        $message = "Thank you for your order! Your total is $total.";
        $headers = "From: no-reply@yourstore.com";
        mail($email, $subject, $message, $headers);

        // Redirect to a thank-you page
        echo "<script>alert('Order placed successfully!'); window.location.href='thank_you.php';</script>";
    } else {
        echo "<script>alert('Error placing order. Please try again.'); window.location.href='checkout.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script>
        // Checkout.js
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var address = document.getElementById('address').value;
            var city = document.getElementById('city').value;
            var state = document.getElementById('state').value;
            var zip = document.getElementById('zip').value;

            if (name == "" || email == "" || phone == "" || address == "" || city == "" || state == "" || zip == "") {
                alert("Please fill all fields.");
                return false;
            }

            var phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(phone)) {
                alert("Invalid phone number.");
                return false;
            }

            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email.");
                return false;
            }

            return true;
        }

        document.getElementById('place-order').addEventListener('click', function() {
            if (validateForm()) {
                // Submit form
                document.getElementById('checkout-form').submit();
            }
        });
    </script>
</head>
<body>
    <!-- Checkout Form -->
    <form id="checkout-form" action="place_order.php" method="post">
        <p><input type="text" id="name" name="name" placeholder="Name" required></p>
        <p><input type="email" id="email" name="email" placeholder="Email" required></p>
        <p><input type="text" id="phone" name="phone" placeholder="Phone" required></p>
        <p><input type="text" id="address" name="address" placeholder="Address" required></p>
        <p><input type="text" id="city" name="city" placeholder="City" required></p>
        <p><input type="text" id="state" name="state" placeholder="State" required></p>
        <p><input type="text" id="zip" name="zip" placeholder="Zip" required></p>
        <a id="place-order" class="boxed-btn">Place Order</a>
    </form>
</body>
</html>
