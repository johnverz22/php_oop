<?php
namespace App\Controllers;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController{
    public function index(){
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->isSMTP();                                           // Send using SMTP
            $mail->Host       = 'smtp.mailtrap.io';                     // Set the SMTP server to send through (for example, Mailtrap)
            $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
            $mail->Username   = 'your_smtp_username';                    // SMTP username
            $mail->Password   = 'your_smtp_password';                    // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
            $mail->Port       = 587;                                      // TCP port to connect to

            //Recipients
            $mail->setFrom('johnverz@gmail.com', 'Mailer');
            $mail->addAddress('johnverz@lorma.edu', 'Joe User');     // Add a recipient

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Test Email via Composer';
            $mail->Body    = 'This is a <b>test email</b> sent via Composer and PHPMailer.';
            $mail->AltBody = 'This is the plain text version of the email content.';

            // Send email
            if($mail->send()) {
                echo 'Message has been sent';
            } else {
                echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}