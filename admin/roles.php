<?php

include('connection.php');
include('header.php');

?>

    <div class="col-md-12 mb-4 mt-4">
        <div class="card card-body p-3">
            <div class="box_header m-0">
                <div class="row">
                    <div class="col-md-10 main-title">
                    <h2>Add Roles</h2>
                    </div>
                    <li class="col-md-2 nav-item d-flex align-items-center">
                        <a class="btn btn-outline-primary btn-sm mb-0 me-0"  href="view_roles.php">View Roles</a>
                    </li>
                </div>
            </div>
            <div class="white_card_body">
          <div class="card-body">
            <form method="post">
              <div class="row ">
                <div class="col-md-12 mb-5">
                  <label class="form-label" >Role Name</label>
                  <input type="text" class="form-control" name="role_name"  placeholder="Enter Role Name" style=" width:60%;">
                </div>
                <div class="col-md-12 mb-5">
                  <label class="form-label" >Status</label>
                  <select  class="form-control" name="role_status" style=" width:30%;">
                    <option selected>Choose Status</option>
                    <option>Active</option>
                    <option>Deactive</option>
                  </select>
                </div>
           
              </div>
              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
          </div>
        </div>
        </div>
    </div>


<?php

include('footer.php');

if(isset($_POST['submit'])){
    $name=$_POST['role_name'];
    $status=$_POST['role_status'];

    $q= "insert into `role`(Role,Status) values ('$name','$status')";
    $result = mysqli_query($conn,$q);

    echo"<script>alert('Role Added');</script>";
}

?>