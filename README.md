# Email Sending API

## Overview

This is a lightweight and easy-to-use email-sending API that allows developers to send emails using AJAX requests. It supports PHPMailer with a fallback to PHP's built-in `mail()` function.

## File Structure

```
📂 mail-api/
├── 📄 request_email.js      # Handles the AJAX request for sending emails
├── 📄 process_mail.php      # Processes incoming requests and interacts with mail_sender.php
├── 📄 mail_sender.php       # Sends emails using PHPMailer or PHP mail() as a fallback
├── 📄 README.md             # Documentation
└── 📄 LICENSE               # MIT License file
```

## How It Works

1. **`request_email.js`**

   - This JavaScript file collects user input and sends an AJAX POST request to `process_mail.php`.
   - It includes the sender’s email, password, recipients, subject, and message.

2. **`process_mail.php`**

   - Receives the AJAX request from `request_email.js`.
   - Extracts email details and forwards them to `mail_sender.php`.
   - Returns a JSON response indicating success or failure.

3. **`mail_sender.php`**

   - Uses PHPMailer to send emails via SMTP.
   - If PHPMailer fails, it falls back to PHP’s native `mail()` function.

---

## Installation & Setup

### 1. Clone the Repository

```sh
git clone https://github.com/yourusername/mail-api.git
cd mail-api
```

### 2. Install PHPMailer

Since `composer.json` and `composer.lock` are not included, install PHPMailer manually:

```sh
composer require phpmailer/phpmailer
```

### 3. Configure Permissions

Ensure `process_mail.php` and `mail_sender.php` have the correct permissions to execute.

---

## Usage

### 1. Include `request_email.js` in Your Frontend

```html
<script src="request_email.js"></script>
```

Ensure you have input fields with IDs matching those in `request_email.js`, such as:

```html
<input type="email" id="fromEmail" placeholder="Your Email">
<input type="password" id="passwordField" placeholder="App Password">
<input type="text" id="subject" placeholder="Email Subject">
<textarea id="htmlEditor" placeholder="Email Content"></textarea>
<button onclick="send_email()">Send Email</button>
```

### 2. Customize `mail_sender.php`

Modify the SMTP settings inside `mail_sender.php` to use your preferred email provider.

```php
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
```

💡 **Note:** If using Gmail, enable "Less Secure Apps" or generate an App Password.

### 3. Send an Email

After setup, call the `send_email()` function, and it will:

- Send a request to `process_mail.php`.
- Process the request and forward it to `mail_sender.php`.
- Attempt to send the email via PHPMailer (SMTP) or fall back to PHP `mail()`.
- Return a JSON response with success or failure messages.

---

## Example JSON Response

```json
{
  "success": ["recipient@example.com"],
  "failure": ["failed@example.com"]
}
```

---

## Troubleshooting

**1. Emails not being sent?**

- Ensure PHPMailer is installed (`composer require phpmailer/phpmailer`).
- Check if SMTP settings in `mail_sender.php` are correct.
- If using a local server, try using an SMTP relay service like SendGrid.

**2. Getting authentication errors?**

- If using Gmail, enable App Passwords instead of your regular password.
- Check if your hosting provider allows SMTP connections.

---

## Contributing

Feel free to fork this repository and submit pull requests for improvements!

---

## License

This project is open-source under the **MIT License**.

