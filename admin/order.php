<?php
include('connection.php');
include('header.php');
?>

<div class="mb-4 mt-4">
  <div class="card card-body p-3">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="col-md-10 main-title">
          <h3 class="font-weight-bold">View Orders</h3>
        </div>
      </div>
      <div class="white_card_body">
        <div class="table-responsive custom-scrollbar">
          <table class="table">
            <thead class="text-center">
              <tr>
                <th>Order_Id</th>
                <th>User_Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Payment Method</th>
                <th>Order Code</th>
                <th>Sub Total</th>
                <th>Shipping</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
              $query = "SELECT * FROM orders";
              $result = mysqli_query($conn, $query);
              if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . $row['Order_Id'] . "</td>";
                      echo "<td>" . $row['User_Id'] . "</td>";
                      echo "<td>" . $row['Name'] . "</td>";
                      echo "<td>" . $row['Email'] . "</td>";
                      echo "<td>" . $row['Phone'] . "</td>";
                      echo "<td>" . $row['Address'] . "</td>";
                      echo "<td>" . $row['Payment_Method'] . "</td>";
                      echo "<td>" . $row['Order_Code'] . "</td>";
                      echo "<td>" . $row['Subtotal'] . "</td>";
                      echo "<td>" . $row['Shipping'] . "</td>";
                      echo "<td>" . $row['Total'] . "</td>";
                      echo "<td>" . $row['Order_Date'] . "</td>";
                      echo "<td>
                            <a href='order.php?delete=" . $row['Order_Id'] . "' class='btn btn-danger btn-large my-3'>Delete</a>
                          </td>";
                      echo "</tr>";
                  }
              }

              // Handle deletion and show SweetAlert message
              if (isset($_GET['delete'])) {
                  $delete_id = $_GET['delete'];
                  $query = "DELETE FROM orders WHERE Order_Id = $delete_id";
                  if (mysqli_query($conn, $query)) {
                      $status = "Order deleted successfully!";
                      $status_code = "success";
                  } else {
                      $status = "Error deleting order!";
                      $status_code = "error";
                  }
                  echo "<script>window.location.href='order.php?status=$status&status_code=$status_code';</script>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include('footer.php');
?>

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// Check if SweetAlert status is set and display it from the URL parameters
if (isset($_GET['status']) && isset($_GET['status_code'])) {
    $status = $_GET['status'];
    $status_code = $_GET['status_code'];
    ?>
    <script>
    Swal.fire({
        title: "<?php echo $status; ?>",
        icon: "<?php echo $status_code; ?>",
        confirmButtonText: "OK",
        confirmButtonColor: "#f28123" // Change the button background color
    }).then(function() {
        window.location.href = 'order.php'; // Redirect after the alert
    });
</script>
    <?php
}
?>
