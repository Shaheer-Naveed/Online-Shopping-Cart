<?php
// Include the necessary PHPMailer files
require 'F:\xammp\htdocs\Arts\user\src\PHPMailer.php';
require 'F:\xammp\htdocs\Arts\user\src\SMTP.php';
require 'F:\xammp\htdocs\Arts\user\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Function to generate product code
function generateProductCode() {
    // Starting digit (same for all)
    $startDigit = '5';
    // Five digits that are the same (e.g., 12345)
    $sameDigits = '12345';
    // Remaining 10 digits should be random
    $randomDigits = substr(str_shuffle('0123456789' . time()), 0, 10);// Only take 10 random digits

    // Combine all parts to form the 16-digit code
    return $startDigit . $sameDigits . $randomDigits;
}

include('connection.php');
include('header.php');

// Start session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Authentication check
if (!isset($_SESSION['Username']) || empty($_SESSION['Username'])) {
    // Set the session status for SweetAlert
    $_SESSION['status'] = 'Please login first.';
    $_SESSION['status_code'] = 'warning'; // You can change the status code to 'error' or 'info' if needed

    // JavaScript to show SweetAlert and redirect
    echo "
    <script src='assets/plugins/sweetalert/sweetalert.js'></script>
    <script>
        swal({
            title: '" . $_SESSION['status'] . "',
            icon: '" . $_SESSION['status_code'] . "',
            button: 'OK',
        }).then(function() {
            window.location.href = '../admin/login.php'; // Redirect to login page
        });
    </script>";
    
    // Clear session variables to prevent further issues
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
    exit;  // Stop further execution
}

// Fetch user ID from session
$user_id = mysqli_real_escape_string($conn, $_SESSION['Id']);

$query = "SELECT p.Product_Name as product_name, p.Price as price, c.Quantity 
          FROM cart c
          JOIN add_product p ON c.Product_Id = p.Id
          WHERE c.User_Id = $user_id";

$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($conn)); // More detailed error message
}
// Fetch user email and other details based on the username from the session
$username = mysqli_real_escape_string($conn, $_SESSION['Username']);

// Query to fetch user details
$user_query = "SELECT Email FROM users WHERE Username = '$username' LIMIT 1";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
    $user_email = $user_data['Email'];
}

$subtotal = 0;
$shipping = 50; // Assuming flat shipping rate
?>

<!-- Checkout Section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <!-- Billing Address Accordion -->
                        <div class="card single-accordion">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Billing Address
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="billing-address-form">
                                        <!-- Checkout Form -->
                                        <form id="checkout-form" action="checkout.php" method="post">
                                            <p><input type="text" id="name" name="name" placeholder="Name" value="<?php echo ($_SESSION['Username']); ?>"></p>
                                            <p><input type="email" id="email" name="email" value="<?php echo $user_email; ?>" placeholder="Email" readonly></p>
                                            <p><input type="text" id="address" name="address" placeholder="Address" required></p>
                                            <p><input type="tel" id="phone" name="phone" placeholder="Phone" required></p>
                                            <p> 
                                                <select class="form-control" name="payment" style=" width:30%;" required>
                                                <option disabled selected>---Payment Methods---</option>
                                                <option>Credit Cards</option>
                                                <option>VPP (Value Payable Post)</option>
                                                <option>Cheque</option>
                                                <option>Demand Draft (DD)</option>
                                                </select>
                                            </p>
                                            <button type="submit" id="place-order" class="boxed-btn">Place Order</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-details-wrap">
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Your order Details</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="order-details-body">
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td>Rs:<?php echo number_format($row['price'], 2); ?></td>
                                </tr>
                                <?php 
                                // Calculate subtotal
                                $subtotal += $row['price'] * $row['Quantity']; 
                                ?>
                            <?php } ?>
                        </tbody>
                        <tbody class="checkout-details">
                            <tr>
                                <td>Subtotal</td>
                                <td>Rs:<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>Rs:<?php echo number_format($shipping, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>Rs:<?php echo number_format($subtotal + $shipping, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment']);

    // Check if already redirected
    if (isset($_SESSION['status'])) {
        // Avoid redirection loop
        echo "Form already processed or error occurred";
        exit;  // Prevent further execution
    }

    // Validate form data (check if all fields are filled)
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($payment)) {
        $_SESSION['status'] = 'Please fill all required fields.';
        $_SESSION['status_code'] = 'error';
        header('Location: checkout.php');
        exit;  // Ensure no further code executes after redirection
    }

    // Validate phone and email
    if (!preg_match('/^03[0-9]{9}$/', $phone)) {
        $_SESSION['status'] = 'Invalid phone number.';
        $_SESSION['status_code'] = 'error';
        header('Location: checkout.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'Invalid email address.';
        $_SESSION['status_code'] = 'error';
        header('Location: checkout.php');
        exit;
    }

    // Calculate total value
    $total = $subtotal + $shipping;

    // Generate product code
    $order_code = generateProductCode();

    // Insert order into the database
    $order_query = "INSERT INTO orders (User_Id, Name, Email, Phone, Address, Payment_Method, Subtotal, Shipping, Total, Order_Date, Order_Code) 
                    VALUES ($user_id, '$name', '$email', '$phone', '$address', '$payment', $subtotal, $shipping, $total, NOW(), '$order_code')";

    if (mysqli_query($conn, $order_query)) {
        // Get the inserted order ID for email confirmation
            $order_id = mysqli_insert_id($conn);

        // Clear the cart after placing the order
        $delete_cart_query = "DELETE FROM cart WHERE User_Id = $user_id";
        mysqli_query($conn, $delete_cart_query);

        // Send confirmation email using PHPMailer
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'shaheernaveed2020@gmail.com'; // Your Gmail address
            $mail->Password = 'qick yhpd gzva ulvo'; // The app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender details
            $mail->setFrom('shaheernaveed2020@gmail.com', 'Shaheer'); // From address
            $mail->addAddress($email, $name);  // Recipient's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Your Order at Arts';
            $mail->Body = "
            <p>Dear $name,</p>
            <p>Thank you for shopping with us at Arts! We're thrilled to let you know that your order has been successfully received and is being prepared for shipment. 
            Your order details are as follows:</p>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Product Code:</strong> $order_code</p>
            <p><strong>Total:</strong> Rs " . number_format($total, 2) . "</p>
            <p>Your items will be carefully packed and dispatched soon. You’ll receive a shipping confirmation email with tracking details once your order is on its way.</p>
            <p>If you have any questions or need assistance, please don’t hesitate to reach out to us at arts@gmail.com or call us at +92 1234567890. We’re here to help!</p>
            <p>Thank you for choosing Arts. We hope your purchase brings you creativity, inspiration, and joy.</p>
            <p>Best regards,</p>
            <p>Team Arts</p>
            ";


            $mail->send();

            $_SESSION['status'] = 'Order placed successfully and confirmation email sent.';
            $_SESSION['status_code'] = 'success';
            header('Location: view_cart.php');
            exit; // Stop further execution after redirection
        } catch (Exception $e) {
            $_SESSION['status'] = 'Error sending email: ' . $mail->ErrorInfo;
            $_SESSION['status_code'] = 'error';
            header('Location: checkout.php');
            exit;
        }
    } else {
        $_SESSION['status'] = 'Error placing order.';
        $_SESSION['status_code'] = 'error';
        header('Location: checkout.php');
        exit;  // Ensure no further code executes after redirection
    }
}

?>
