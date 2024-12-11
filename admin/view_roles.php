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
          <li class="col-md-2 nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-0"  href="roles.php">Add Roles</a>
              </li>
          </div>
        </div>
      </div>
      <div class="white_card_body">
          <div class="white_box_tittle list_header">
            <div class="box_right d-flex lms_block">
            </div>
          </div>
            <table class="table mt-4">
              <thead class="text-center ">
                <tr>
                  <th>Id</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Active</th>
                </tr>
              </thead>
              <tbody class="text-center">
              <?php
              $query = "SELECT * FROM `role`";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['Id'] . "</td>";
                                echo "<td>" . $row['Role'] . "</td>";
                                echo "<td>" . $row['Status'] . "</td>";
                                echo "<td>
                                        <a href='view_roles.php?edit=" . $row['Id'] . "' class='btn btn-success'>Edit</a>
                                        <a href='view_roles.php?delete=" . $row['Id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</a>
                                      </td>";
                                echo "</tr>";
                            }
                        }
                        
                        
                        if (isset($_GET['delete'])) {
                            $delete_id = $_GET['delete'];
                            $query = "DELETE FROM `role` WHERE id = $delete_id";
                            mysqli_query($conn, $query);
                            echo "<script>alert('Role deleted successfully!'); window.location.href='view_roles.php';</script>";
                        }
                        if (isset($_POST['update'])) {
                            $r_id = $_POST['r_id'];
                            $r_name = $_POST['role_name'];
                            $status=$_POST['role_status'];

                            $query = "UPDATE `role` SET Role = '$r_name', Status = '$status' WHERE id = $r_id";
                            mysqli_query($conn, $query);
                            echo "<script>alert('Role updated successfully!'); window.location.href='view_roles.php';</script>";
                        }
                        
                        ?>
              </tbody>
            </table>

            <?php
                if (isset($_GET['edit'])) {
                    $edit_id = $_GET['edit'];
                    $query = "SELECT * FROM `role` WHERE id = $edit_id";
                    $result = mysqli_query($conn, $query);
                    $role= mysqli_fetch_assoc($result);
                ?>
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title">Update Role</h4>
                        <form method="post" >
                            <input type="hidden" name="r_id" value="<?php echo $role['Id']; ?>">
                            <div class="form-group mb-3">
                                <label>Category</label>
                                <input type="text" class="form-control" name="role_name" value="<?php echo $role['Role']; ?>" style=" width:60%;">
                                <label>Status</label>
                                <select  class="form-control" name="role_status" style=" width:30%;">
                                <option selected>Choose Status</option>
                                <option>Active</option>
                                <option>Deactive</option>
                                </select>

                            </div>
                            <button type="submit" name="update" class="btn btn-dark">Update</button>
                        </form>
                 
                <?php } ?>
                </div>


</div>
</div>

<?php
include('footer.php');
?>