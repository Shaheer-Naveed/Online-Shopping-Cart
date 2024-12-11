<?php
include('connection.php');
include('header.php');
?>
<div class="col-md-12 mb-4 mt-4 ">
  <div class="card card-body p-3 ">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="row">
          <div class="col-md-10 main-title">
            <h3 class="m-0">View Category</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="white_card_body">
      <div class="white_box_tittle list_header">
        <div class="box_right d-flex lms_block">
        </div>
      </div>
      <table class="table mt-4">
        <thead class="text-center">
          <tr>
            <th>Id</th>
            <th>Role_Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Status</th>
            <th>Active</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
          $query = "SELECT * FROM users";
          $result = mysqli_query($conn, $query);
          if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['Id'] . "</td>";
                  echo "<td>" . $row['Role_Id'] . "</td>";
                  echo "<td>" . $row['Username'] . "</td>";
                  echo "<td>" . $row['Email'] . "</td>";
                  echo "<td>" . $row['Password'] . "</td>";
                  echo "<td>" . $row['Status'] . "</td>";
                  echo "<td>
                        <a href='user.php?delete=" . $row['Id'] . "' class='btn btn-danger btn-large '>Delete</a>
                      </td>";
                  echo "</tr>";
              }
          }

          // Handle deletion with a JavaScript redirection
          if (isset($_GET['delete'])) {
              $delete_id = $_GET['delete'];
          
              // Delete from the users table
              $query_user = "DELETE FROM users WHERE id = $delete_id";
              if (mysqli_query($conn, $query_user)) {
                  // Delete from the employee table
                  $query_employee = "DELETE FROM employee WHERE id = $delete_id";
                  if (mysqli_query($conn, $query_employee)) {
                      // Delete from the customer table
                      $query_customer = "DELETE FROM customers WHERE id = $delete_id";
                      if (mysqli_query($conn, $query_customer)) {
                          // Redirect with success status
                          echo "<script>
                                  window.location.href = 'user.php?status=User, Employee, Or Customer records deleted successfully!&status_code=success';
                                </script>";
                      } else {
                          // Redirect with error status for the customers table
                          echo "<script>
                                  window.location.href = 'user.php?status=Error deleting customer record!&status_code=error';
                                </script>";
                      }
                  } else {
                      // Redirect with error status for the employee table
                      echo "<script>
                              window.location.href = 'user.php?status=Error deleting employee record!&status_code=error';
                            </script>";
                  }
              } else {
                  // Redirect with error status for the users table
                  echo "<script>
                          window.location.href = 'user.php?status=Error deleting user!&status_code=error';
                        </script>";
              }
              exit;
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

<!-- Check for status and show SweetAlert -->
<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $status_code = $_GET['status_code'];
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
