<?php
// Include PHPMailer classes
require_once '../PHPMailer-master/src/PHPMailer.php';
require_once '../PHPMailer-master/src/SMTP.php';
require_once '../PHPMailer-master/src/Exception.php';

// Create a new PHPMailer instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

//Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);     // Enable logging errors to file
$LogDir = __DIR__ . '/../errors/logs/';
$mailLogFile = $LogDir . 'mail_error.log';
ini_set('error_log', $mailLogFile);


$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'contactUs_form';
    }
}

if ($action === 'contactUs_form') {
    include('contact_us_form.php');
} if($action === 'Submit'){
    $Name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message');


    //validation
    if ($Name === '') {
        $error = "Name is required.";
        include('../errors/error.php');
    } else if ($email === FALSE) {
        $error = "Email address is not valid.";
        include('../errors/error.php');
    } else if($message === ''){
        $error = "Please include a message.";
        include('../errors/error.php');
    }

    if (empty($error)) {
        try {
            // specify SMTP credentials
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
	    $mail->SMTPAuth = true;
	    $mail->Username = 'subinmaharjan01@gmail.com';
            $mail->Password = 'jqan tbgo hexr lgms';
	    $mail->SMTPSecure  = 'tls';     
            $mail->Port = 587;
            
             // Recipients
            $mail->setFrom('subinmaharjan01@gmail.com', 'EEG and Publications Platform');
            $mail->addAddress('subinmaharjan01@gmail.com', 'Manager');
            $mail->Subject = 'New message from EEG and Publications Platform';

            // Enable HTML if needed
            $mail->isHTML(true);

            //Email body
            $bodyParagraphs = [
                    "Name: {$Name}",
                    "Email: {$email}", 
                    "Message:</br>", nl2br(htmlspecialchars($message))                    
            ];

            //Join paragraphs with HTML line breaks
            $body = join('<br />', $bodyParagraphs);

            //Assigning constructed HTML body to email
            $mail->Body = $body;
	   

            if($mail->send()){
               $confirmation = "Thank you for your message. We will be in contact with you shortly.";
                include("../confirmations/confirmed.php");
		 
                exit;
            } else {
                // Log the error to specific mail_error.log
                $logMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                error_log($logMessage, 3, $mailLogFile);

                // Display error to the user
                $error = 'Oops, something went wrong while sending the message. Please try again laterr.';
                include('../errors/error.php');
            }
           
        } catch (Exception $e) {
            $logMessage = "Message could not be sent. Mailer Error: {$e->getMessage()}";
            error_log($logMessage, 3, $mailLogFile);

            // Display error to the user
            $error = 'Oops, something went wrong. Please try again later.';
            include('../errors/error.php');
        }

    }


}

// https://github.com/PHPMailer/PHPMailer
?>