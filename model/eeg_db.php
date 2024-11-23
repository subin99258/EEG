<?php

function upload_eeg($eegDate, $user_ID, $eeg_title, $eeg_descr, $target_file, $pubID, $Token_Eeg_ID) {
    global $db;
    $query = 'INSERT INTO eeg
                    (eegDate, userID, eegTitle, eegDesc, eegPath, pubID, Token_Eeg_ID)
                VALUES
                    (:eegDate, :user_ID, :eeg_title, :eeg_descr, :eeg_path, :pubID, :Token_Eeg_ID)'; 
    $statement = $db->prepare($query);
    $statement->bindvalue(':eegDate', $eegDate);
    $statement->bindvalue(':user_ID', $user_ID);
    $statement->bindvalue(':eeg_title', $eeg_title);
    $statement->bindValue(':eeg_descr', $eeg_descr);
    $statement->bindValue(':eeg_path', $target_file);
    $statement->bindValue(':Token_Eeg_ID', $Token_Eeg_ID);

    // Bind pubID with special handling for null
    if ($pubID == "0") {
        $statement->bindValue(':pubID', null, PDO::PARAM_NULL);
    } else {
        $statement->bindValue(':pubID', $pubID);
    }
    // Execute the statement
    $success = $statement->execute();

    if ($success) {
        // Retrieve the auto-generated pubID
        $eegID = $db->lastInsertId();
        // Close the cursor
        $statement->closeCursor();
        return $eegID;
    } else {
        // Handle database insertion failure
        // Example: Log error or return false
        $errors[] = ("Failed to insert publication into database.");
        include('../errors/error.php');
        return false;
    }
}    

function get_eeg() {
    global $db;
    $query = 'SELECT * FROM eeg';
    $statement = $db->prepare($query);
    $statement->execute();
    $eeg = $statement->fetchAll();
    $statement->closeCursor();
    return $eeg;
}

function link_pub_to_eeg($eegID, $pubID) {
    global $db; 
    $query = "UPDATE eeg SET pubID = :pubID WHERE eegID = :eegID";
    $statement = $db->prepare($query);
    $statement->bindValue(':pubID', $pubID);
    $statement->bindValue(':eegID', $eegID);
    $result = $statement->execute();
    $statement->closeCursor();

    return $result;
}

function get_approved_eegs() {
    global $db;
    $query = 'SELECT * FROM eeg WHERE approved = 1';
    $statement = $db->prepare($query);
    $statement->execute();
    $eegs = $statement->fetchAll();
    $statement->closeCursor();
    return $eegs;
}

function approve_eeg($eegID) {
    global $db; 
    $query = 'UPDATE eeg SET approved = 1 WHERE eegID = :eegID';
    $statement = $db->prepare($query);
    $statement->bindValue(':eegID', $eegID, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

function getEegLink($eegID) {
    global $db;
    $query = 'SELECT eegPath FROM eeg WHERE eegID = :eegID';
    $statement = $db->prepare($query);
    $statement->bindValue(':eegID', $eegID);
    $statement->execute();
    $eegLink = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
if ($eegLink) {
    // Access the values from the row
  return $eegLink['eegPath'];
}
    
}

function get_eeg_title($eegID) {
    global $db;
    $query = 'SELECT eegTitle FROM eeg WHERE eegID = :eegID';
    $statement = $db->prepare($query);
    $statement->bindValue(':eegID', $eegID);
    $statement->execute();
    $eegTitle = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $eegTitle['eegTitle'];
}

function delete_eeg($eegID) {
    global $db;
    
    try {
        // Prepare and execute the DELETE query
        $query = 'DELETE FROM eeg WHERE eegID = :eegID';
        $statement = $db->prepare($query);
        $statement->bindValue(':eegID', $eegID, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();

        // Check if any rows were affected
        if ($statement->rowCount() > 0) {
            return true; // Return true if deletion was successful
        } else {
            return false; // Return false if no rows were affected (record not found)
        }
    } catch (PDOException $e) {
        // Log the exception (optional)
        error_log("PDOException in delete_eeg function: " . $e->getMessage());
        return false; // Return false if an exception occurred
    }
}



?>