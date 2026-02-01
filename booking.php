<?php
include "db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$name    = $_POST['name'];
$phone   = $_POST['phone'];
$email   = $_POST['email'];
$service = $_POST['service'];
$date    = $_POST['event_date'];
$msg     = $_POST['message'];

/* SAVE TO DATABASE */
mysqli_query($conn, "INSERT INTO bookings
(name, phone, email, service, event_date, message)
VALUES ('$name','$phone','$email','$service','$date','$msg')");

/* SEND EMAIL */
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yourgmail@gmail.com';
    $mail->Password   = 'GMAIL_APP_PASSWORD';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('yourgmail@gmail.com', 'Website Booking');
    $mail->addAddress('yourgmail@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'New Booking Received';
    $mail->Body = "
        <h3>New Booking</h3>
        <p><b>Name:</b> $name</p>
        <p><b>Phone:</b> $phone</p>
        <p><b>Email:</b> $email</p>
        <p><b>Service:</b> $service</p>
        <p><b>Date:</b> $date</p>
        <p><b>Message:</b> $msg</p>
    ";

    $mail->send();
} catch (Exception $e) {
    echo "Email error: {$mail->ErrorInfo}";
}

header("Location: index.html");
exit;
