<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include PHPMailer classes
require_once '../PHPMailer-master/src/PHPMailer.php';
require_once '../PHPMailer-master/src/SMTP.php';
require_once '../PHPMailer-master/src/Exception.php';

// Create a new PHPMailer instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

// Include necessary files
require('../model/database.php');
require('../model/researcher_db.php');
require('../model/publications_db.php');
require('../model/eeg_db.php');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);     // Enable logging errors to file

$LogDir = __DIR__ . '/../errors/logs/';
$resLogFile = $LogDir . 'res_error.log';
ini_set('error_log', $resLogFile);

$errors = [];

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'researcher_menu';
    }
}

// Switch based on action
switch ($action) {
    case 'researcher_menu':
        if (isset($_SESSION['userID'])) {
            header('Location: researcher_portal.php');
            exit;
        } else {
            include('researcher_menu.php');
        }
        break;

    case 'logout':
        header("Location: ../logout.php");
        exit;

    case 'researcher_login':
        // Validate and sanitize inputs
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Validate email and password
        if (empty($email) || empty($password)) {
            $errors[] = 'Email and password are required fields.';
            $_SESSION['backTo'] = 'researcher_login.php'; // Set to login page for back button
        } else {
            // Hash the password securely
            $hashed_password = hash('sha256', $password);

            // Validate login credentials
            $researcherID = is_valid_researcher_login($email, $hashed_password);

            if ($researcherID !== false) {
                $_SESSION['userID'] = $researcherID;

                // Fetch additional researcher data
                $researcher_data = get_researcher_row($researcherID);
                $_SESSION['userRole'] = $researcher_data['userRole'];
                $_SESSION['username'] = $researcher_data['username'];
                $_SESSION['backTo'] = 'researcher_portal.php';

                // Redirect to researcher portal
                header('Location: researcher_portal.php');
                exit;
            } else {
                $errors[] = 'Incorrect email or password.';
                $_SESSION['backTo'] = 'researcher_login.php';
            }
        }

        // Display errors or confirmation
        if (!empty($errors)) {
            include('../errors/error.php');
        }
        break;

      case 'list_researcher':
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $researcher = get_researcher_row($userID);
            include('researcher_details.php');
            exit;
        } else {
            // User is not logged in
            $error = "Please log in to see user details.";
            include('../errors/error.php');
            exit;
        }
        break;

    case 'add_researcher':
        // Capture inputs
        $user_name = filter_input(INPUT_POST, 'user_name');
        $res_title = filter_input(INPUT_POST, 'res_title');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $password_confirm = filter_input(INPUT_POST, 'password_confirm');
        $organisation = filter_input(INPUT_POST, 'organisation');
        $profile = filter_input(INPUT_POST, 'profile');

        // Validate inputs
        if (empty($first_name)) {
            $errors[] = "First Name is required.";
        }
        if (empty($last_name)) {
            $errors[] = "Last Name is required.";
        }
        if ($email === FALSE) {
            $errors[] = "Email address is not valid.";
        }
        if (empty($password)) {
            $errors[] = "Password is required.";
        }
        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match.";
        }
        if (empty($organisation)) {
            $errors[] = "Organisation is required.";
        }
        if (empty($profile)) {
            $errors[] = "Please leave a profile description.";
        }
        if (validatePWComplex($password) == false) {
            $errors[] = "Password does not meet complexity requirements (Min 15 characters including Upper, Lower, Digit and Special).";
        }

        if (empty($errors)) {
            // Generate PW hash
            $password = hash('sha256', $password);
            try {


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
            $mail->Subject = 'A new user Registration';
	  
            // Enable HTML if needed
            $mail->isHTML(true);
		 
            //Email body
            $bodyParagraphs = [
                    "<html><body>",
    "<h2>User Profile Information</h2>",
   "<strong>User Name:</strong> {$user_name}",
    "<strong>Title:</strong> {$res_title}",
    "<strong>First Name:</strong> {$first_name}",
    "<strong>Last Name:</strong> {$last_name}",
    "<strong>E-Mail:</strong> {$email}",
    "<strong>Organization:</strong> {$organisation}",
    "<strong>Profile:</strong> {$profile}",
    "</body></html>"
	

            ];

            //Join paragraphs with HTML line breaks
            $body = join('<br />', $bodyParagraphs);

            //Assigning constructed HTML body to email
            $mail->Body = $body;
	    
            if($mail->send()){
              
                add_researcher($user_name, $res_title, $first_name, $last_name, $email, $password, $organisation, $profile);
                $confirmation = "Congratulations, you have registered an account.";
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





            





            } catch (PDOException $e) {
                error_log("PDOException: " . $e->getMessage() . PHP_EOL, 3, $resLogFile);
                $errors[] = "An error occurred while registering: " . $e->getMessage();
            }
        }

        // Display errors or confirmation
        if (!empty($errors)) {
            include('../errors/error.php');
        }
        break;

     case 'publication_upload':
        // Check if user is logged in
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
    
            // Get researcher data including userRole
            $researcher = get_researcher($userID);
    
            // Check if researcher data was retrieved and contains userRole
            if ($researcher && isset($researcher['userRole'])) {
                if ($researcher['userRole'] == 2) {
                    // Proceed with publication upload
                    $pub_title = filter_input(INPUT_POST, 'pub_title');
                    $pub_descr = filter_input(INPUT_POST, 'pub_description');
			$pubDate = filter_input(INPUT_POST, 'pubDate');
                    $eegID = filter_input(INPUT_POST, 'eegID');
    		    $eegPath = getEegLink($eegID);
	 $research = getusername($userID);
	if ($research) {
    // Access researcher data safely
    $research = $research['username'];
    $Token_ID = bin2hex(random_bytes(4));

}

                    $target_dir = "..\\uploads\\pub_uploads\\";
                    $target_file = $target_dir . basename($_FILES["pubToUpload"]["name"]);
                    $uploadOk = 1;
      			

	 

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $errors[] =  "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
      
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $errors[] = "Sorry, your file was not uploaded.";
                    } else {
                        // Attempt to move the uploaded file
                        if (move_uploaded_file($_FILES["pubToUpload"]["tmp_name"], $target_file)) {
                            // File moved successfully

           
		
                            $pubID = upload_publication($pubDate,$userID, $pub_title, $pub_descr, $target_file, $eegID,$Token_ID);

                            if ($pubID !== false) {
                                // Successfully uploaded publication and got pubID
                                link_pub_to_eeg($eegID, $pubID); // Assuming this function exists to link pubID to eegID
                               
                            } else {
                                // Failed to upload publication
                                $errors[] = "Failed to upload publication.";
                            }
                        } else {
                            // Error moving file
                            $errors[] =  "Sorry, there was an error uploading your file.";
                        }
                    }
                } else {
                    // User does not have the required role
                    $errors[] = "You do not have permission to upload publications.";
                }
            } else {
                // Researcher data or userRole not found
                $errors[] = "You do not have permission to upload publications.";
            }
        } else {
            // User is not logged in
            $errors[] = "Please log in to upload publications.";
        }
    
        // Display errors or confirmation
        if (!empty($errors)) {
            include('../errors/error.php');
        } else {


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
            $mail->Subject = 'A new user would like to upload publication data';
	   $mail->addAttachment ($target_file);
            // Enable HTML if needed
            $mail->isHTML(true);
		 
            //Email body
            $bodyParagraphs = [
                    "User_Name: {$research}",
                    "Publication_Title: {$pub_title}", 
                    "Publication_Description: {$pub_descr}", 
                    "Token_ID:{$Token_ID}",
                    "EEG_ID: {$eegPath}",
		    " Path:{$target_file}",
                    "<a href='http://localhost/approved.php?Token_ID=$Token_ID' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007bff; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Accept Publication</a>",

"<a href='http://localhost/delete.php?Token_ID=$Token_ID & target_file= $target_file' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: red; text-decoration: none; border-radius: 5px;'>Delete Publication</a>"

	
            ];

            //Join paragraphs with HTML line breaks
            $body = join('<br />', $bodyParagraphs);

            //Assigning constructed HTML body to email
            $mail->Body = $body;
	    
            if($mail->send()){
              
                include("../confirmations/pub_upload_confirmed.php");
		
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
        $backTo = 'researcher_menu.php';  
        break;
        

    case 'eeg_upload':
        // Check if user is logged in
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];

            // Get researcher data including userRole
            $researcher = get_researcher($userID);

            // Check if researcher data was retrieved and contains userRole
            if ($researcher && isset($researcher['userRole'])) {
                if ($researcher['userRole'] == 2) {
                    // Proceed with EEG upload
                    $eeg_title = filter_input(INPUT_POST, 'eeg_title');
                    $eeg_descr = filter_input(INPUT_POST, 'eeg_description');
		    $eegDate = filter_input(INPUT_POST, 'eegDate');
                    $pubID = filter_input(INPUT_POST, 'pubID');
	   	    $Token_Eeg_ID = bin2hex(random_bytes(4));

 $research = getusername($userID);
	if ($research) {
    // Access researcher data safely
    $research = $research['username'];
}

                    $target_dir = "..\\uploads\\eeg_uploads\\";
                    $target_file = $target_dir . basename($_FILES["eegToUpload"]["name"]);
                    $uploadOk = 1;

                    

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $errors[] = "Sorry, file already exists.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $errors[] = "Sorry, your file was not uploaded.";
                    } else {
                        // Attempt to move the uploaded file
                        if (move_uploaded_file($_FILES["eegToUpload"]["tmp_name"], $target_file)) {
                            // File moved successfully
                            $eegID = upload_eeg($eegDate,$userID, $eeg_title, $eeg_descr, $target_file, $pubID,$Token_Eeg_ID);
                        
                            if($eegID !== false){
                                //Successfully uploaded eeg data and got eegID
                                link_eeg_to_pub($pubID, $eegID);
                                $confirmation = "The file " . htmlspecialchars(basename($_FILES["eegToUpload"]["name"])) . " has been uploaded.";
                            } else {
                                //Failed to upload eeg data
                                $errors[] = "Failed to upload EEG.";
                            }                            
                        } else {
                            // Error moving file
                            $errors[] = "Sorry, there was an error uploading your file.";
                        }
                    }
                } else {
                    // User does not have the required role
                    $errors[] = "You do not have permission to upload EEG data.";
                }
            } else {
                // Researcher data or userRole not found
                $errors[] = "You do not have permission to upload EEG data.";
            }
        } else {
            // User is not logged in
            $errors[] = "Please log in to upload EEG data.";
        }

        // Display errors or confirmation
        if (!empty($errors)) {
            include('../errors/error.php');
        } else {
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
            $mail->Subject = 'A new user would like to upload EEG data';
	   $mail->addAttachment ($target_file);
            // Enable HTML if needed
            $mail->isHTML(true);
		 
            //Email body
            $bodyParagraphs = [
                    "User_Name: {$research}",
                    "Publication_Title: {$eeg_title}", 
                    "Publication_Description: {$eeg_descr}", 
                    "Token_ID:{$Token_Eeg_ID}",
                    " Path:{$target_file}",
                    "<a href='http://localhost/approve_eeg.php?Token_Eeg_ID=$Token_Eeg_ID' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007bff; text-decoration: none; border-radius: 5px; margin-right: 10px';>Accept EEG Data</a>",

"<a href='http://localhost/delete_EEG.php?Token_Eeg_ID=$Token_Eeg_ID & target_file=$target_file' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: red; text-decoration: none; border-radius: 5px;'>Delete EEG Data</a>"

	
            ];

            //Join paragraphs with HTML line breaks
            $body = join('<br />', $bodyParagraphs);

            //Assigning constructed HTML body to email
            $mail->Body = $body;
	    
            if($mail->send()){
              
                include("../confirmations/eeg_upload_confirmed.php");
		
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

              
        
        break;

    case 'update_user':
        if (isset($_SESSION['userID'])) {
            $_SESSION['backTo'] = 'researcher_portal.php';
            $userID = $_SESSION['userID'];   
            $researcher = get_researcher_row($userID);
            $userRole = $researcher['userRole'];
            
            $user_name = filter_input(INPUT_POST, 'user_name');
            $res_title = filter_input(INPUT_POST, 'res_title');
            $first_name = filter_input(INPUT_POST, 'first_name');
            $last_name = filter_input(INPUT_POST, 'last_name');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); 
            $organisation = filter_input(INPUT_POST, 'organisation');
            $profile = filter_input(INPUT_POST, 'profile');


            // Validate the inputs
            if ($user_name === ''){
                $errors[] = "Username is required";
            }else if ($res_title === ''){
                $errors[] = 'A title is required;';
            } else if ($first_name === '') {
                $errors[] = "First Name is required.";
            } else if ($last_name === '') {
                $errors[] = "Last Name is required.";
            } else if ($email === FALSE) {
                $errors[] = "Email address is not valid.";
            }else if ($organisation === null || $organisation === '') {
                $errors[] = "Organisation is required";
            } else if ($profile === null || $profile === '') {
                $errors[] = "Please leave a profile description";
            } else {
                
                try{
                    update_researcher($userID, $user_name, $res_title, $first_name, $last_name,
                                        $email, $organisation, $profile);
                    $confirmation = "User details have been updated.";
                } catch (PDOException $error) {
                    $errorMessage = $e->getMessage();
                    error_log("PDOException: " . $errorMessage . PHP_EOL, 3, $resLogFile); // Log the error message
                    
                    $errors[] = "An error occurred while registering: ";
                    
                    // Array of error types to check
                    $errorTypes = ['username', 'email'];
                
                    // Check if the error code indicates a duplicate entry error (MySQL error code 1062)
                    if ($e->errorInfo[1] == 1062) {
                        // Check if the error message contains specific information about the duplicate key
                        if (strpos($errorMessage, 'username') !== false) {
                            $errors[] = "Duplicate Entry: Username '{$user_name}' already exists.";
                        }

                        if (strpos($errorMessage, 'email') !== false) {
                            $errors[] = "Duplicate Entry: Email address '{$email}' already exists.";
                        }
                    } else {
                        // Handle other PDO exceptions or unknown errors
                        $errors[] = "An error occurred: " . $e->getMessage();
                    }
                }
            }
        } else {
            $errors[] = "You are not authorised to access this area.";
        }

        // Display errors or confirmation
        if (!empty($errors)) {
            include('../errors/error.php');
        } else {
            include("../confirmations/confirmed.php");
        }

        break;



    case 'list_publications':
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $publications = get_approved_publications();
            include('researcher_publications_list.php');
        } else {
            // User is not logged in
            $error = "Please log in to view publications.";
            include('../errors/error.php');
        }
        break;


    case 'list_eeg':
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];  
            $eeg_datas = get_approved_eegs();
            include('researcher_eeg_list.php');
        } else {
            // User is not logged in
            $error = "Please log in to view eeg data.";
            require('../errors/error.php');
        }

        break;
    
    case 'DLpub':
        $pubID = filter_input(INPUT_POST, 'pubToDL');
        $researcher = filter_input(INPUT_POST, 'researcher');
        $title = filter_input(INPUT_POST, 'title');       
        $pubLink = getPubLink($pubID);
        $_SESSION['pubLink'] = $pubLink;
        include('../confirmations/downloadPub.php');
    break;

    case 'DLLinkedpub':
        $researcher = filter_input(INPUT_POST, 'researcher');
        $pubID = filter_input(INPUT_POST, 'pubToDL');
        $title = getPubTitle($pubID);
        $pubLink = getPubLink($pubID);        
        $_SESSION['pubLink'] = $pubLink;
        include('../confirmations/downloadPub.php');
        break;

    case 'DLeeg':
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
    break;
    
    case 'DLLinkedEeg':
        $researcher = filter_input(INPUT_POST, 'researcher');
        $eegID = filter_input(INPUT_POST, 'eegToDL');
        $title = get_eeg_title($eegID);
        $eegLink =  getEegLink($eegID);
        $_SESSION['eegLink'] = $eegLink;
        include('../confirmations/downloadEeg.php');
        break;


    case 'back_to_researcher_menu':
        include('researcher_portal.php');
        break;

    default:
        // Handle cases where $action does not match any expected value
        $error = "Invalid action.";
        include('../errors/error.php');
        break;
}






?>
