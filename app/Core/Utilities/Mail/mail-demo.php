<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php'; // Autoload PHPMailer classes

function Send($alici)
{
    $mail = new PHPMailer(true);

    try {
        // Enable verbose debug output for troubleshooting (0 for no output, 1 for errors, 2 for all messages)
        $mail->SMTPDebug = 2;

        // Set mailer to use SMTP
        $mail->isSMTP();

        // Specify main SMTP server
        $mail->Host = 'smtp.gmail.com';

        // Enable SMTP authentication
        $mail->SMTPAuth = true;

        // Gmail account credentials
        $mail->Username = 'enescemcir94@gmail.com'; // Gmail address
        $mail->Password = '4C586060'; // Your Gmail App Password or actual Gmail password (if you have 2-step verification enabled, you need to use an app-specific password)

        // Set email encryption to TLS (the most commonly used)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set the sender's email address and name
        $mail->setFrom('enescemcir94@gmail.com', 'Mailer');

        // Add a recipient
        $mail->addAddress($alici, 'Recipient Name');  // Dynamic recipient address

        // Add an attachment
        $mail->addAttachment('files/enes.jpg'); // Optional: you can skip this line if no attachment

        // Set email format to HTML
        $mail->isHTML(true);

        // Set email subject and body
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // Send the email
        $mail->send();
        echo 'Message has been sent successfully';
    } catch (Exception $e) {
        // Output the error message if the email could not be sent
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

Send('enescemcir1994@gmail.com');
?>
