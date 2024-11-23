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
$Token_ID = isset($_GET['Token_ID']) ? $_GET['Token_ID'] : null;

  if ($Token_ID) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get user information based on token
    $sql = "UPDATE publication SET approved = 1 WHERE Token_ID =?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $Token_ID);  // Bind the token as a string
        $stmt->execute();
        $result = $stmt->get_result();

    
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