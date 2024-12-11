<?php
include('connection.php');
include('header.php');
?>
	<!-- contact form -->
	<div class="contact-from-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
						<div class="section-title">	
						<h3>Feedback<span class="orange-text"> Form</span></h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
					<div class="form-title">
						<h2>Give Us Your Feedback</h2>
						<p>"Your feedback is valuable to us and helps improve our services. We appreciate you taking the time to share your thoughts!"</p>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
						<form method="POST" id="fruitkha-contact" enctype="multipart/form-data">
							<p>
								<input type="text" placeholder="Name" name="name" id="name">
								<input type="email" placeholder="Email" name="email" id="email">
							</p>
							<p >
							<input type="tel" placeholder="Phone" name="phone" id="phone">
							<input type="file" name="picture" class="btn">
							</p>
							<p><textarea name="feedback" id="message" cols="30" rows="10" placeholder="Feedback"></textarea></p>
							<input type="hidden" name="token" value="FsWga4&@f6aw" />
							<p><input type="submit" value="Submit" name="submit"></p>
						</form>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="contact-form-wrap">
						<div class="contact-form-box">
							<h4><i class="fas fa-map"></i> Shop Address</h4>
							<p>D، 36, Block-B Block B   <br>North Nazimabad Town, Karachi, Karachi City,<br>Sindh 74700, Pakistan</p>
						</div>
						<div class="contact-form-box">
							<h4><i class="far fa-clock"></i> Shop Hours</h4>
							<p>MON - FRIDAY: 8 to 9 PM <br> SAT - SUN: 10 to 8 PM </p>
						</div>
						<div class="contact-form-box">
							<h4><i class="fas fa-address-book"></i> Contact</h4>
							<p>Phone: +92 3123456890 <br> Email: support@Arts.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end contact form -->

	<!-- find our location -->
	<div class="find-location blue-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<p> <i class="fas fa-map-marker-alt"></i> Find Our Location</p>
				</div>
			</div>
		</div>
	</div>
	<!-- end find our location -->

	<!-- google map section -->
	<div class="embed-responsive embed-responsive-21by9">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d904.5396679840377!2d67.03482139923423!3d24.926663976123237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f90157042d3%3A0x93d609e8bec9a880!2sAptech%20Computer%20Education%20North%20Nazimabad%20Center!5e0!3m2!1sen!2s!4v1731563970511!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="embed-responsive-item"></iframe>	</div>
	<!-- end google map section -->


	<?php
include('footer.php');

if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$feedback = $_POST['feedback'];
	$image_name = $_FILES['picture']['name'];
	$temp_name = $_FILES['picture']['tmp_name'];
	$image_type = $_FILES['picture']['type'];
	$image_size = $_FILES['picture']['size'];
	$folder = "assets/img/avaters/";

	if ($image_type == "image/png" || $image_type == "image/jpg" || $image_type == "image/jpeg") {
		$path = $folder . $image_name;

		// Move the uploaded image to the target folder
		if (move_uploaded_file($temp_name, $path)) {
			$q = "INSERT INTO feedback(Name,Email, Phone,  Picture, Feedback) VALUES ('$name','$email', '$phone',  '$path', '$feedback')";
			$result = mysqli_query($conn, $q);

			if ($result) {
				echo "<script>alert('Feedback Submitted Successfully');</script>";
			} else {
				echo "<script>alert('Failed to submit feedback');</script>";
			}
		} else {
			echo "<script>alert('Failed to upload image');</script>";
		}
	} else {
		echo "<script>alert('Invalid image type');</script>";
	}
}
?>