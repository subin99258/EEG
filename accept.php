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
$token = isset($_GET['token']) ? $_GET['token'] : null;

if ($token) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get user information based on token
    $sql = "SELECT pu.Email, pu.eegID, pu.eegTitle, e.eegPath FROM public_users pu JOIN eeg e ON pu.eegTitle = e.eegTitle WHERE token = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $token);  // Bind the token as a string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Accessing the user data using the correct variable
            $email = $user['Email'];      // Ensure the case matches the database
            $eegID = $user['eegID'];      // Ensure the case matches the database
            $eegTitle = $user['eegTitle'];
	    $path= $user['eegPath'];

	  
		$variable = str_replace("..", "", $path);
		$variable = str_replace("\\", "/", $variable);
            // Generate the download link (Assuming you have a URL for the download file)
            $downloadLink = "https://e72d-149-167-144-177.ngrok-free.app{$variable}";
                     
            $mail = new PHPMailer(); // Create an instance of PHPMailer
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'subinmaharjan01@gmail.com';
            $mail->Password = 'jqan tbgo hexr lgms'; 

            // Set email recipients
            $mail->setFrom('subinmaharjan01@gmail.com', 'EEG and Publications Platform');
            $mail->addAddress($email); // Send to the user's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your EEG Download Link';
            $mail->Body = "
                <html>
                    <body>
                        <h2>Your EEG Download Link</h2>
                        <p>Thank you for reaching us. Here is your download link for {$eegTitle}:</p>
                        <a href='{$downloadLink}' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007bff; text-decoration: none; 				border-radius: 5px;'>Download EEG File</a>
                        <p>If the button doesn't work, you can also copy and paste this link into your browser:</p>
                        <p><a href='{$downloadLink}'>{$downloadLink}</a></p>
                    </body>
                </html>
            ";

            // Send the email
            if ($mail->send()) {
                echo 'An email with the download link has been sent to ' . htmlspecialchars($email);
            } else {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }

	//closing tab
	  echo "
                <script type='text/javascript'>
                    setTimeout(function() {
                        window.close();
                    }, 5000);
                </script>
            ";


        } else {
            echo "No user found with the provided token.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare the statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request. Token is missing.";
}
?>
