<?php

// Include PHPMailer classes
require_once './PHPMailer-master/src/PHPMailer.php';
require_once './PHPMailer-master/src/SMTP.php';
require_once './PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Database connection settings
$servername = "localhost";
$username = "eeg_publications_user";
$password = "pa55word";
$dbname = "eeg_data_and_publication_platform";

// Check if token is provided
$Token_Eeg_ID = isset($_GET['Token_Eeg_ID']) ? $_GET['Token_Eeg_ID'] : null;
$target_file = isset($_GET['target_file']) ? $_GET['target_file'] : null;
$Token_Eeg_ID = str_replace(' ', '', $Token_Eeg_ID);
if ($Token_Eeg_ID) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to delete publication based on token
    $sql = "DELETE FROM eeg WHERE Token_Eeg_ID='$Token_Eeg_ID'";
       echo $sql;
    $stmt = $conn->prepare($sql);
     if ($stmt) {
       // $stmt->bind_param("s", $Token_Eeg_ID);  // Bind the token as a string
        $stmt->execute();



$updatedPath = str_replace("..","C:\\xampp\\htdocs", $target_file);
$path=$updatedPath ;

unlink($path);
 
 $stmt->close();

 echo "
                <script type='text/javascript'>
                    setTimeout(function() {
                        window.close();
                    }, 50);
                </script>
            ";


}

}
?>
