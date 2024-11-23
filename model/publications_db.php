<?php
function getPublications() {
    global $db;
    $query = 'SELECT * FROM publication';
    $statement = $db->prepare($query);
    $statement->execute();
    $publications = $statement->fetchAll();
    $statement->closeCursor();
    return $publications;
}

function get_approved_publications() {
    global $db;
    $query = 'SELECT * FROM publication WHERE approved = 1';
    $statement = $db->prepare($query);
    $statement->execute();
    $publications = $statement->fetchAll();
    $statement->closeCursor();
    return $publications;
}

function approve_publication($pubID) {
    global $db; 
    $query = 'UPDATE publication SET approved = 1 WHERE pubID = :pubID';
    $statement = $db->prepare($query);
    $statement->bindValue(':pubID', $pubID, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
}

function getPubLink($pubID) {
    global $db;
    $query = 'SELECT pubPath FROM publication WHERE pubID = :pubID';
    $statement = $db->prepare($query);
    $statement->bindValue(':pubID', $pubID);
    $statement->execute();
    $pubLink = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $pubLink['pubPath'];
}

function getPubTitle($pubID){
    global $db;
    $query = 'SELECT pubTitle FROM publication WHERE pubID = :pubID';
    $statement = $db->prepare($query);
    $statement->bindValue(':pubID', $pubID);
    $statement->execute();
    $pubTitle = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $pubTitle['pubTitle'];
}

function upload_publication($pubDate,$user_ID, $pub_title, $pub_descr, $target_file, $eegID, $Token_ID) {
    global $db; 
    $query = 'INSERT INTO publication
                  (pubDate,userID, pubTitle, pubDesc, pubPath, eegID, Token_ID)
              VALUES
                  (:pubDate,:user_ID, :pub_title, :pub_descr, :pub_path, :eegID, :Token_ID)';
    
    // Prepare and execute the statement
    $statement = $db->prepare($query);
    $statement->bindValue(':pubDate', $pubDate);
    $statement->bindValue(':user_ID', $user_ID);
    $statement->bindValue(':pub_title', $pub_title);
    $statement->bindValue(':pub_descr', $pub_descr);
    $statement->bindValue(':pub_path', $target_file);
    
    // Bind eegID with special handling for null
    if ($eegID == "0") {
        $statement->bindValue(':eegID', null, PDO::PARAM_NULL);
    } else {
        $statement->bindValue(':eegID', $eegID);
    }
    $statement->bindValue(':Token_ID', $Token_ID);
    // Execute the statement
    $success = $statement->execute();
    
    if ($success) {
        // Retrieve the auto-generated pubID
        $pubID = $db->lastInsertId();
        // Close the cursor
        $statement->closeCursor();
        return $pubID;
    } else {
        // Handle database insertion failure
        // Example: Log error or return false
        $errors[] = ("Failed to insert publication into database.");
        include('../errors/error.php');
        return false;
    }
}

function link_eeg_to_pub($pubID, $eegID) {
    global $db; 
    $query = "UPDATE publication SET eegID = :eegID WHERE pubID = :pubID";
    $statement = $db->prepare($query);
    $statement->bindValue(':eegID', $eegID);
    $statement->bindValue(':pubID', $pubID);
    $result = $statement->execute();
    $statement->closeCursor();

    return $result;
}

function get_publication_by_id($pubID) {
    global $db;
    $query = 'SELECT pubTitle, pubDesc, pubPath, pubDate FROM publication WHERE pubID = :pubID';
    $statement = $db->prepare($query);
    $statement->bindValue(':pubID', $pubID);
    $statement->execute();
    $publication = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $publication;
}



function getResearcherName($userID) {
    global $db;
    $query = 'SELECT resTitle, firstName, lastName FROM researcher WHERE userID = :userID';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $researcherName = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    $researcher = $researcherName['resTitle']." ".$researcherName['firstName']." ".$researcherName['lastName'];

    return $researcher;
}

function delete_publication($pubID) {
    global $db;

    try{
        $query = 'DELETE FROM publication WHERE pubID = :pubID';
        $statement = $db->prepare($query);
        $statement->bindValue(':pubID', $pubID, PDO::PARAM_INT);
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