<?php

function add_public_user ($eegTitle, $firstName, $lastName, $email, $eegID, $timestamp, $token) {
    global $db;
    $query = 'INSERT INTO public_users 
                            (eegTitle, firstName, lastName, email, eegID, viewed_time, token) 
                VALUES
                     (:eeg_title, :first_name, :last_name, :email, :eeg_id, :viewed_time, :token)';
    $statement = $db->prepare($query);
    $statement->bindvalue(':eeg_title', $eegTitle);
    $statement->bindValue(':first_name', $firstName);
    $statement->bindValue(':last_name', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':eeg_id', $eegID);
    $statement->bindValue(':viewed_time', $timestamp);
    $statement->bindValue(':token', $token);
    $statement->execute();
    $statement->closeCursor();  
}                

function get_dl_row(){
    global $db;
    $query = 'SELECT * FROM public_users';
    $statement = $db->prepare($query);
    $statement->execute();
    $public = $statement->fetchAll();
    $statement->closeCursor();    
    return $public;  
}


