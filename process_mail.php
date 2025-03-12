<?php
header('Content-Type: application/json');

// Handle email sending requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'mail_sender.php'; // Ensure this file exists and contains sendEmail function

    $sender = $_POST['sender'] ?? '';
    $recipients = json_decode($_POST['reciver'] ?? '[]', true);
    $sender_pass = $_POST['sender_pass'] ?? '';
    $email_subject = $_POST['email_subject'] ?? '';
    $email_content = $_POST['email_content'] ?? '';

    $success = [];
    $failure = [];

    foreach ($recipients as $recipient) {
        if (sendEmail($recipient, $email_subject, $email_content, $sender, $sender_pass)) {
            $success[] = $recipient;
        } else {
            $failure[] = $recipient;
        }
    }

    echo json_encode([
        "success" => $success,
        "failure" => $failure
    ]);
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
