<?php
	session_start();
	if(session_destroy()) { // If successfully destroyed, send the user back
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>
