<?php
include('connection.php'); 


if (isset($_POST['contact'])) {
    
    $message = mysqli_real_escape_string($conn, $_POST['message']);  

    // Check if the user is logged in and retrieve the username
    if (isset($_SESSION['Username'])) {
        $username = $_SESSION['Username'];  // Get the username from session
    } else {
        // If not logged in, set a default value or handle the error
        $username = 'Guest';  // or redirect to login page
    }

    // Check if the message is not empty
    if (!empty($message)) {
        // Insert the message along with the username into the 'contact' table
        $query = "INSERT INTO contact (Username, Message) VALUES ('$username', '$message')";
        if (mysqli_query($conn, $query)) {
            // Set success status for SweetAlert
            $_SESSION['status'] = 'Message sent successfully!';
            $_SESSION['status_code'] = 'success';
        } else {
            // Set error status for SweetAlert
            $_SESSION['status'] = 'Error sending message: ' . mysqli_error($conn);
            $_SESSION['status_code'] = 'error';
        }
    } else {
        // Set error status for empty message
        $_SESSION['status'] = 'Please enter a message.';
        $_SESSION['status_code'] = 'error';
    }

    // Redirect back to the same page to trigger SweetAlert
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
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
            icon: "<?php echo $_SESSION['status_code']; ?>", // 'success' or 'error'
            button: "OK",
        }).then(function() {
            window.location.href = 'index.php'; // Redirect after the alert
        });
    </script>
    <?php
    // Clear session variables after displaying alert
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>



<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>D، 36, Block-B Block BNorth Nazimabad Town, Karachi, Karachi City,Sindh 74700, Pakistan</li>
							<li>support@arts.com</li>
							<li>+92 111 222 3333</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box ">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="shop.php">Shop</a></li>
							<li><a href="category.php">Categories</a></li>
							<li><a href="feedback.php">Feedback</a></li>
							<li><a href="faqs.php">FAQs</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
							<h2 class="widget-title">Contact</h2>
							<p>Contact Us By Sending Hello To Us.</p>
							<form method="POST"> <!-- Send data to contact.php -->
								<input type="text" name="message" placeholder="Your message" required>
								<button type="submit" name="contact"><i class="fas fa-paper-plane"></i></button>
							</form>
						</div>
					</div>

			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2019 - All Rights Reserved.<br>
						Distributed By -Arts
					</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

</body>
</html>