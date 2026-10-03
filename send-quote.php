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

if (empty($name) || empty($email) || empty($message)) {
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

$name = str_replace(["\r", "\n"], "", $name);
$email = str_replace(["\r", "\n"], "", $email);
$phone = str_replace(["\r", "\n"], "", $phone);
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

$email_body = "
You have received a new quote request.

----------------------------------------
CUSTOMER INFORMATION
----------------------------------------

Full Name:
$name

Email:
$email

Phone:
$phone

Service Needed:
$service

----------------------------------------
PROJECT DETAILS
----------------------------------------

$message

----------------------------------------
This request was submitted from your website.
----------------------------------------
";


/*
|--------------------------------------------------------------------------
| Email headers
|--------------------------------------------------------------------------
*/

$headers = "From: Website Quote Form <no-reply@" . $_SERVER["SERVER_NAME"] . ">\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
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