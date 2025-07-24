<?php

namespace App\Core\Utilities\Mail;

use PHPMailer\PHPMailer\PHPMailer;

require_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once 'vendor/phpmailer/phpmailer/src/SMTP.php';
require_once 'vendor/phpmailer/phpmailer/src/Exception.php';

class Mail
{
    public static function Send($receiver,$password) {

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.cumhuriyet.edu.tr';
        $mail->SMTPAuth = true;
        $mail->Username = '2021304036@cumhuriyet.edu.tr';
        $mail->Password = 'Enes.1907'; // Şifrenizi veya uygulama şifresini girin
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('2021304036@cumhuriyet.edu.tr', 'Mailer');
        $mail->addAddress($receiver, 'Receiver Name');
        $mail->isHTML(true);
        $mail->Subject = 'DUGUN SALONU OTOMASYONU';
        $mail->Body = 'Yeni Password ' .$password;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->send();
    }
    catch (\Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    }
}
