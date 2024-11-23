<?php

require('../model/database.php');
require('../model/publications_db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'list_publications';
    }
}

if ($action === 'list_publications') {
    $publications = get_approved_publications();
    include('publications_list.php');
}

if ($action == 'downloadPublication') {
    $pubID = filter_input(INPUT_POST, 'publicationToDL', FILTER_VALIDATE_INT);
    $researcher = filter_input(INPUT_POST, 'researcher', FILTER_SANITIZE_STRING);
    
    // Fetch the publication details from the database using pubID
    $publication = get_publication_by_id($pubID);
    
    if ($publication) {
        $title = $publication['pubTitle'];
        $pubDesc = $publication['pubDesc'];
        $pubDate = $publication['pubDate'];
        $pubLink = $publication['pubPath'];

        // Store necessary information in the session for downloadPub.php
        $_SESSION['pubTitle'] = $title;
        $_SESSION['pubDesc'] = $pubDesc;
        $_SESSION['pubDate'] = $pubDate;
        $_SESSION['pubLink'] = $pubLink;
        $_SESSION['researcher'] = $researcher;
        $_SESSION['backTo'] = './index.php';

        // Redirect to downloadPub.php
        include('../confirmations/downloadPub.php');
    } else {
        // Handle the case where the publication is not found
        $error = 'Publication not found.';
        include('../errors/error.php');
    }
}
