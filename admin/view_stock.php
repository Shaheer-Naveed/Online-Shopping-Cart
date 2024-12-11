<?php
include('connection.php');
include('header.php');

// Fetch products from the database
$query = "SELECT Id, Product_Name FROM add_product";
$result = mysqli_query($conn, $query);

// Prepare a list of product names dynamically
$product_names = [];
while ($row = mysqli_fetch_assoc($result)) {
    $product_names[$row['Id']] = $row['Product_Name']; // Use product Id as the key
}

// Fetch stock details along with category and sub-category names for each product
$query = "
    SELECT stock.Pro_Id, stock.Quantity_In, stock.Quantity_Out, add_category.Category AS Pro_Category,  add_sub_category.Category AS Pro_Sub_Category
    FROM stock
    JOIN add_category ON stock.Pro_Category = add_category.Id
    JOIN add_sub_category ON stock.Pro_Sub_Category = add_sub_category.Id
";
$result = mysqli_query($conn, $query);
$stocks = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Prepare a mapping of stock quantities and category/sub-category
$stock_data = [];
foreach ($stocks as $stock) {
    $stock_data[$stock['Pro_Id']] = [ // Use Pro_Id as the key
        'Pro_Id' => $stock['Pro_Id'],
        'Quantity_In' => $stock['Quantity_In'],
        'Quantity_Out' => $stock['Quantity_Out'],
        'Available' => $stock['Quantity_In'] - $stock['Quantity_Out'],
        'Pro_Category' => $stock['Pro_Category'],
        'Pro_Sub_Category' => $stock['Pro_Sub_Category'],
    ];
}
?> 
<div class="mb-4 mt-4">
  <div class="card card-body p-3">
    <div class="white_card_body">
      <div class="row my-3">
        <div class="col-md-10 main-title">
          <h3 class="font-weight-bold">View Stock</h3>
        </div>
        <li class="col-md-2 nav-item d-flex align-items-center">
          <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="stock.php">Add Stock/Remove Stock</a>
        </li>
      </div>
    </div>
    <table class="table">
      <thead class="text-center">
        <tr>
          <th>Id</th>
          <th>Product Name</th>
          <th>Product Category</th>
          <th>Product Sub Category</th>
          <th>Quantity In</th>
          <th>Quantity Out</th>
          <th>Available</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="text-center"> 
        <?php  
            foreach ($product_names as $pro_id => $pro_name) {
                // Check if stock data exists for this product
                if (isset($stock_data[$pro_id])) {
                    $stock = $stock_data[$pro_id];
                    $quantity_in = $stock['Quantity_In'];
                    $quantity_out = $stock['Quantity_Out'];
                    $available = $stock['Available'];
                    $pro_category = $stock['Pro_Category'];
                    $pro_sub_category = $stock['Pro_Sub_Category'];
                } else {
                    // Default values for products without stock data
                    $quantity_in = $quantity_out = $available = 0;
                    $pro_category = $pro_sub_category = "N/A";
                }

                // Display the stock data in the table
                echo "
                    <tr>
                        <td>$pro_id</td>
                        <td>$pro_name</td>
                        <td>$pro_category</td>
                        <td>$pro_sub_category</td>
                        <td>$quantity_in</td>
                        <td>$quantity_out</td>
                        <td>$available</td>
                        <td>
                            <a href='view_stock.php?delete=$pro_id' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this stock record?\");'>Delete</a>
                        </td>
                    </tr>";
            }
        ?> 
      </tbody>
    </table>
  </div>
</div>

<?php
include('footer.php');

// ------------Delete functionality----------------
if (isset($_GET['delete'])) {
    $Id = $_GET['delete'];
    $delete = "DELETE FROM stock WHERE Pro_Id = $Id"; // Corrected to use Pro_Id for delete
    if (mysqli_query($conn, $delete)) {
        // Set session variable for SweetAlert success
        $_SESSION['status'] = "Stock record deleted successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        // Set session variable for SweetAlert error
        $_SESSION['status'] = "Error deleting stock record!";
        $_SESSION['status_code'] = "error";
    }
    header("Location: view_stock.php"); // Redirect after delete
    exit();
}
?>

<!-- SweetAlert Script -->
<?php
// Check if SweetAlert status is set and display it
if (isset($_SESSION['status']) && $_SESSION['status']) {
    ?>
    <script src="assets/plugins/sweetalert/sweetalert.js"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>", // Display success/error message
            icon: "<?php echo $_SESSION['status_code']; ?>", // Show success or error icon
            button: "OK",
             confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            window.location.href = 'view_stock.php'; // Reload page after alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
