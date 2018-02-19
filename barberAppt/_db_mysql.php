<?php
$host = "127.0.0.1";
$port = 3306;
$username = "username";
$password = "password";
$database = "barber";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// other init
date_default_timezone_set("UTC");
session_start();

$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
$db->exec("use `$database`");

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "barber");

if (!$exists) {
    //create the database
    $db->exec("CREATE TABLE barber (
    barber_id   INTEGER       PRIMARY KEY AUTO_INCREMENT NOT NULL,
    barber_name VARCHAR (100) NOT NULL
    );");

    $db->exec("CREATE TABLE appointments (
    appointment_id              INTEGER       PRIMARY KEY AUTO_INCREMENT NOT NULL,
    appointment_start           DATETIME      NOT NULL,
    appointment_end             DATETIME      NOT NULL,
    appointment_client_name    VARCHAR (100),
    appointment_status          VARCHAR (100) DEFAULT 'free' NOT NULL,
    appointment_client_session VARCHAR (100),
    doctor_id                   INTEGER       NOT NULL
    );");

    $items = array(
        array('name' => 'Barber 1'),
        array('name' => 'barber 2'),
        array('name' => 'barber 3'),
        array('name' => 'barber 4'),
        array('name' => 'barber 5'),
    );
    $insert = "INSERT INTO barber (barber_name) VALUES (:name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $name = $m['name'];
      $stmt->execute();
    }

}
?>