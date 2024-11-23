<?php 

function is_valid_manager_login($email, $hashed_password) {
    global $db;
    $query = 'SELECT userRole, password FROM researcher WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if ($row) {
        // Verify hashed password from database with hashed password provided
        if (hash_equals($row['password'], $hashed_password)) {
            return $row['userRole']; // Return the userRole on successful login
        } else {
            return false; // Passwords do not match
        }
    } else {
        return false; // Email not found in database
    }
}



function get_mgr_uname_by_email($email){
    global $db;
    $query = 'SELECT username FROM researcher WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email); 
    $statement->execute();
    $manager = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $manager['username'];
}



function get_manager_ID($userRole){
    global $db;
    $query = 'SELECT userID FROM researcher WHERE userRole = :user_role';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_role', $userRole); 
    $statement->execute();
    $managerID = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $managerID['userID'];
}

function get_user_by_ID($userID){
    global $db;
    $query = 'SELECT * FROM researcher WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userID); 
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $user;
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

function get_researcher_by_last_name($last_name) {
    global $db;
    $query = 'SELECT * FROM researcher
            WHERE researcher.lastName = :last_name';
   $statement = $db->prepare($query);
   $statement->bindValue(':last_name', $last_name);
   $statement->execute();
   $researcher = $statement->fetchAll();
   $statement->closeCursor();
   return $researcher;
}

function get_researcher($userID) {
    global $db;
    $query = 'SELECT * FROM researcher 
                WHERE researcher.userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userID);
    $statement->execute();
    $researcher = $statement->fetchAll();
    $statement->closeCursor();    
    return $researcher;      
}

function update_researcher($user_id, $user_name, $res_title, $first_name, $last_name,
       $email, $organisation, $profile, $user_role) {
        global $db;
        $query = 'UPDATE researcher 
                     SET username = :user_name,
                         resTitle = :res_title,
                         firstName = :first_name,
                         lastName = :last_name,
                         email = :email,
                         organisation = :organisation,
                         profile = :profile,
                         userRole = :user_role
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
        $statement->bindvalue(':user_role', $user_role);        
        $statement->execute();
        $statement->closeCursor();    
}


function approve_researcher($user_name, $res_title, $first_name, $last_name,
       $email, $password, $organisation, $profile) {
        global $db;
        $user_role = 2; // 2 = approved for uploading publications
        $query = 'UPDATE researcher 
                     SET username = :user_name,
                         resTitle = :res_title,
                         firstName = :first_name,
                         lastName = :last_name,
                         email = :email,
                         password = :password,
                         organisation = :organisation,
                         profile = :profile,
                         userRole = :user_role
              WHERE customerID = :customer_id';
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


function add_researcher($user_name, $res_title, $first_name, $last_name,
       $email, $password, $organisation, $profile) {
        global $db;
        $user_role = 1; // 1 = Cannot publish data yet
        $query = 'INSERT INTO researcher 
                      (username, resTitle, firstName, lastName, email, password,
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

function get_all_researchers() {
    global $db;
    $query = 'SELECT * FROM researcher 
              WHERE userRole <> 0';
    $statement = $db->prepare($query);
    $statement->execute();
    $researchers = $statement->fetchAll();
    $statement->closeCursor();    
    return $researchers;      
}

function validatePWComplex($password) {
    //verifies PW complexity, gives bool
    $minLength = 15;

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