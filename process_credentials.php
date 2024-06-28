<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dsn = 'sqlite:C:\Users\17_karthick_03\OneDrive\Documents\Program\HTML\SEM---5\user_database.db';
try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $regNo = $_POST['regNo'];
        $dob = $_POST['dob'];

        $stmt = $pdo->prepare('SELECT EMAIL FROM users WHERE regNo = :regNo AND dob = :dob');
        $stmt->execute(['regNo' => $regNo, 'dob' => $dob]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $email = $user['EMAIL'];
            $code = rand(100000, 999999);
            $_SESSION['verification_code'] = $code;

            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'trackmyclass.site@gmail.com';
                $mail->Password = 'oyfludgunwpftizh';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('trackmyclass.site@gmail.com', 'TrackMyClass');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body    = "Your verification code is $code";

                $mail->send();
                $_SESSION['username'] = $regNo;
                header('Location: verification.php');
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'Invalid credentials.';
        }
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
