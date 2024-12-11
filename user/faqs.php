<?php
include('header.php');
include('connection.php');

// Fetch FAQs from the database
$sql = "SELECT * FROM faqs LIMIT 5";
$result = mysqli_query($conn, $sql);

$faqs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 lg-4 text-center">
            <div class="section-title">
                <h3>Feedback<span class="orange-text"> Form</span></h3>
            </div>
        </div>
    </div>

    <div style="margin: 20px; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);">
        <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item mb-3 text-center">
                <h4 style="font-size:2rem;">
                    <a class="text-start w-50" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $index; ?>">
                    Q. <?php echo $faq['Question']; ?> <i class="fa-solid fa-arrows-up-down mx-3"></i>
                    </a>
                </h4>
                <div id="faq-<?php echo $index; ?>" class="collapse">
                    <p class="mt-2" style="font-family:'Poppins',sans-serif;font-size:1.5rem;">A. <?php echo $faq['Answer']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col-md-12 mt-5 text-center">
            <div class="section-title">
                <h3>Submit <span class="orange-text"> Your </span> Question</h3>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <div class="contact-form">
                <form method="POST">
                    <p>
                        <textarea id="question" placeholder="Enter your question here" name="question" rows="4" class="w-50" style="font-family:'Poppins',sans-serif;font-size:1.5rem;" required></textarea>
                    </p>
                    <button class="boxed-btn mb-4" type="submit" name="send">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');

// Handling form submission
if (isset($_POST['send'])) {
    $question = $_POST['question'];
    $q = "INSERT INTO faqs (Customer_Question) VALUES ('$question')";
    $result2 = mysqli_query($conn, $q);
    
    if ($result2) {
        // Success message
        $_SESSION['status'] = "Your Question is Submitted!";
        $_SESSION['status_code'] = "success";
    } else {
        // Error message
        $_SESSION['status'] = "Submission Failed! Please try again.";
        $_SESSION['status_code'] = "error";
    }

    // Redirect the page to show SweetAlert and avoid duplicate SweetAlert invocation
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<?php
// Display SweetAlert only if there's a session status
if (isset($_SESSION['status'])) {
    // SweetAlert will be displayed when the page reloads after form submission
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
        }).then(function() {
            window.location.reload(); // Reloads the page after SweetAlert closes
        });
    </script>
    <?php 
    unset($_SESSION['status']); // Clear the session status to avoid showing the alert again
    unset($_SESSION['status_code']);
}
?>
