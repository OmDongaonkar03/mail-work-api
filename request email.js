/**
 * send_email.js - A standalone JavaScript function for sending emails.
 *
 * NOTE:
 * - Ensure that "to_email_arr" (an array of recipient emails) is defined.
 * - Update the element IDs ('fromEmail', 'passwordField', 'subject', 'htmlEditor') to match your HTML.
 * - Change the API endpoint ("send_mail.php") if necessary.
 */

let to_email_arr = []; // Array to store recipient emails

// Function to add an email to the recipient list
function addemail() {
    let to_email = document.getElementById('toEmail').value;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (emailPattern.test(to_email)) {
        to_email_arr.push(to_email);
        console.log(to_email_arr);
        document.getElementById('toEmail').value = ""; // Clear input field
    } else {
        alert("Invalid email format!");
    }
}

// Function to send an email request
function send_email() {
    if (to_email_arr.length !== 0) {
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "process_mail.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        let sender_email = encodeURIComponent(document.getElementById('fromEmail').value);
        let sender_pass  = encodeURIComponent(document.getElementById('passwordField').value);
        let email_subject = encodeURIComponent(document.getElementById('subject').value);
        let email_content = encodeURIComponent(document.getElementById('htmlEditor').value);
        let reciver = encodeURIComponent(JSON.stringify(to_email_arr));

        let params = `sender=${sender_email}&reciver=${reciver}&sender_pass=${sender_pass}&email_subject=${email_subject}&email_content=${email_content}`;

        xhttp.onreadystatechange = function () {
            if (xhttp.readyState === 4) {
                try {
                    let response = JSON.parse(xhttp.responseText);
                    if (xhttp.status === 200) {
                        console.log("Email sent successfully:", response);
                    } else {
                        console.error("Error sending email!");
                    }
                } catch (error) {
                    console.error("Server error: Invalid JSON response.");
                }
            }
        };

        xhttp.send(params);
    } else {
        alert('Empty recipient list');
    }
}
