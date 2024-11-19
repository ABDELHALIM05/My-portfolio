<?php

// Replace this with your own email address
$siteOwnersEmail = 'yaiche.abdelhalim@gmail.com';

if ($_POST) {
    // Sanitize and trim inputs
    $name = htmlspecialchars(trim($_POST['contactName']));
    $email = htmlspecialchars(trim($_POST['contactEmail']));
    $subject = htmlspecialchars(trim($_POST['contactSubject']));
    $contact_message = htmlspecialchars(trim($_POST['contactMessage']));

    $error = [];

    // Validate Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    // Validate Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    // Default Subject
    if ($subject == '') {
        $subject = "Contact Form Submission";
    }

    // Prepare Message
    $message = "<strong>Email from:</strong> " . $name . "<br />";
    $message .= "<strong>Email address:</strong> " . $email . "<br />";
    $message .= "<strong>Message:</strong><br />";
    $message .= nl2br($contact_message); // Preserve line breaks
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header
    $from = $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send Email
    if (empty($error)) {
        ini_set("sendmail_from", $siteOwnersEmail); // For Windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }
    } else {
        // Return validation errors
        $response = '';
        foreach ($error as $key => $value) {
            $response .= $value . "<br />";
        }
        echo $response;
    }
}
?>
