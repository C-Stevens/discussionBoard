<?php
include("db.php");
/*
    Return Codes
        * 0: Successful login verification. _SESSION variables have been set.
        * 1: Invalid email or invalid password.
        * 2: Server did not receive all _POST data required for verification.
*/

// Check if we have the right POST data
if(isset($_POST["submit"])) {
	if(empty($_POST["email"]) || empty($_POST["password"])) {
		echo 2;
		exit;
	}
}

// Retrieve items from POST data
$email=$_POST["email"];
$password=$_POST["password"];

// MySQL injection prevention
$email = stripslashes($email);
$password = stripslashes($password);
$email = mysqli_real_escape_string($db, $email);
$password = mysqli_real_escape_string($db, $password);

// Retrieve result rows
$sql="SELECT password FROM users WHERE email='$email';";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
$count=mysqli_num_rows($result);

if($count==1) { // Matching row, means valid user credentials
	$serverPass = $row['password'];
	if(password_verify($password, $serverPass)) { // Verify if the password is correct
		// The password is correct, now fetch the entire row from the DB
		$rowSql="SELECT * FROM users WHERE email='$email';";
		$result=mysqli_query($db, $rowSql);
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

		session_start();
		// Set session details
		$_SESSION['loggedIn'] = true;
		$_SESSION['userID'] = $row['userID'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['displayName'] = $row['displayName'];
		$_SESSION['isAdmin'] = $row['isAdmin'];
		$_SESSION['postsRated'] = array();

		echo 0; // Return a 0 for success
		exit;
	} else {
//    We can prevent users from trying to discover valid usernames by returning the same value (1) for both bad username and password.
//    This way, the user can't be sure if they tried a valid username, or if just the password is wrong.
        echo 1; 
        exit;
	}
} else {
            echo 1;
            exit;
}
