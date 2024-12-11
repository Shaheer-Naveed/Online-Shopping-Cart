<?php
include('connection.php');
include('header.php');
$q = "SELECT * FROM employee";
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
                                  <a href='update_employee.php?update=". $row['Id'] . "' class='btn btn-success'>Update</a>
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
include('footer.php');
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
            window.location.href = 'employee.php'; // Redirect after the alert
        });
    </script>
    <?php 
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
