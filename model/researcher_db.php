<?php 

function is_valid_researcher_login($email, $password) {
    global $db;
    $query = 'SELECT userID, password FROM researcher WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if ($row) {
        // Verify hashed password from database with hashed password provided
        if (hash_equals($row['password'], $password)) {
            return $row['userID']; // Return researcher ID on successful login
        } else {
            return false; // Passwords do not match
        }
    } else {
        return false; // Email not found in database
    }
}

function get_researcher($userID){
    global $db;
    $query = 'SELECT userRole FROM researcher WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userID);
    $statement->execute();
    $user_data = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    
    return $user_data; 
}

function get_researcher_row($userID){
    global $db;
    $query = 'SELECT * FROM researcher WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userID);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    
    return $row; 
}

function getusername($userID){
    global $db;
    $query = 'SELECT username FROM researcher WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userID);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    
    return $user; 
}


function update_researcher($user_id, $user_name, $res_title, $first_name, $last_name,
       $email, $organisation, $profile) {
        global $db;
        $query = 'UPDATE researcher 
                     SET username = :user_name,
                         resTitle = :res_title,
                         firstName = :first_name,
                         lastName = :last_name,
                         email = :email,
                         organisation = :organisation,
                         profile = :profile
                    WHERE userID = :user_id';
        $statement = $db->prepare($query);
        $statement->bindvalue(':user_id', $user_id);
        $statement->bindvalue(':user_name', $user_name);
        $statement->bindvalue(':res_title', $res_title);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);  
        $statement->bindvalue(':organisation', $organisation);
        $statement->bindvalue(':profile', $profile);     
        $statement->execute();
        $statement->closeCursor();    
}

function add_researcher($user_name, $res_title, $first_name, $last_name,
       $email, $password, $organisation, $profile) {
        global $db;
        $user_role = 1; // 1 = Cannot publish data yet
        $query = 'INSERT INTO researcher 
                      (userName, resTitle, firstName, lastName, email, password,
                       organisation, profile, userRole)
                  VALUES
                      (:user_name, :res_title, :first_name, :last_name, :email,
                        :password, :organisation, :profile, :user_role)'; 
        $statement = $db->prepare($query);
        $statement->bindvalue(':user_name', $user_name);
        $statement->bindvalue(':res_title', $res_title);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);    
        $statement->bindvalue(':organisation', $organisation);
        $statement->bindvalue(':profile', $profile);
        $statement->bindvalue(':user_role', $user_role);
        $statement->execute();
        $statement->closeCursor();    
}

function getEEGNames(){
    global $db;
    $query = 'SELECT eegTitle FROM eeg';
    $statement = $db->prepare($query);
    $statement->execute();
    $eegTitles = $statement->fetchAll();
    $statement->closeCursor();
    
    return $eegTitles; 
}

function validatePWComplex($password) {
    //verifies PW complexity, gives bool
    $minLength = 12;

    //length
    if (!(strlen($password) >= $minLength)) {
        return False;
    }
    //uppers
    else if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }
    //lowers
    else if (!preg_match('/[a-z]/', $password)) {
        return false;
    }
    //digits
    else if (!preg_match('/[0-9]/', $password)) {
        return false;
    }
    //specials
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        return false;
    }

    //passed all tests
    return true;
}
?>