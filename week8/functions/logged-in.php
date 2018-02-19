<?php
session_start();
if ($_SESSION['loggedin'] != "TRUE") {
	header('Location: login.php');
	// Just in case if login.php is bypass, die(). ##
	echo "You Are Not Logged In!";
	die();
}