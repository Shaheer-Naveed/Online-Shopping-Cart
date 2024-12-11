<?php
include('connection.php');
include('header.php');
?>

<div class="col-md-12 mb-4 mt-4 ">
  <div class="card card-body p-3 ">
    <div class="row">
      <div class="col-md-10 main-title">
        <h2>Stocks</h2>
      </div> 
      <li class="col-md-2 nav-item d-flex align-items-center">
        <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="view_stock.php">View Stock</a>
      </li>
    </div>
    <div class="white_card_body">
      <div class="card-body">
        <form method="post">
          <div class="row">
            <!-- Stock In -->
            <div class="col-md-10 main-title">
              <h3>Add Stock</h3>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Product Name</label>
              <select name="pro_id_in" class="form-control">
                <option>Select Product</option>
                <?php
                $sql = "SELECT * FROM add_Product";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <option value="<?php echo $row['Id']; ?>"><?php echo $row['Product_Name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Product Category</label>
              <select name="pro_cat_in" class="form-control">
                <option>Select Category</option>
                <?php
                $sql = "SELECT * FROM add_category";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Product Sub Category</label>
              <select name="pro_sub_cat_in" class="form-control">
                <option>Select Sub Category</option>
                <?php
                $sql = "SELECT * FROM add_sub_category";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Quantity In</label>
              <input type="text" class="form-control" name="quantity_in" placeholder="Enter Quantity In">
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="q_in">Stock In</button>

          <!-- Stock Out -->
          <div class="row">
            <div class="col-md-10 main-title">
              <h3>Remove Stock</h3>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Product Name</label>
              <select name="pro_id_out" class="form-control">
                <option>Select Product</option>
                <?php
                $sql = "SELECT * FROM add_Product";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <option value="<?php echo $row['Id']; ?>"><?php echo $row['Product_Name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Product Category</label>
              <select name="pro_cat_out" class="form-control">
                <option>Select Category</option>
                <?php
                $sql = "SELECT * FROM add_category";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Product Sub Category</label>
              <select name="pro_sub_cat_out" class="form-control">
                <option>Select Sub Category</option>
                <?php
                $sql = "SELECT * FROM add_sub_category";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <option value="<?php echo $row['Id']; ?>"><?php echo $row['Category']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mb-5">
              <label class="form-label">Quantity Out</label>
              <input type="text" class="form-control" name="quantity_out" placeholder="Enter Quantity Out">
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="q_out">Stock Out</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
include('footer.php');

// Handle Stock In
if (isset($_POST['q_in'])) {
  $pro_id = $_POST['pro_id_in'] ?? null;
  $pro_cat = $_POST['pro_cat_in'] ?? null;
  $pro_sub_cat = $_POST['pro_sub_cat_in'] ?? null;
  $quan_in = $_POST['quantity_in'] ?? null;

  if ($pro_id && $pro_cat && $pro_sub_cat && $quan_in) {
      // Check if the product already exists in the stock table
      $check_query = "SELECT * FROM stock WHERE Pro_Id = '$pro_id' AND Pro_Category = '$pro_cat' AND Pro_Sub_Category = '$pro_sub_cat'";
      $check_result = mysqli_query($conn, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
          // Update existing stock
          $update_query = "
              UPDATE stock
              SET Quantity_In = Quantity_In + $quan_in, 
                  Available = Available + $quan_in
              WHERE Pro_Id = '$pro_id' AND Pro_Category = '$pro_cat' AND Pro_Sub_Category = '$pro_sub_cat'
          ";
          $update_result = mysqli_query($conn, $update_query);

          if ($update_result) {
              echo "<script>
                      Swal.fire({
                          title: 'Stock updated successfully!',
                          icon: 'success',
                          confirmButtonText: 'OK',
                          confirmButtonText: 'OK',
                          confirmButtonColor: '#f28123'
                      }).then(function() {
                          window.location.href='stock.php';
                      });
                    </script>";
          } else {
              echo "<script>
                      Swal.fire({
                          title: 'Error updating stock',
                          icon: 'error',
                          confirmButtonText: 'OK',
                           confirmButtonText: 'OK',
                          confirmButtonColor: '#f28123'
                      });
                    </script>";
          }
      } else {
          // Insert new stock entry
          $insert_query = "
              INSERT INTO stock (Pro_Id, Pro_Category, Pro_Sub_Category, Quantity_In, Quantity_Out, Available)
              VALUES ('$pro_id', '$pro_cat', '$pro_sub_cat', '$quan_in', 0, $quan_in)
          ";
          $insert_result = mysqli_query($conn, $insert_query);

          if ($insert_result) {
              echo "<script>
                      Swal.fire({
                          title: 'Stock added successfully!',
                          icon: 'success',
                          confirmButtonText: 'OK',
                           confirmButtonText: 'OK',
                          confirmButtonColor: '#f28123'
                      }).then(function() {
                          window.location.href='stock.php';
                      });
                    </script>";
          } else {
              echo "<script>
                      Swal.fire({
                          title: 'Error adding new stock',
                          icon: 'error',
                          confirmButtonText: 'OK',
                           confirmButtonText: 'OK',
                          confirmButtonColor: '#f28123'
                      });
                    </script>";
          }
      }
  } else {
      echo "<script>
              Swal.fire({
                  title: 'Please fill all fields for Stock In',
                  icon: 'warning',
                  confirmButtonText: 'OK',
                   confirmButtonText: 'OK',
                    confirmButtonColor: '#f28123'
              });
            </script>";
  }
}

// Handle Stock Out
if (isset($_POST['q_out'])) {
  $pro_id = $_POST['pro_id_out'] ?? null;
  $pro_cat = $_POST['pro_cat_out'] ?? null;
  $pro_sub_cat = $_POST['pro_sub_cat_out'] ?? null;
  $quan_out = $_POST['quantity_out'] ?? null;

  if ($pro_id && $pro_cat && $pro_sub_cat && $quan_out) {
      // Check if the product exists in the stock table
      $check_query = "SELECT * FROM stock WHERE Pro_Id = '$pro_id' AND Pro_Category = '$pro_cat' AND Pro_Sub_Category = '$pro_sub_cat'";
      $check_result = mysqli_query($conn, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
          // Fetch the current available stock
          $stock = mysqli_fetch_assoc($check_result);
          $current_available = $stock['Available'];

          if ($quan_out <= $current_available) {
              // Update stock for Quantity Out
              $update_query = "
                  UPDATE stock
                  SET Quantity_Out = Quantity_Out + $quan_out, 
                      Available = Available - $quan_out
                  WHERE Pro_Id = '$pro_id' AND Pro_Category = '$pro_cat' AND Pro_Sub_Category = '$pro_sub_cat'
              ";
              $update_result = mysqli_query($conn, $update_query);

              if ($update_result) {
                  echo "<script>
                          Swal.fire({
                              title: 'Stock updated successfully!',
                              icon: 'success',
                              confirmButtonText: 'OK',
                               confirmButtonText: 'OK',
                          confirmButtonColor: '#f28123'
                          }).then(function() {
                              window.location.href='stock.php';
                          });
                        </script>";
              } else {
                  echo "<script>
                          Swal.fire({
                              title: 'Error updating stock for Quantity Out',
                              icon: 'error',
                              confirmButtonText: 'OK',
                          });
                        </script>";
              }
          } else {
              echo "<script>
                      Swal.fire({
                          title: 'Insufficient stock available',
                          icon: 'warning',
                          confirmButtonText: 'OK',
                      });
                    </script>";
          }
      } else {
          echo "<script>
                  Swal.fire({
                      title: 'Stock record not found',
                      icon: 'error',
                      confirmButtonText: 'OK',
                  });
                </script>";
      }
  } else {
      echo "<script>
              Swal.fire({
                  title: 'Please fill all fields for Stock Out',
                  icon: 'warning',
                  confirmButtonText: 'OK',
              });
            </script>";
  }
}

?>
