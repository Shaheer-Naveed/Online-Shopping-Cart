<?php
include('connection.php');
include('header.php');

// Handle deletion only if the delete parameter is set and session is not already marked
if (isset($_GET['delete']) && !isset($_SESSION['deleted'])) {
  $delete_id = $_GET['delete'];
  $query = "DELETE FROM add_sub_category WHERE Id = $delete_id";

  if (mysqli_query($conn, $query)) {
      // Set success message for SweetAlert
      $_SESSION['status'] = "Sub Category deleted successfully!";
      $_SESSION['status_code'] = "success";
  } else {
      // Set error message for SweetAlert
      $_SESSION['status'] = "Error deleting category.";
      $_SESSION['status_code'] = "error";
  }

  // Mark that the deletion has occurred to prevent repeated deletion on page reload
  $_SESSION['deleted'] = true;

  // JavaScript to reload the page after deletion
  echo "<script>window.location.href='view_sub_cat.php';</script>";
  exit(); // Ensures no further code is executed
}

// Reset the 'deleted' session variable after the page reload to prevent further reloads
if (isset($_SESSION['deleted'])) {
  unset($_SESSION['deleted']);
}

?>

<div class="col-md-12 mb-4 mt-4">
    <div class="card card-body p-3">
        <div class="white_card card_height_100 mb_30">
            <div class="box_header m-0">
                <div class="row">
                    <div class="col-md-10 main-title">
                        <h3 class="font-weight-bold">View Sub Category</h3>
                    </div>
                    <li class="col-md-2 nav-item d-flex align-items-center">
                        <a class="btn btn-outline-primary btn-sm mb-0 me-0" href="add_sub_cat.php">Add Sub Category</a>
                    </li>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="QA_table mb_30">
                <table class="table">
                    <thead class="text-center">
                        <tr>
                            <th>Id</th>
                            <th>Parent_Category</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $query = "SELECT * FROM add_sub_category";
                        $result = mysqli_query($conn, $query);
                        
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['Id'] . "</td>";
                                echo "<td>" . $row['Parent_Category'] . "</td>";
                                echo "<td>" . $row['Category'] . "</td>";
                                echo "<td>" . $row['Status'] . "</td>";
                                echo "<td>
                                    <a href='update_sub_cat.php?edit=" . $row['Id'] . "' class='btn btn-success btn-large my-3'>Edit</a>
                                    <a href='view_sub_cat.php?delete=" . $row['Id'] . "' class='btn btn-danger btn-large my-3'>Delete</a>
                                  </td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

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
