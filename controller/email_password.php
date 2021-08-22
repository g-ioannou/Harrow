<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

include '../view/login/email_password.html';
include '../model/connection_db.php';



if (isset($_POST["email"])) {

    $emailTo = $_POST["email"];
    $code = uniqid(true);

    $query = mysqli_query($conn, "UPDATE user SET user.token ='$code' WHERE email='$emailTo'");

    $query_email = mysqli_query($conn, "SELECT email FROM user WHERE email='$emailTo'");


    if (mysqli_num_rows($query_email) == 0) {
        echo '<p style="color:  rgb(116, 17, 0);text-align: center;margin: 10%;font-size:x-large;">We do not have an account with this email.</p>';
    } else {

        if (!$query) {
            exit("Error");
        } else {

            $url = 'http://' . $_SERVER['SERVER_NAME'] . '/harrow/controller/reset_password.php?code=' . $code;

            $output = "<h3>You requested a password reset.</h3> Click <a href='$url'>this link.</a>";



            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'harrowharrow572@gmail.com';                     // SMTP username
                $mail->Password   = 'Harrow123!';                               // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('harrowharrow572@gmail.com', 'Harrow');
                $mail->addAddress($emailTo);     // Add a recipient
                $mail->addReplyTo('no-reply@gmail.com', 'No-reply');

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Reset Password ';
                $mail->Body    = $output;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



                $mail->send();
                echo '<p style="color:   rgb(0, 41, 51);text-align: center;margin: 10%;font-size:x-large;">Reset password link has been sent to your email.</p>';
            } catch (Exception $e) {
                echo '<p style="color:  rgb(116, 17, 0);text-align: center;margin: 10%;font-size:x-large;">Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>' . $mail->ErrorInfo;
            }
        }
    }

    
    exit();
}
?>