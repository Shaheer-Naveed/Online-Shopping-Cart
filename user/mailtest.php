<?php
// Include the necessary PHPMailer files
require 'F:\xammp\htdocs\Arts\user\src\PHPMailer.php';
require 'F:\xammp\htdocs\Arts\user\src\SMTP.php';
require 'F:\xammp\htdocs\Arts\user\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Set up the mail server
    $mail->isSMTP();                                      // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                       // Set the SMTP server (example: Gmail, SMTP server of your email provider)
    $mail->SMTPAuth = true;                                 // Enable SMTP authentication
    $mail->Username = 'shaheernaveed2020@gmail.com';        // SMTP username
    $mail->Password = 'qick yhpd gzva ulvo';            // Use the App password generated above
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption
    $mail->Port = 587;                                     // TCP port to connect to

    // Assuming the customer's email is passed as part of the checkout form (this will be set from checkout.php)
    $customer_email = isset($_POST['email']) ? $_POST['email'] : ''; // Get customer email from POST request
    
    if (empty($customer_email)) {
        echo "Error: Customer email is missing.";
        exit;
    }

    // Recipients
    $mail->setFrom('shaheernaveed2020@gmail.com', 'Shaheer');   // From email address and name
    $mail->addAddress($customer_email);          // Add the customer's email dynamically

    // Content
    $mail->isHTML(true);                                    // Set email format to HTML
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<p>This is a test email sent using PHPMailer.</p>';

    // Send the email
    $mail->send();
    echo 'Message has been sent successfully to ' . $customer_email;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
