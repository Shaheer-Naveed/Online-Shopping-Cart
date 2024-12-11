<?php
session_start(); // Start the session
ob_start(); // Start output buffering
include('connection.php');

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialize the cart array if it's not set
}

// Helper function to check if the user is a customer
function isCustomer() {
    return isset($_SESSION['Username']) && isset($_SESSION['Role_Id']) && $_SESSION['Role_Id'] == 3;
}

// SweetAlert Logic
$status = $status_code = null;
if (isset($_SESSION['status']) && $_SESSION['status']) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];
    unset($_SESSION['status'], $_SESSION['status_code']);
}

// When adding an item to the cart
if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Default to 1 if not set

    // Check if item is already in the cart
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity; // Increase quantity if item already exists
    } else {
        $_SESSION['cart'][$item_id] = $quantity; // Otherwise, add item with the quantity
    }

    // Redirect to refresh the page and update the cart count
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Calculate the total number of items in the cart (considering quantity)
$cart_count = array_sum($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arts</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/icon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Mochiy+Pop+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <!-- Additional Styles -->
    <link rel="stylesheet" href="assets/css/main.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
	<!-- icon -->
	<link rel="icon" type="image/png" href="assets/img/icon.png">

    <style>
        .swal2-confirm {
            background-color: #F28123 !important;
            border:2px solid #F28123 !important;
            color: white !important;
            font-weight: bold !important;
            padding: 10px 20px !important;
            border-radius: 5px !important;
        }
        .top-header-area {
            background-color: #000000;
        }

        <?php if (basename($_SERVER['PHP_SELF']) === 'index.php') { ?>
        .top-header-area {
            background-color: transparent;
        }
        nav.main-menu ul ul.sub-menu li form button:hover {
            color: #f28123;
        }

        <?php } ?>
    </style>
</head>
<body>
    <!-- SweetAlert Notification -->
    <?php if (!empty($status) && !empty($status_code)): ?>
    <script>
        Swal.fire({
            title: "<?php echo $status; ?>",
            icon: "<?php echo $status_code; ?>",
            confirmButtonText: "OK",
        }).then(() => {
            window.location.href = "index.php";
        });
    </script>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- Logo -->
                        <div class="site-logo">
                            <a href="index.php">
                                <img src="assets/img/logo.png" alt="Logo">
                            </a>
                        </div>
                        <!-- Menu -->
                        <nav class="main-menu">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="shop.php">Shop</a></li>
                                <li><a href="category.php">Shop By Categories</a></li>
                                <li><a href="feedback.php">Feedback</a></li>
                                <li><a href="faqs.php">FAQs</a></li>
                                <li>
                                    <div class="header-icons">
                                        <a class="shopping-cart" href="view_cart.php">
                                            <?php if ($cart_count > 0): ?>
                                            <span class="cart-count"><?php echo $cart_count; ?></span>
                                            <?php endif; ?>
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                        <?php if (isset($_SESSION['Username'])): ?>
                                            <li>
                                                <a href="#"><i class="fa-solid fa-user mx-2"></i><?php echo $_SESSION['Username']; ?></a>
                                                <ul class="sub-menu">
                                                    <?php if (isCustomer()): ?>
                                                    <li><a href="profile.php?id=<?php echo $_SESSION['Id']; ?>">Profile</a></li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <form method="POST" action="logout.php" id="logout-form">
                                                            <button type="button" style="background:transparent;border:none;font-size:12px;" onclick="confirmLogout()">Logout</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li class="mx-5">
                                                <a href="../admin/login.php" class="box-btn" style="width:100px;">Login</a>
                                            </li>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Section -->

    <script>
       function confirmLogout() {
    Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, logout!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the logout form if confirmed
            document.getElementById("logout-form").submit();
        }
    });
}

    </script>

    <?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
    <div class="hero-area hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-2 text-center">
                    <div class="hero-text">
                        <div class="hero-text-tablecell">
                            <p class="subtitle">Fresh Pages, Pure Inspiration</p>
                            <h1>Elevate Your Craft with Arts Stationery</h1>
                            <div class="hero-btns">
                                <a href="shop.php" class="boxed-btn">Products Collection</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
