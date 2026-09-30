<?php

header('Content-Type: application/json; charset=UTF-8');


/*
|--------------------------------------------------------------------------
| Receiver email
|--------------------------------------------------------------------------
*/

$receiverEmail = 'your@email.com';


/*
|--------------------------------------------------------------------------
| Check request
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get form values
|--------------------------------------------------------------------------
*/

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$service = trim($_POST['service'] ?? '');
$message = trim($_POST['message'] ?? '');


/*
|--------------------------------------------------------------------------
| Validate
|--------------------------------------------------------------------------
*/

if ($name === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter your name.'
    ]);

    exit;
}


if ($email === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter your email.'
    ]);

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);

    exit;
}


if ($message === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter your project details.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Email subject
|--------------------------------------------------------------------------
*/

$subject = 'New Quote Request - ' . $name;


/*
|--------------------------------------------------------------------------
| Email body
|--------------------------------------------------------------------------
*/

$emailBody = "
NEW QUOTE REQUEST
==============================

Name:
$name

Email:
$email

Phone:
$phone

Service:
$service

Project Details:
$message

==============================
Website Quote Form
";


/*
|--------------------------------------------------------------------------
| Headers
|--------------------------------------------------------------------------
*/

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

/*
 * IMPORTANT:
 * Use an email address from YOUR domain here.
 */
$headers .= "From: Website <noreply@yourdomain.com>\r\n";

$headers .= "Reply-To: $email\r\n";


/*
|--------------------------------------------------------------------------
| Send
|--------------------------------------------------------------------------
*/

$sent = mail(
    $receiverEmail,
    $subject,
    $emailBody,
    $headers
);


/*
|--------------------------------------------------------------------------
| Response
|--------------------------------------------------------------------------
*/

if ($sent) {

    echo json_encode([
        'success' => true,
        'message' => 'Email sent successfully.'
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'PHP could not send the email.'
    ]);
}

exit;
