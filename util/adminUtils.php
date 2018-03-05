<?php
include("db.php");
session_start();

if(!$_SESSION['isAdmin']) { // If the user isn't an admin, dont allow them to access this page directly
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if(!empty($_GET)) { // Execute the appropriate function for the request
    if($_GET['request'] === "getUserList") {
        $sql = "SELECT userID,displayName,email,isAdmin FROM users;"; // Passwords are hashed so not useful, even to admins. Don't risk sending them in a GET
    } else if($_GET['request'] === "getPostList") {
        $sql = "SELECT * FROM posts;";
    } else if($_GET['request'] === "deleteUser") {
        if(!isset($_GET['userID']) || empty($_GET['userID'])) { // User didnt specify which user to delete
            exit;
        }
        
        $sql = "DELETE FROM users WHERE userID=".$_GET['userID'].";";
        mysqli_query($db, $sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else if($_GET['request'] === "makeAdmin") {
        if(!isset($_GET['userID']) || empty($_GET['userID'])) { // User didnt specify which user to delete
            exit;
        }
        $sql = "UPDATE users SET isAdmin=1 WHERE userID=".$_GET['userID'].";";
        mysqli_query($db, $sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        exit;
    }
}

$result=mysqli_query($db, $sql);
if(mysqli_num_rows($result) == 0) {
	echo "No posts yet.";
	exit;
}

$data = array();
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) { // Put each datarow into a PHP array
    $data[] = $row;
}

// JSON encode the response
print json_encode($data);
?>
