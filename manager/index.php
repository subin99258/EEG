<?php
// Check if user is logged in and has the appropriate role
if (isset($_SESSION['userRole'])) {
    if ($_SESSION['userRole'] == 0) {
        include('../view/header.php');
    } 
}



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../model/database.php');
require('../model/manager_db.php');
require('../model/publications_db.php');
require('../model/eeg_db.php');
require('../model/public_user_db.php');

//Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);     // Enable logging errors to file

$resLogDir = __DIR__ . '/../errors/logs/';
$resLogFile = $resLogDir . 'mgr_error.log';
ini_set('error_log', $resLogFile);

$errors = [];

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'login_manager';
    }
}

switch ($action) {
    case 'login_manager':
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == '0') {
            echo $_SESSION['userRole'];
            header('Location: management_menu.php');
            exit;
        } else {
            include('manager_login.php');
        }
        break;    
    
    case 'manager_login':
        // Validate and sanitize inputs
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
    
        // Validate email and password presence
        if (empty($email) || empty($password)) {
            $errors[] = 'Email and password are required fields.';
            $_SESSION['backTo'] = 'manager_login.php'; 
            include('../errors/error.php');
            break;
        }
    
        // Hash the password securely
        $hashed_password = hash('sha256', $password);
    
        // Validate login credentials
        $userRole = is_valid_manager_login($email, $hashed_password);
    
        if ($userRole !== false) {
            // Authentication successful
            $_SESSION['email'] = $email;
            $_SESSION['userRole'] = $userRole;
    
            // Fetch and store username
            $username = get_mgr_uname_by_email($email);
            $_SESSION['username'] = $username;
            $_SESSION['backTo'] = 'management_menu.php'; // for navigation purposes
    
            // Generate and set a secure session token cookie
            $session_token = bin2hex(random_bytes(32));
            $cookie_expiry = time() + (84600 * 14); // expires in 14 days
            setcookie('session_token', $session_token, $cookie_expiry, '/', '', true, true); // secure and httponly flags
    
            // Proceed based on userRole
            if ($userRole == 0) {
                header('Location: management_menu.php'); // Redirect to management menu
                exit;
            } else {
                $errors[] = 'You are not authorised to access this area.';
                $_SESSION['backTo'] = '../index.php'; 
                include('../errors/error.php');
            }
        } else {
            // Incorrect email or password
            $errors[] = 'Incorrect email or password.';
            $_SESSION['backTo'] = 'manager_login.php'; 
            include('../errors/error.php');
        }

        break;
        
    case 'list_publications':
        // Check if userRole is set in session
        if (!isset($_SESSION['userRole'])) {
            header('Location: manager_login.php');
            exit;
        }
    
        $userRole = $_SESSION['userRole'];
    
        // Proceed based on userRole
        if ($userRole == 0) {
            $publications = getPublications(); // Fetch publications data
            include('mgr_publications_list.php'); // Display publications list
        } else {
            $errors[] = "You are not authorised to access this area.";
            require('../errors/error.php');
        }
        break;

    case 'approve_publication':    
       // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $userRole = $_SESSION['userRole'];
        

        // Proceed based on userRole
        if ($userRole == 0) {
            $publicationID = filter_input(INPUT_POST, 'publicationID', FILTER_SANITIZE_NUMBER_INT);
            approve_publication($publicationID);
            $publications = getPublications(); 

            // Set the default back URL to the management menu
            $_SESSION['backTo'] = 'management_menu.php';

            include('mgr_publications_list.php'); // Display publications list
        } else {
            $errors[] = "You are not authorised to access this area.";
            require('../errors/error.php');
        }
        break;

    case 'delete_publication':
        // Check if userRole is set in session
        if (!isset($_SESSION['userRole'])) {
            header('Location: manager_login.php');
            exit;
        }
        
        $userRole = $_SESSION['userRole'];
    
        if ($userRole == 0) {
            $publicationID = filter_input(INPUT_POST, 'publicationID', FILTER_SANITIZE_NUMBER_INT);

	$pubLink= getPubLink($publicationID);
	$updatedpubpath = str_replace(" ..", "C:\\xampp\\htdocs\\", $pubLink);
   	
            
            try {
                $success = delete_publication($publicationID);
                


                if ($success) {
			unlink ($updatedpubpath);
                    $confirmation = "Publication with ID $publicationID deleted successfully.";
			
                    include("../confirmations/confirmed.php");
                } else {
                    // Handle specific error message if deletion fails
                    $errors[] = "The publication record with ID $publicationID cannot be deleted because it is linked to one or more EEG data.";
                }
                
            } catch (PDOException $e) {
                // Log the exception
                error_log("PDOException while deleting publication with ID $publicationID: " . $e->getMessage());
                $errors[] = "A database error occurred while deleting publication with ID $publicationID.";
                
            } catch (Exception $e) {
                // Log the exception
                error_log("Exception while deleting publication with ID $publicationID: " . $e->getMessage());
                $errors[] = "An unexpected error occurred: " . $e->getMessage();
            }
        } else {
            $errors[] = "You are not authorized to access this area.";
        }
    
        // Display errors if any
        if (!empty($errors)) {
            include('../errors/error.php');
        }

        $backTo = 'management_menu.php';  
        break;

    
 case 'publication_upload':
    // Check if user is logged in
    if (isset($_SESSION['userRole'])) {
        $userRole = $_SESSION['userRole'];

        // Get researcher data including userRole
        $userID = get_manager_ID($userRole);

        // Check if userRole is valid 0 = manager
        if ($userRole == 0) {
            // Proceed with publication upload
            $pub_title = filter_input(INPUT_POST, 'pub_title');
            $pub_descr = filter_input(INPUT_POST, 'pub_description');
            $eegID = filter_input(INPUT_POST, 'eegID');
	    $pubDate = filter_input(INPUT_POST, 'date');
	    $eegPath = getEegLink($eegID);

	 $research = getusername($userID);
	if ($research) {
    // Access researcher data safely
    $research = $research['username'];
    $Token_ID = bin2hex(random_bytes(4));

    }        // Ensure the required fields are not empty
            if (!empty($pub_title) || !empty($pub_descr)) {

                // Initialize errors array
                $errors = [];

                // File upload handling
                if (isset($_FILES["pubToUpload"])) {
                    $target_dir = "../uploads/pub_uploads/";
                    $target_file = $target_dir . basename($_FILES["pubToUpload"]["name"]);
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
                        if (move_uploaded_file($_FILES["pubToUpload"]["tmp_name"], $target_file)) {
                            // File moved successfully
                            $pubID = upload_publication($pubDate,$userID, $pub_title, $pub_descr, $target_file, $eegID,$Token_ID);

                            if ($pubID !== false) {
                                // Successfully uploaded publication and got pubID
                                link_pub_to_eeg($eegID, $pubID); // Assuming this function exists to link pubID to eegID
                                $confirmation = "The file " . htmlspecialchars(basename($_FILES["pubToUpload"]["name"])) . " has been uploaded.";
                            } else {
                                // Failed to upload publication
                                $errors[] = "Failed to upload publication.";
                            }
                        } else {
                            // Error moving file
                            $errors[] = "Sorry, there was an error uploading your file.";
                        }
                    }
                } else {
                    $errors[] = "No file uploaded.";
                }
            } else {
                $errors[] = "Publication title or description cannot be empty.";
            }
        } else {
            // User does not have the required role
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
        include("../confirmations/confirmed.php");
    }

    break;


    case 'approve_eeg':
        // Check if userRole is set in session
        if (!isset($_SESSION['userRole'])) {
            header('Location: manager_login.php');
            exit;
        }
        
        $userRole = $_SESSION['userRole'];
    
        if ($userRole == 0) {
            $eegID = filter_input(INPUT_POST, 'eegID', FILTER_SANITIZE_NUMBER_INT);
            approve_eeg($eegID);
            $eegs = get_eeg(); 
            
            // Set the default back URL to management menu
            $_SESSION['backTo'] = 'management_menu.php';
            
            // Include the EEG list page content
            include('mgr_eeg_list.php');
            
            exit; // Make sure to exit after a header redirect
        } else {
            $error = "You are not authorised to access this area.";
            require('../errors/error.php');
        }

        break;

    case 'delete_eeg':
        // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $_SESSION['backTo'] = 'management_menu.php';
        $userRole = $_SESSION['userRole'];

        if ($userRole == 0) {
            try {
                $eegID = filter_input(INPUT_POST, 'eegID');
                $eegLink= getEegLink($eegID);
	$updatedpubpath = str_replace(" ..", "C:\\xampp\\htdocs\\", $eegLink);
   	

                // Attempt to delete EEG record
                $success = delete_eeg($eegID);
        
                if ($success) {

		unlink ($updatedpubpath);
                    $confirmation = "EEG record with ID $eegID deleted successfully.";
                    include("../confirmations/confirmed.php");
                } else {
                    $errors[] =  "The EEG record with ID $eegID cannot be deleted because it is linked to one or more publications.";
                }

            } catch (PDOException $e) {
                //log to mgr_error.log
                error_log("PDOException while deleting EEG record with ID $eegID: " . $e->getMessage());
                $errors[] =  "A database error occurred while deleting publication with ID $eegID";
                
            } catch (Exception $e){
                //log to mgr_error.log
                error_log("PDOException while deleting EEG record with ID $eegID: " . $e->getMessage());
                $errors[] =  "An unexpected error occurred: " . $e->getMessage();

            }
        } else {
            $errors[] = "You are not authorised to access this area.";
            require('../errors/error.php');
        }

         // Display errors or confirmation
        if (!empty($errors)) {
            include('../errors/error.php');
        }
          
        break;

    case 'list_eeg':
        // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $userRole = $_SESSION['userRole'];

        if ($userRole == 0) {
            $eegs = get_eeg(); 
            include('mgr_eeg_list.php');
        } else {
            $error = "You are not authorised to access this area.";
            require('../errors/error.php');
        }

        break;



    case 'eeg_upload':
        // Check if user is logged in
        if (isset($_SESSION['userRole'])) {            
            $userRole = $_SESSION['userRole'];

            // Get researcher data including userRole
            $userID = get_manager_ID($userRole);

            // Check if researcher data was retrieved and contains userRole
            if ($userRole == 0) {
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
	 if (!empty($eeg_title) || !empty($eeg_descr)) {
		
                $target_dir = "../uploads/eeg_uploads/";
                $target_file = $target_dir . basename($_FILES["eegToUpload"]["name"]);
                $uploadOk = 1;

                // allow all file type

              if (!empty($_FILES["eegToUpload"]["type"])) {
    $fileType = $_FILES["eegToUpload"]["type"];
    
    // Optional: Log or display file type for information
    // echo "Uploaded file type: " . $fileType;

    $uploadOk = 1;  // Proceed with upload
} else {
    $errors[] = "File type could not be determined.";
    $uploadOk = 0;
}

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
                        $eegID = upload_eeg($eegDate,$userID, $eeg_title, $eeg_descr, $target_file, $pubID,$Token_Eeg_ID );
                    
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
		 $errors[] = "Publication title or description cannot be empty.";
		}
            } else {
                // User does not have the required role
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
            include("../confirmations/confirmed.php");
        }

        break;
    
    case 'public_user_downloads':
        $publicUsers = get_dl_row();
        include('mgr_public_user_dl.php');
        break;


    case 'list_users':
        // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $userRole = $_SESSION['userRole'];
        
        if ($userRole == 0){
            $users = get_all_researchers(); //lists all researchers except userRole = 0
            include('mgr_researchers_list.php');
        } else {
            $error = "You are not authorised to access this area.";
            require('../errors/error.php');
        }
        break;

    case 'edit_user':
        // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $userRole = $_SESSION['userRole'];
        
        if ($userRole == 0){
            $userID = filter_input(INPUT_POST, 'userID');
            $user = get_user_by_ID($userID);
            include('researcher_details.php');
        } else {
            $error = "You are not authorised to access this area.";
            require('../errors/error.php');
        }
        break;

    case 'update_user':
        // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $userRole = $_SESSION['userRole'];
        
        if ($userRole == 0){
            $user_id = filter_input(INPUT_POST, 'user_id');
            $user_name = filter_input(INPUT_POST, 'user_name');
            $res_title = filter_input(INPUT_POST, 'res_title');
            $first_name = filter_input(INPUT_POST, 'first_name');
            $last_name = filter_input(INPUT_POST, 'last_name');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); 
            $organisation = filter_input(INPUT_POST, 'organisation');
            $profile = filter_input(INPUT_POST, 'profile');
            $userRole = filter_input(INPUT_POST, 'user_role');

            // Validate the inputs

            if ($first_name === ''){
                echo "Name:";
                var_dump($first_name);
                $errors[] = "First Name is required.";
            } else if ($last_name === '' ){
                $errors[] = "Last Name is required.";
            } else if ($email === FALSE) {
                $errors[] = "Email address is not valid.";
            } else if ($organisation === null || $organisation === ''){
                $errors[] = "Organisation is required";
             } else if ($profile === null || $profile === ''){
                $errors[] = "Please leave a profile description";
            } else if ($userRole === null || $userRole === ''){
                $errors[] = "Please enter a the user privilge level";

            // Uncomment to restrict the ability to promote to Management user
            /*
            }else if ($userRole == 0){
                $errors[] = "UserRole cannot be zero. Please choose 1 or 2";
            */
            
            } else {
                
                try{
                    update_researcher($user_id, $user_name, $res_title, $first_name, $last_name,
                    $email, $organisation, $profile, $userRole);
                    $confirmation = "User details have been updated.";
                    include("../confirmations/confirmed.php");
                } catch (PDOException $error) {
                    if ($error->errorInfo[1] == 1062) {
                        // Extract the error message to determine the duplicate key
                        $errors[] = $error->getMessage();
                        // Check if the error message contains specific information about the duplicate key
                        if (strpos($error, 'username') !== false) {
                            $errors[] = "Duplicate Entry: Username '{$user_name}' already exists.";
                        } elseif (strpos($error, 'email') !== false) {
                            $errors[] = "Duplicate Entry: Email address '{$email}' already exists.";
                        } else {
                            // Fallback to a generic message if the specific key is not identified
                            $errors[] = "Duplicate Entry: This data already exists in the database.";
                        }
                    } 
                }
            }
        } else {
            $errors[] = "You are not authorised to access this area.";
        }
        // Display errors
        if (!empty($errors)) {
            include('../errors/error.php');
        } 

        break;
    case 'back_to_management_menu':
        // Check if userRole is set in session
       if (!isset($_SESSION['userRole'])) {
        header('Location: manager_login.php');
        exit;
        }
        
        $userRole = $_SESSION['userRole'];
        
        if ($userRole == 0) {
            include('management_menu.php'); // Display management menu
        } else {
            $errors[] = "You are not authorised to access this area.";
            require('../errors/error.php');
        }
        
        break;
    default:
        // Handle unknown actions or redirect to an error page
        header('HTTP/1.1 404 Not Found');
        echo 'Page not found';
        exit;
}
?>