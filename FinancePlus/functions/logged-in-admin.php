<?php
session_start();
if (($_SESSION['loggedin'] != "TRUE") || ($_SESSION['uname'] != "administrator")) {
	// Redirect to Login Screen. ##
	header('Location: home.php');
	
	justInCase();
}

function justInCase() {
	// Just in case if redirect failed. ##
	echo "You Are Not Logged In!";
	die();
}