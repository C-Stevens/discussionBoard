<?php
/*
    Allows webpages to query the server to determine if the user is logged in or not.
    Returns 1 if they are logged in, otherwise 0.
*/
    session_start();
    if($_SESSION['loggedIn']) {
        print 1;
    } else {
        print 0;
    }
    exit;
?>
