<?php
/**
 * Function to establish a database connection
 * 
 * @return PDO Object
 */  

function dbconnect() {
    $dbname="finance_plus"; 
    $username="Default_User";
    $pwd="\$Defcon360$"; // your student id WITHOUT the zeroes
    
	$config = array(
		'DB_DNS' => "mysql:host=localhost;port=3306;dbname=$dbname;",
		'DB_USER' => $username,
		'DB_PASSWORD' => $pwd
	);
	
	/* Create a Database connection and 
	 * save it into the variable */
	$db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
    return $db;
}




