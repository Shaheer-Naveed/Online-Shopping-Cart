<?php
include('connection.php');
include('header.php');

// Query to get total numbers of customers
$query_total_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$result_total_customers = mysqli_query($conn, $query_total_customers);
$row_total_customers = mysqli_fetch_assoc($result_total_customers);
$total_customers = $row_total_customers['total_customers'] ? $row_total_customers['total_customers'] : 0; // If no customers, show 0

// Query to get total numbers of customers
$query_total_employee = "SELECT COUNT(*) AS total_employee FROM employee";
$result_total_employee = mysqli_query($conn, $query_total_employee);
$row_total_employee = mysqli_fetch_assoc($result_total_employee);
$total_employee = $row_total_employee['total_employee'] ? $row_total_employee['total_employee'] : 0; // If no customers, show 0

// Query to get today's orders
$query_today_orders = "SELECT COUNT(*) AS total_orders_today FROM orders WHERE DATE(order_date) = CURDATE()";
$result_today_orders = mysqli_query($conn, $query_today_orders);
$row_today_orders = mysqli_fetch_assoc($result_today_orders);
$total_orders_today = $row_today_orders['total_orders_today'] ? $row_today_orders['total_orders_today'] : 0; // If no orders, show 0

// Query to get the total amount of money from today's orders
$query_today_orders_amount = "SELECT SUM(total) AS total_amount_today FROM orders WHERE DATE(order_date) = CURDATE()";
$result_today_orders_amount = mysqli_query($conn, $query_today_orders_amount);
$row_today_orders_amount = mysqli_fetch_assoc($result_today_orders_amount);
$total_amount_today = $row_today_orders_amount['total_amount_today'] ? $row_today_orders_amount['total_amount_today'] : 0; // If no orders, show 0

// Query to get total monthly orders
$query_month_orders = "SELECT COUNT(*) AS total_orders_month FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
$result_month_orders = mysqli_query($conn, $query_month_orders);
$row_month_orders = mysqli_fetch_assoc($result_month_orders);
$total_orders_month = $row_month_orders['total_orders_month'] ? $row_month_orders['total_orders_month'] : 0; // If no orders, show 0

// Query to get the total amount of money from orders this month
$query_month_orders_amount = "SELECT SUM(total) AS total_amount_this_month FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
$result_month_orders_amount = mysqli_query($conn, $query_month_orders_amount);
$row_month_orders_amount = mysqli_fetch_assoc($result_month_orders_amount);
$total_amount_this_month = $row_month_orders_amount['total_amount_this_month'] ? $row_month_orders_amount['total_amount_this_month'] : 0; // If no orders, show 0
?>

<div class="row text-center me-2">
    <div class="col-md-4 mb-4">
        <div class="card card-body p-3">
            <p class="text-sm mb-0 text-capitalized font-weight-bold">Total Customers</p>
            <h5 class="font-weight-bolder mb-0"><?php echo $total_customers; ?></h5>    
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-body p-3">
            <p class="text-sm mb-0 text-capitalized font-weight-bold">Today's Orders</p>
            <h5 class="font-weight-bolder mb-0"><?php echo $total_orders_today; ?></h5>    
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-body p-3">
            <p class="text-sm mb-0 text-capitalized font-weight-bold">Today's Total Amount</p>
            <h5 class="font-weight-bolder mb-0"><?php echo number_format($total_amount_today, 2); ?> Rs</h5>  
        </div>  
    </div>
</div>

<div class="row text-center mt-5 me-2">
    <div class="col-md-4 mb-4">
        <div class="card card-body p-3">
            <p class="text-sm mb-0 text-capitalized font-weight-bold">Total Employees</p>
            <h5 class="font-weight-bolder mb-0"><?php echo $total_employee; ?></h5>    
        </div>
    </div>
   <div class="col-md-4 mb-4">
        <div class="card card-body p-3">
            <p class="text-sm mb-0 text-capitalized font-weight-bold">Monthly Orders</p>
            <h5 class="font-weight-bolder mb-0"><?php echo $total_orders_month; ?></h5>    
        </div>
    </div> 
    <div class="col-md-4 mb-4">
        <div class="card card-body p-3">
            <p class="text-sm mb-0 text-capitalized font-weight-bold">Total Amount This Month</p>
            <h5 class="font-weight-bolder mb-0"><?php echo number_format($total_amount_this_month, 2); ?> Rs </h5>    
        </div>
    </div>
    
</div>

<?php
include('footer.php');

// Unset session variables to avoid alert loop after showing the alert
if (isset($_SESSION['status'])) {
    // Show the alert and then clear the session variables
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>

<script src="assets/plugins/sweetalert/sweetalert.js"></script>
<script>
    <?php if (isset($status)): ?>
        swal({
            title: "<?php echo $status; ?>",
            icon: "<?php echo $status_code; ?>",
            button: "OK",
            confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            window.location.href = 'dashboard.php'; // Redirect after the alert
        });
    <?php endif; ?>
</script>
