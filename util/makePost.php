<?php
include("db.php");
session_start();
/*
    Return Codes
        * 0: Sucessful addition of post to database.
        * 1: Failure to add post to the database.
        * 2: Server did not receive all required data in _POST.
        * 3: User is not authorized (not logged in)
*/

if($_SERVER['REQUEST_METHOD'] != "POST") { // Prevent users from loading this page directly from URL
    header("HTTP/1.0 403 Forbidden");
    exit;
}

if(isset($_POST["submit"]) && !empty($_POST["submit"])) {
	// Check that everything necessary is set
	if(empty($_POST["title"]) || empty($_POST["content"] || $_POST['loggedIn'] != true)) {
        print 2;
		exit;
	}
}

if(!$_SESSION['loggedIn']) { // User is trying to post while not logged in
    print 3;
    exit;
}

$title=$_POST["title"];
$content=$_POST["content"];
$userID=$_SESSION['userID']; // Pull the UID from the session to avoid people crafting their own POSTs to post as other users

$title = stripSlashes($title);
$content = stripSlashes($content);
$title = mysqli_real_escape_string($db, $title);
$content = mysqli_real_escape_string($db, $content);

$sql="INSERT INTO posts (title, content, author) VALUES ('$title', '$content', $userID);";
if(mysqli_query($db, $sql)) {
    print 0;
    exit;
} else {
    print 1;
    exit;
}
