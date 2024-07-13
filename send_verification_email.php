<?php
function sendVerificationEmail($username, $email, $token) {
    $subject = "Verify your account";
    $message = "
    <html>
    <head>
    <title>Verify your account</title>
    </head>
    <body>
    <p>Thank you for registering. Please click the link below to verify your account:</p>
    <a href='http://localhost/verify_user.php?username=$username&token=$token'>Verify Account</a>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    if (mail($email, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}
?>
