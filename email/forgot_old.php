<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require '../includes/systemconfig.php'; // Include database connection

$mail = new PHPMailer();
$mail->isSMTP();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // Check if the email exists in tblaccounts
    $stmt = mysqli_prepare($db_connection, "SELECT accountid FROM tblaccounts WHERE emailaddress = ?");
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

        // Email setup
        $subject = "Reset Your Password";
        $title = "Forgot Password";
        $reset_link = "https://procurementassets.org/forgot/forgot?email=$email&token=$token";

        $message = "Follow this link to reset your password. This link will expire in 2 minutes: <a href='$reset_link'>$reset_link</a>";

        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gradisys@gradisys.studentassist.site';
        $mail->Password = 'e*o5=fRT253Z';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('gradisys@gradisys.studentassist.site', 'gradisys.studentassist.site');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        try {
            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        echo "Email not found in the system.";
    }

    mysqli_close($db_connection);
}
