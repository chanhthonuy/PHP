<?php
session_start();
if (($_SESSION['loggedin'] != "TRUE") || ($_SESSION['uname'] == "")) {
	// Redirect to Login Screen. ##
	header('Location: login.php');
	
	justInCase();
}
if ($_SESSION['uname'] == "administrator") {
	// Redirect to Admin Home Screen. ##
	header('Location: admin.php');
	
	justInCase();
}

function justInCase() {
	// Just in case if redirect failed. ##
	echo "You Are Not Logged In!";
	die();
}