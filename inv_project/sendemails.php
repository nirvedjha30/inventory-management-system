<?php

$to_email = "nimishaj2023@gmail.com";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is test email send by PHP Script";
$headers = "From: nirvedj2023@gmail.com";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}
// https://myaccount.google.com/u/3/security?pli=1&nlr=1
?>