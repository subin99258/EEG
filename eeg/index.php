<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['backTo'] = '../index.php';



// Include database mysql functions
require('../model/database.php');
require('../model/eeg_db.php');
require('../model/publications_db.php');
require('../model/public_user_db.php');

// Include PHPMailer classes
require_once '../PHPMailer-master/src/PHPMailer.php';
require_once '../PHPMailer-master/src/SMTP.php';
require_once '../PHPMailer-master/src/Exception.php';

// Create a new PHPMailer instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

//Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);     // Enable logging errors to file
$LogDir = __DIR__ . '/../errors/logs/';
$eegLogFile = $LogDir . 'eeg_error.log';
ini_set('error_log', $eegLogFile);


$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'list_eeg';
    }
}

if ($action === 'list_eeg') {
    $eegArray = get_approved_eegs();
    include('eeg_list.php');

} else if ($action == 'downloadEEG') {
    $researcher = filter_input(INPUT_POST, 'researcher');
    $eegID = filter_input(INPUT_POST, 'eegID');
    $title = filter_input(INPUT_POST, 'eegTitle');
    $eegLink = filter_input(INPUT_POST, 'eegLink');
 

    //store title in session
    $_SESSION['eeg_title'] = $title;
    $_SESSION['eeg_link'] = $eegLink;
    $_SESSION['eeg_id'] = $eegID;
    $_SESSION['backTo'] = './index.php';

    include('eeg_approval.php');

} else if($action === 'DLLinkedpub') {
    $researcher = filter_input(INPUT_POST, 'researcher');
    $pubID = filter_input(INPUT_POST, 'pubToDL');
    $title = getPubTitle($pubID);
    $pubLink = getPubLink($pubID);        
    $_SESSION['pubLink'] = $pubLink;  
    $_SESSION['backTo'] = './index.php';  
    include('../confirmations/downloadPub.php');

}else if ($action === 'eeg_agree'){
    $eegLink = $_SESSION['eeg_link'];
    $eegTitle = $_SESSION['eeg_title'];
    $firstName = filter_input(INPUT_POST, 'first_name');
    $lastName = filter_input(INPUT_POST, 'last_name');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $eegID =  $_SESSION['eeg_id'];
    $timestamp = date('Y-m-d H:i:s'); 
    $token = bin2hex(random_bytes(4)); 
    //validation
    if ($firstName === '') {
        $error = "First Name is required.";
        include('../errors/error.php');
    } else if ($lastName === '') {
        $error = "Last Name is required.";
        include('../errors/error.php');
    } else if ($email === FALSE) {
        $error = "Email address is not valid.";
        include('../errors/error.php');
    }

    if (empty($error)) {
        try {
            // specify SMTP credentials
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'subinmaharjan01@gmail.com';
            $mail->Password = 'jqan tbgo hexr lgms';       
            
             // Recipients
            $mail->setFrom('subinmaharjan01@gmail.com', 'EEG and Publications Platform');
            $mail->addAddress('subinmaharjan01@gmail.com', 'Manager');
            $mail->Subject = 'A new user would like to download EEG data';

            // Enable HTML if needed
            $mail->isHTML(true);
		
            //Email body
            $bodyParagraphs = [
                    "First Name: {$firstName}",
                    "Last Name: {$lastName}", 
                    "Email: {$email}", 
                    "EEG ID: {$eegID}",
                    "EEG Title: {$eegTitle}",
                    "ID : {$token}",
               		   "<a href='http://localhost/accept.php?token={$token}' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007bff; text-decoration: none; 				border-radius: 5px;'>Accept request</a>"
		
            ];

            //Join paragraphs with HTML line breaks
            $body = join('<br />', $bodyParagraphs);

            //Assigning constructed HTML body to email
            $mail->Body = $body;
	    
            if($mail->send()){
                add_public_user($eegTitle, $firstName, $lastName, $email, $eegID, $timestamp, $token);
                $confirmation = "Thank you for submitting your details. We have received your information and 
                will send you a download link shortly. Please check your email inbox (and spam/junk folder) 
                for the download link. </br> Please <a href='../contactUs/contact_us_form.php'> contact us here </a> 
                 for further assistance.";
		 include("../confirmations/confirmed.php");
                exit;
            } else {
                // Log the error to specific mail_error.log
                $logMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                error_log($logMessage, 3, $eegLogFile);

                // Display error to the user
                $error = 'Oops, something went wrong while sending the message. Please try again later.';
                include('../errors/error.php');
            }
           echo 'Message has been sent';
        } catch (Exception $e) {
            $logMessage = "Message could not be sent. Mailer Error: {$e->getMessage()}";
            error_log($logMessage, 3, $eegLogFile);

            // Display error to the user
            $error = 'Oops, something went wrong. Please try again later.';
            include('../errors/error.php');
        }

    }
}





?>