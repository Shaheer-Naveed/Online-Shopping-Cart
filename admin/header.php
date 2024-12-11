<?php
session_start();
if(!isset($_SESSION['Admin_name']) &&!isset($_SESSION['Emp_name']) && !isAdmin()){
  header("location: login.php");
  exit();
}

function isAdmin() {
  return isset($_SESSION['Admin_name']) && isset($_SESSION['Role_Id']) && $_SESSION['Role_Id'] == 1;
}
function isEmployee() {
  return isset($_SESSION['Emp_name']) &&  isset($_SESSION['Role_Id']) && $_SESSION['Role_Id'] == 2;
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/logos.png">
    <title> Arts | Dashboard </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">   
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Mochiy+Pop+One&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
    <style>
/* Custom style to center the SweetAlert button */
.swal2-actions {
    display: flex;
    justify-content: center; /* Center the buttons horizontally */
}

.swal-btn {
    background-color: #f28123 !important; /* Set button color */
    border: none !important; /* Remove the border */
    padding: 10px 20px; /* Adjust padding */
}
</style>
  </head>
  <body class="g-sidenav-show  bg-gray-100">
    <!-- SweetAlert Notification -->
    <?php if (!empty($status) && !empty($status_code)): ?>
      <script>
    Swal.fire({
        title: "<?php echo $status; ?>",
        icon: "<?php echo $status_code; ?>",
        confirmButtonText: "OK",
        confirmButtonColor: "#f28123", // Change the button background color
        buttonsStyling: false, // Disable default button styling
        customClass: {
            confirmButton: 'swal-btn' // Assign a custom class to the button
        }
    }).then(function() {
        window.location.href = 'dashboard.php'; // Redirect after the alert
    });
    </script>
    <?php 
    // Clear session status variables after display
    unset($_SESSION['status'], $_SESSION['status_code']);
    endif; ?>

    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" dashboard.php" >
          <img src="assets/img/logos.png" class="navbar-brand-img" alt="main_logo">
        </a>
      </div>
      <hr class="horizontal dark mt-0">
      <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link  active" href="dashboard.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 576 512" width="24px" fill="#5f6368">
                <path d="M541 229.2L512 204.3V64c0-17.7-14.3-32-32-32H416c-17.7 0-32 14.3-32 32V91.6L310.6 4.2c-14.3-11.9-35.6-11.9-49.9 0L35 229.2c-10.2 8.5-11.6 23.6-3.1 33.8s23.6 11.6 33.8 3.1L64 248.6V464c0 26.5 21.5 48 48 48H208c17.7 0 32-14.3 32-32V352h96v128c0 17.7 14.3 32 32 32H464c26.5 0 48-21.5 48-48V248.6l28.3 17.5c10.2 6.3 25.3 5 33.8-3.1s7-25.3-3.1-33.8z"/>
              </svg>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>
          <?php if (isAdmin() ) : ?>
          <li class="nav-item">
            <a class="nav-link  " href="user.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
              </div>
              <span class="nav-link-text ms-1">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  " href="add_cat.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                  <path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z" />
                </svg>
              </div>
              <span class="nav-link-text ms-1">Category</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="add_sub_cat.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                  <path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z" />
                </svg>
              </div>
              <span class="nav-link-text ms-1">Sub Category</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link  " href="add_product.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                  <path d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80H200Zm0-520v440h560v-440H200Zm-40-80h640v-120H160v120Zm200 280h240v-80H360v80Zm120 20Z" />
                </svg>
              </div>
              <span class="nav-link-text ms-1">Products</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  " href="customers.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                  <path d="M480-440q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0-80q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0 440q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm0-400Zm0-315-240 90v189q0 54 15 105t41 96q42-21 88-33t96-12q50 0 96 12t88 33q26-45 41-96t15-105v-189l-240-90Zm0 515q-36 0-70 8t-65 22q29 30 63 52t72 34q38-12 72-34t63-52q-31-14-65-22t-70-8Z" />
                </svg>
              </div>
              <span class="nav-link-text ms-1">Customers</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="feedback.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" width="24px" height="24px" viewBox="0 0 512 512">
                <path fill="currentColor" d="M256 32C114.6 32 0 125.1 0 240c0 49.63 21.38 95.5 56.88 132.4C52.75 412.8 34.12 460.4 33.25 462.9C32 466.4 32.75 470.3 35.12 473.1C37.5 475.9 41.12 477.4 44.5 477.4C107.5 477.4 155.4 456.9 182.4 442.6C205.6 449.3 230.4 453.2 256 453.2c141.4 0 256-93.13 256-208S397.4 32 256 32zM256 405.2c-24.38 0-47.75-3.375-70.13-10.13l-20.88-6.25l-18.12 10.38C129.6 411.1 97.88 424.1 67.75 428.4c6.875-16.63 16.88-45.38 22.5-66.88l8.625-32l-23.25-24.5C52.88 276.8 32 238.3 32 240C32 149.1 137.4 61.2 256 61.2S480 149.1 480 240S374.6 405.2 256 405.2z"></path>
            </svg>                
              </div>
              <span class="nav-link-text ms-1">Feedback</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  " href="employee.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                  <path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
                </svg>
              </div>
              <span class="nav-link-text ms-1">Employee</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if (isAdmin() || isEmployee()) : ?>
            <li class="nav-item">
            <a class="nav-link  " href="stock.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                  <path d="M620-163 450-333l56-56 114 114 226-226 56 56-282 282Zm220-397h-80v-200h-80v120H280v-120h-80v560h240v80H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v200ZM480-760q17 0 28.5-11.5T520-800q0-17-11.5-28.5T480-840q-17 0-28.5 11.5T440-800q0 17 11.5 28.5T480-760Z" />
                </svg>
              </div>
              <span class="nav-link-text ms-1">Stock</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  " href="order.php">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 640 512" width="24px" >
                <path d="M368 0c22.1 0 40 17.9 40 40V352H457.3c22.9 0 44.1 10.3 58.5 28.1L568 429.1c10.5 13.4 16 29.7 16 46.6c0 6.9-1 13.8-3 20.4c6.1 2.6 10 8.5 10 15.4c0 9-7.3 16.3-16.3 16.3H528c-30.9 0-58.2-12.7-78.2-33.1c-4.2-4.3-10.7-4.3-14.9 0c-20 20.4-47.3 33.1-78.2 33.1H352V40c0-22.1 17.9-40 40-40H368zM64 320c35.3 0 64 28.7 64 64c0 35.3-28.7 64-64 64S0 419.3 0 384C0 348.7 28.7 320 64 320zM512 448c35.3 0 64-28.7 64-64c0-35.3-28.7-64-64-64s-64 28.7-64 64c0 35.3 28.7 64 64 64zM368 40c0-22.1 17.9-40 40-40h32c22.1 0 40 17.9 40 40V240h72c35.3 0 64 28.7 64 64v64h24c22.1 0 40 17.9 40 40s-17.9 40-40 40h-24c0 35.3-28.7 64-64 64H368c0-35.3-28.7-64-64-64h-64c0 35.3-28.7 64-64 64c-35.3 0-64-28.7-64-64H64c-35.3 0-64-28.7-64-64c0-35.3 28.7-64 64-64h240c0-35.3 28.7-64 64-64h64c0-35.3 28.7-64 64-64h16c22.1 0 40-17.9 40-40s-17.9-40-40-40h-16c-35.3 0-64 28.7-64 64H368V40z"/>
              </svg>
              </div>
              <span class="nav-link-text ms-1">Orders</span>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="profile.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>customer-support</title>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                    <g transform="translate(1716.000000, 291.000000)">
                      <g transform="translate(1.000000, 0.000000)">
                        <path class="color-background opacity-6" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                        <path class="color-background" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                        <path class="color-background" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <?php if (isAdmin()) : ?>
        <li class="nav-item">
          <a class="nav-link  " href="emp_signup.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>document</title>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                    <g transform="translate(1716.000000, 291.000000)">
                      <g transform="translate(154.000000, 300.000000)">
                        <path class="color-background opacity-6" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"></path>
                        <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"></path>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </div>
            <span class="nav-link-text ms-1">Employee Sign Up</span>
          </a>
        </li>
        <?php endif; ?>
        </ul>
      </div>


      <div class="sidenav-footer mx-3">
    <a class="btn btn-primary mt-3 w-100" href="javascript:void(0);" onclick="confirmLogout()">Logout</a>
    <!-- Hidden Form for Logout -->
    <form id="logout-form" action="logout.php" method="POST" style="display: none;"></form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       function confirmLogout() {
    Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, logout!",
        cancelButtonText: "Cancel",
        didRender: () => {
            // Apply inline styles to the confirm button
            const confirmButton = document.querySelector('.swal2-confirm');
            if (confirmButton) {
                confirmButton.style.backgroundColor = '#F28123'; // Set background color
                confirmButton.style.borderColor = '#F28123';     // Set border color
                confirmButton.style.color = 'white';             // Set text color
                confirmButton.style.fontWeight = 'bold';         // Optional: bold text
                confirmButton.style.padding = '10px 20px';       // Optional: padding
                confirmButton.style.borderRadius = '5px';        // Optional: rounded corners
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit(); // Submit the form to log out
        }
    });
}

    </script>
</div>
      
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <h3 class="font-weight-bolder mb-0">Dashboard</h3>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <ul class="navbar-nav justify-content-center">
              <li class="nav-item d-flex align-items-center mt-4">
                <span class="btn btn-primary w-100 "><?php if($_SESSION['Role_Id']== 1){ echo $_SESSION['Admin_name'];}
                else{ echo $_SESSION['Emp_name'];} ?></span>
              </li>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->