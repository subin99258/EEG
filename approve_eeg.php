<?php

// Include PHPMailer classes
require_once './PHPMailer-master/src/PHPMailer.php';
require_once './PHPMailer-master/src/SMTP.php';
require_once './PHPMailer-master/src/Exception.php';

// Create a new PHPMailer instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Database connection settings
$servername = "localhost";
$username = "eeg_publications_user";
$password = "pa55word";
$dbname = "htdocs3";

// Check if token is provided
$Token_Eeg_ID = isset($_GET['Token_Eeg_ID']) ? $_GET['Token_Eeg_ID'] : null;
$Token_Eeg_ID = str_replace(' ', '', $Token_Eeg_ID);
  if ($Token_Eeg_ID) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get user information based on token
    $sql = "UPDATE eeg SET approved = 1 WHERE Token_Eeg_ID ='$Token_Eeg_ID'";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
      //  $stmt->bind_param("s", $Token_Eeg_ID);  // Bind the token as a string
        $stmt->execute();
        $result = $stmt->get_result();
echo $sql;
    
if ($result === false) {
   
    echo "
                <script type='text/javascript'>
                    setTimeout(function() {
                        window.close();
                    }, 50);
                </script>
            ";


} else {
       echo "
                <script type='text/javascript'>
                    setTimeout(function() {
                        window.close();
                    }, 50);
                </script>
            ";


}
}
}
?>