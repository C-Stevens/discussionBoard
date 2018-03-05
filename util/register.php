<?php
include("db.php");
/*
    Return Codes:
        * 0: Successfully registered user
        * 1: Password and password confirmation fields do not match (typo)
        * 2: Server did not receive all necessary data in POST
        * 3: Server could not insert user into database
*/

// Check if we have the right POST data
if(isset($_POST["submit"])) {
	if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["passwordConfirm"]) || empty($_POST["displayName"])) {
		print 2;
		exit;
	}
}

if($_POST["password"] != $_POST["passwordConfirm"]) { // User made a typo confirming their password
    print 1;
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];
$displayName = $_POST['displayName'];


// MySQL injection prevention
$email = stripslashes($email);
$password = stripslashes($password);
$displayName = stripslashes($displayName);
$email = mysqli_real_escape_string($db, $email);
$password = mysqli_real_escape_string($db, $password);
$displayName = mysqli_real_escape_string($db, $displayName);

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$sql="INSERT INTO users (password, displayName, email) VALUES ('$hashedPassword', '$displayName', '$email');";
if(mysqli_query($db, $sql)) {
    print 0;
    exit;
} else {
    print 3;
    exit;
}
?>
