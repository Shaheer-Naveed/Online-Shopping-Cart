<?php
include('connection.php');
include('header.php');

$query = "SELECT add_product.Id, add_product.Product_Code, add_product.Product_Name, 
                 add_category.Category AS Product_Category, add_sub_category.Category AS Product_Sub_Category, 
                 add_product.Price, add_product.Warranty, add_product.Description, add_product.Product_Image 
          FROM add_product
          JOIN add_category ON add_product.Product_Category = add_category.Id
          JOIN add_sub_category ON add_product.Product_Sub_Category = add_sub_category.Id";
$result = mysqli_query($conn, $query);
?>

<div class="mb-4 mt-4">
  <div class="card card-body p-3">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="row">
          <div class="col-md-10 main-title">
            <h3 class="font-weight-bold">View Product</h3>
          </div>
          <li class="col-md-2 nav-item d-flex align-items-center">
            <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="add_product.php">Add Product</a>
          </li>
        </div>
      </div>
    </div>
    <div class="white_card_body">
      <div class="table-responsive custom-scrollbar">
        <table class="table">
          <thead class="text-center">
            <tr>
              <th>Id</th>
              <th>Product_Code</th>
              <th>Product_Name</th>
              <th>Product_Category</th>
              <th>Product_Sub_Category</th>
              <th>Price</th>
              <th>Warranty</th>
              <th>Description</th>
              <th>Product_Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <tr>
                  <td>".$row['Id']."</td>
                  <td>".$row['Product_Code']."</td>
                  <td>".$row['Product_Name']."</td>
                  <td>".$row['Product_Category']."</td>
                  <td>".$row['Product_Sub_Category']."</td>
                  <td>".$row['Price']."</td>
                  <td>".$row['Warranty']."</td>
                  <td>".$row['Description']."</td>
                  <td>
                    <img src='".$row['Product_Image']."' style='width: 100px; height: 100px; border-radius: 25px;'>
                  </td>
                  <td>
                    <a href='update_product.php?update=".$row['Id']."' class='btn btn-success btn-large my-3'>Edit</a>
                    <a href='view_product.php?delete=".$row['Id']."' class='btn btn-danger btn-large my-3'>Delete</a>
                  </td>
                </tr>";
            }

              // Delete functionality
            if (isset($_GET['delete'])) {
                $Id = $_GET['delete'];
                $delete = "DELETE FROM add_product WHERE Id = $Id";
                if (mysqli_query($conn, $delete)) {
                    // Set session for SweetAlert after deletion
                    $_SESSION['status'] = "Product deleted successfully!";
                    $_SESSION['status_code'] = "success"; // Success status code
                } else {
                    $_SESSION['status'] = "Failed to delete product!";
                    $_SESSION['status_code'] = "error"; // Error status code
                }
               // Redirect to reload the page and show SweetAlert
              echo "<script>window.location.href='view_product.php';</script>";
              exit(); // Prevent further code execution
            }
      
            
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
 
<?php
include('footer.php');
?>

<!-- SweetAlert Script -->
<?php
// Check if SweetAlert status is set and display it
if (isset($_SESSION['status']) && $_SESSION['status']) {
    ?>
    <script src="assets/plugins/sweetalert/sweetalert.js"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>", // Show status message
            icon: "<?php echo $_SESSION['status_code']; ?>", // Show success or error icon
            button: "OK",
             confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            window.location.href = 'view_product.php'; // Redirect after alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
