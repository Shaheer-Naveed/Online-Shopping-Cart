<?php
include('connection.php');
include('header.php');
$role_id = $_SESSION['Role_Id'];
$q = "SELECT * FROM customers WHERE Role_Id = 3";
$result = mysqli_query($conn, $q);
?>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-body p-3">
            <table class="table">
                <thead class="text-center">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>   
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                <?php
                   while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>".$row['Id']."</td>
                            <td>".$row['Username']."</td>
                            <td>".$row['Email']."</td>
                            <td>".$row['Password']."</td>
                            <td>
                              <a href='customers.php?delete=".$row['Id']."' class='btn btn-danger'>Delete</a>
                            </td>
                          </tr>";
                   }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// ------------Delete functionality----------------
if (isset($_GET['delete'])) {
    $Id = $_GET['delete'];
    $delete1 = "DELETE FROM customers WHERE Id = $Id";
    $result1 = mysqli_query($conn, $delete1);
    $delete2 = "DELETE FROM users WHERE Id = $Id";
    $result2 = mysqli_query($conn, $delete2);

    if ($result1 && $result2) {
        $_SESSION['status'] = "Customer deleted successfully!";
        $_SESSION['status_code'] = "success"; // Success status code
    } else {
        $_SESSION['status'] = "Error deleting customer";
        $_SESSION['status_code'] = "error"; // Error status code
    }

    // Redirect after setting status to trigger SweetAlert
    echo "<script>window.location.href='customers.php';</script>";
    exit();
}
?>

<?php
// Check if SweetAlert status is set and display it   
if (isset($_SESSION['status']) && $_SESSION['status']) {
    ?>
    <script src="assets/plugins/sweetalert/sweetalert.js"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
            confirmButtonText: "OK",
            confirmButtonColor: "#f28123"
        }).then(function() {
            window.location.href = 'customers.php'; // Redirect after the alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
