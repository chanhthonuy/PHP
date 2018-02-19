<?php
function dbconnect() {
    $dbname = "finance_plus"; 
    $username = "Default_User";
    $pwd = "\$Defcon360$";
	$config = array(
		'DB_DNS' => "mysql:host=localhost;port=3306;dbname=$dbname;",
		'DB_USER' => $username,
		'DB_PASSWORD' => $pwd
	);
	$db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
    return $db;
}




