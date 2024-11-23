<?php
    $dsn = 'mysql:host=localhost;dbname=htdocs3';  
    $username = 'eeg_publications_user';
    $password = 'pa55word';  #to be updated

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
?>
