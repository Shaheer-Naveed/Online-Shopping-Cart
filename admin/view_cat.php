<?php
include('connection.php');
include('header.php');
?>

<div class="col-md-12 mb-4 mt-4">
  <div class="card card-body p-3">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="row">
          <div class="col-md-10 main-title">
            <h3 class="m-0">View Category</h3>
          </div>
          <li class="col-md-2 nav-item d-flex align-items-center">
            <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="add_cat.php">Add Category</a>
          </li>
        </div>
      </div>
    </div>
    <div class="white_card_body">
      <table class="table mt-4">
        <thead class="text-center">
          <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Status</th>
            <th>Active</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
          $query = "SELECT * FROM add_category";
          $result = mysqli_query($conn, $query);
          if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['Id'] . "</td>";
                  echo "<td>" . $row['Category'] . "</td>";
                  echo "<td>" . $row['Status'] . "</td>";
                  echo "<td>
                        <a href='update_cat.php?edit=" . $row['Id'] . "' class='btn btn-success btn-large my-3'>Edit</a>
                        <a href='view_cat.php?delete=" . $row['Id'] . "' class='btn btn-danger btn-large my-3'>Delete</a>
                      </td>";
                  echo "</tr>";
              }
          }

          // Handle deletion
          if (isset($_GET['delete']) && !isset($_SESSION['deleted'])) {
            $delete_id = $_GET['delete'];
            $query = "DELETE FROM add_category WHERE Id = $delete_id";
          
            if (mysqli_query($conn, $query)) {
                // Set success message for SweetAlert
                $_SESSION['status'] = "Category deleted successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                // Set error message for SweetAlert
                $_SESSION['status'] = "Error deleting category.";
                $_SESSION['status_code'] = "error";
            }
          
            // Mark that the deletion has occurred to prevent repeated deletion on page reload
            $_SESSION['deleted'] = true;
          
            // JavaScript to reload the page after deletion
            echo "<script>window.location.href='view_cat.php';</script>";
            exit(); // Ensures no further code is executed
          }
          
          // Reset the 'deleted' session variable after the page reload to prevent further reloads
          if (isset($_SESSION['deleted'])) {
            unset($_SESSION['deleted']);
          }
          ?>
        </tbody>
      </table>

   
<?php
include('footer.php');
?>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Ensure SweetAlert is included -->

<?php
// SweetAlert Script
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
            window.location.reload(); // Reload the page to show changes
        });
    </script>
    <?php
    // Unset the session variables after showing the alert
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>