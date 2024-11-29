<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'travia.sae.contact@gmail.com';
        $mail->Password = 'pkvu bofg klji vows';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, "$first_name $last_name");
        $mail->addAddress('travia.sae.contact@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = "Contact Form Submission from $first_name $last_name";
        $mail->Body = nl2br("Message: $message\n\nEmail: $email");

        $mail->send();
        echo "<script>alert('Your message has been sent with sucess. Thanks to contact us !');</script>";
    } catch (Exception $e) {
        echo "<script>alert('An error has occured. Please try again. Error: {$mail->ErrorInfo}');</script>";
    }
    header("Location: ../src/contact.php?success=1");
} else {
    header("Location: ../src/contact.php?error=1");
    exit();
}
?>
