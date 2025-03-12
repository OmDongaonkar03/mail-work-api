<?php
require 'vendor/autoload.php'; // Include PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * sendEmail - Sends an email using PHPMailer with a fallback to PHP's mail() function.
 *
 * @param string $recipient - Recipient email address.
 * @param string $subject - Email subject.
 * @param string $bodyContent - Email body (HTML supported).
 * @param string $sender - Sender email address.
 * @param string $sender_pass - Sender email password (or app password for security).
 * @return bool - Returns true if the email is sent successfully, false otherwise.
 */
function sendEmail($recipient, $subject, $bodyContent, $sender, $sender_pass) {
    // Attempt to send email using PHPMailer
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $sender;
        $mail->Password = $sender_pass;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom($sender, ''); // Sender name left blank for customization
        $mail->addAddress($recipient);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $bodyContent;

        if ($mail->send()) {
            return true;
        } else {
            throw new Exception($mail->ErrorInfo);
        }
    } catch (Exception $e) {
        // Fallback to native mail() function if PHPMailer fails
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: " . $sender . "\r\n";
        $headers .= "Reply-To: " . $sender . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        return mail($recipient, $subject, $bodyContent, $headers);
    }
}
?>
