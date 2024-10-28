<?php
session_start();
include('db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token) {
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'kyckiziah@gmail.com'; // Your SMTP username
    $mail->Password = 'jlbazuogtipptwgh'; // Your SMTP password or app password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 465;

    // Recipients
    $mail->setFrom('kyckizia@gmail.com', 'kyckiziah');
    $mail->addAddress($email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Email verification from kyckiziah ';

    $email_template = "
        <h2>You have Registered with Login Form of kyckiziah.</h2>
        <h5>Verify your email to Login with the link below.</h5>
        <br/><br/>
        <a href='http://localhost/kiziah/LOG_IN_FORM_EMAIL/verify-email.php?token=$verify_token'>Click Here to Verify</a>
    ";

    $mail->Body = $email_template;

    // Send email
    if (!$mail->send()) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }
}

if (isset($_POST['register_btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $verify_token = md5(rand());

    // Check if the email exists
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email ID already exists.";
        header("Location: register.php");
        exit();
    } else {
        // Insert user into the database
        $query = "INSERT INTO users (name, phone, password, email, verify_token) VALUES ('$name', '$phone', '$password', '$email', '$verify_token')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            sendemail_verify($name, $email, $verify_token);

            $_SESSION['status'] = "Registration successful. Verify your email address.";
            header("Location: register.php");
            exit();
        } else {
            $_SESSION['status'] = "Registration failed.";
            header("Location: register.php");
            exit();
        }
    }
}
?>