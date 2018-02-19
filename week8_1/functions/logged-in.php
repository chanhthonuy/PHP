<?php
session_start();
if (($_SESSION['loggedin'] != "TRUE") || ($_SESSION['uname'] == "")) {
	// Redirect to Login Screen. ##
	header('Location: login.php');
	
	// Just in case if redirect failed. ##
	echo "You Are Not Logged In!";
	die();
}
