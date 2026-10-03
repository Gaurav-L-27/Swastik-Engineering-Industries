<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method Not Allowed");
}

/*
|--------------------------------------------------------------------------
| Receiver email
|--------------------------------------------------------------------------
*/

$receiver_email = "swastikengindustries@gmail.com";


/*
|--------------------------------------------------------------------------
| Get form data
|--------------------------------------------------------------------------
*/

$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$phone   = trim($_POST["phone"] ?? "");
$service = trim($_POST["service"] ?? "");
$message = trim($_POST["message"] ?? "");


/*
|--------------------------------------------------------------------------
| Validate required fields
|--------------------------------------------------------------------------
*/

if ($name === "" || $email === "" || $message === "") {
    http_response_code(400);
    exit("Please fill in all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit("Please enter a valid email address.");
}


/*
|--------------------------------------------------------------------------
| Prevent email header injection
|--------------------------------------------------------------------------
*/

$name    = str_replace(["\r", "\n"], "", $name);
$email   = str_replace(["\r", "\n"], "", $email);
$phone   = str_replace(["\r", "\n"], "", $phone);
$service = str_replace(["\r", "\n"], "", $service);


/*
|--------------------------------------------------------------------------
| Email subject
|--------------------------------------------------------------------------
*/

$subject = "New Quote Request - " . $service;


/*
|--------------------------------------------------------------------------
| Email body
|--------------------------------------------------------------------------
*/

$email_body = "You have received a new quote request.\n\n";

$email_body .= "----------------------------------------\n";
$email_body .= "CUSTOMER INFORMATION\n";
$email_body .= "----------------------------------------\n\n";

$email_body .= "Full Name: " . $name . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Phone: " . ($phone ?: "Not provided") . "\n";
$email_body .= "Service Needed: " . $service . "\n\n";

$email_body .= "----------------------------------------\n";
$email_body .= "PROJECT DETAILS\n";
$email_body .= "----------------------------------------\n\n";

$email_body .= $message . "\n\n";

$email_body .= "----------------------------------------\n";
$email_body .= "This request was submitted from your website.\n";
$email_body .= "----------------------------------------\n";


/*
|--------------------------------------------------------------------------
| Email headers
|--------------------------------------------------------------------------
|
| No domain email is required here.
| PHP/hosting will determine the sender.
|
*/

$headers  = "Reply-To: " . $email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


/*
|--------------------------------------------------------------------------
| Send email
|--------------------------------------------------------------------------
*/

if (mail($receiver_email, $subject, $email_body, $headers)) {

    echo "success";

} else {

    http_response_code(500);
    echo "Unable to send your request. Please try again later.";
}

?>