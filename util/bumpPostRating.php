<?php
include('db.php');
session_start();

if($_SERVER['REQUEST_METHOD'] != "GET") { // Prevent users from loading this page directly from URL
    header("HTTP/1.0 403 Forbidden");
    exit;
}

// Check that server received all needed data
if(!isset($_GET['postID']) || empty($_GET['postID'])) { // Exit if server didn't receive the postID in the POST
//     print 'no postID';
    header("Location: " . $_SERVER["HTTP_REFERER"]); // Send user back
    exit;
}
if(!isset($_GET['direction']) || empty($_GET['direction'])) {
//     print 'no direction';
    header("Location: " . $_SERVER["HTTP_REFERER"]); // Send user back
    exit;
}

// Make sure the user is logged in and hasn't rated this post yet
if(!$_SESSION['loggedIn']) {
//     print 'not logged in';
    header("Location: " . $_SERVER["HTTP_REFERER"]); // Send user back
    exit;
}
if(in_array($_GET['postID'], $_SESSION['postsRated'])) {
//     print 'you already rated this';
    header("Location: " . $_SERVER["HTTP_REFERER"]); // Send user back
    exit;
}

// If user wants to rate a post down, subtract the rating by adding -1 to it
$modifier = ($_GET['direction'] === "down" ? "-1" : "1");

$sql="UPDATE posts SET rating = rating+(".$modifier.") WHERE postID = ".$_GET['postID'].";";
if(mysqli_query($db, $sql)) { // If successful, mark this postID as having been rated already
    array_push($_SESSION['postsRated'], $_GET['postID']);
}

header("Location: " . $_SERVER["HTTP_REFERER"]); // Send user back
?>
