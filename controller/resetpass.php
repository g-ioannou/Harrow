<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../login/PHPMailer-master/src/Exception.php';
require '../login/PHPMailer-master/src/PHPMailer.php';
require '../login/PHPMailer-master/src/SMTP.php';

include '../model/connection_db.php';

    
    if(isset($_POST["email"])){
        
        $emailTo = $_POST["email"];
        $code = uniqid(true);
        
        $query = mysqli_query($conn, "UPDATE user SET user.token ='$code' WHERE email='$emailTo'");
        
        $query_email = mysqli_query($conn, "SELECT email FROM user WHERE email='$emailTo'");
        

        if(mysqli_num_rows($query_email) == 0){
            echo '<p style="color:  rgb(116, 17, 0);text-align: center;margin: 10%;font-size:x-large;">We do not have an account with this email.</p>';
            
        }
        else{

        if(!$query){
            exit("Error");
        }
        
            
            
        else{
            
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/harrow/controller/resetPassword.php?code='.$code;
            
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
                echo '<p style="color:  rgb(116, 17, 0);text-align: center;margin: 10%;font-size:x-large;">Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>'. $mail->ErrorInfo;
                
            }
            //exit();
        //}
        }
    }
    exit();
}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../view/resetpass.css">
    
    <title>Reset Password</title>
</head>
<body>
    <!--Reset Password-->

    <div class="form-container">
        <form method="POST" class="form-wrap">
            <div id="reset_error"></div>

            <h3>Reset password</h3>
            <p>Enter your email and we will sent you a link to reset your password.</p>

            <div class="form-reset">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required="">
            </div>
            
            <div class="form-submit">
            <input type="submit" value="Send" id="reset_btn">
            or <a href="../view/login.html">Back to Login</a>
            </div>

        </form>
    </div>

</body>
</html>

