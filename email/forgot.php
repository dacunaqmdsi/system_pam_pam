<?php
$db_connection = mysqli_connect("localhost", "root", "", "pam");
// include('../connection_short.php');
if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer();
$mail->isSMTP();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // Check if the email exists in tblaccounts
    $stmt = mysqli_prepare($db_connection, "SELECT id FROM users WHERE email_official = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $accountid);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime("+2 minutes")); // Expiry time set to 2 minutes

        // Store the token in tblforgot_otp
        $stmt = mysqli_prepare($db_connection, "INSERT INTO tblforgot_otp (accountid, email, token, expiry) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isss", $accountid, $email, $token, $expiry);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Use https for the reset link (important for security)
        $reset_link = "https://procurementassets.org/forgot/forgot.php?email=$email&token=$token";

        $message = "Follow this link to reset your password. This link will expire in 2 minutes: <a href='$reset_link'>$reset_link</a>";

        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'scholarship941@gmail.com';
        $mail->Password = 'mpefvbprqizgbtyb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('scholarship941@gmail.com', 'Procurement & Assets Management System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = $message;

        try {
            if ($mail->send()) {
                echo 'success';
            } else {
                echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $e->getMessage();
        }
    } else {
        echo "Email not found in the system.";
    }

    mysqli_close($db_connection);
}
?>
