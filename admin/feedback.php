<?php
include('connection.php');
include('header.php');

$q="select * from feedback";
$result=mysqli_query($conn,$q);
?>

<div class="row">
     <div class="col-md-12 mb-4 ">
        <div class="card card-body p-3 ">
        <table class="table">
                <thead class="text-center">
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Picture</th>
                    <th>Feedback</th>     
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                <?php
                   while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                            <td>".$row['Id']."</td>
                            <td>".$row['Name']."</td>
                            <td>".$row['Email']."</td>
                            <td>".$row['Phone']."</td>
                            <td>".$row['Picture']."</td>
                            <td>".$row['Feedback']."</td>
                            <td>
                              <a href='feedback.php?delete=". $row['Id'] . "' class='btn btn-danger'>Delete</a>
                            </td>
                          </tr>";
                   }
                   if (isset($_GET['delete'])) {
                    $delete_id = $_GET['delete'];
                    $query = "DELETE FROM feedback WHERE id = $delete_id";
                    mysqli_query($conn, $query);
                    echo "<script>
                    window.location.href = 'feedback.php?status=Feedback deleted successfully!&status_code=success';
                  </script>";
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
        window.location.href = 'feedback.php'; // Redirect after the alert
    });
</script>
    <?php
}