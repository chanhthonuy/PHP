<?php

$db_exists = file_exists("daypilot.sqlite");

$db = new PDO('sqlite:daypilot.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// other init
date_default_timezone_set("UTC");
session_start();

if (!$db_exists) {
    //create the database
    $db->exec("CREATE TABLE barber (
    barber_id   INTEGER       PRIMARY KEY AUTOINCREMENT NOT NULL,
    barber_name VARCHAR (100) NOT NULL
    );");
    
    $db->exec("CREATE TABLE appointments (
    appointment_id              INTEGER       PRIMARY KEY AUTOINCREMENT NOT NULL,
    appointment_start           DATETIME      NOT NULL,
    appointment_end             DATETIME      NOT NULL,
    appointment_client_name    VARCHAR (100),
    appointment_status          VARCHAR (100) DEFAULT ('free') NOT NULL,
    appointment_client_session VARCHAR (100),
    barber_id                   INTEGER       NOT NULL
    );");

    $items = array(
        array('name' => 'Barber 1'),
        array('name' => 'Barber 2'),        
        array('name' => 'Barber 3'),        
        array('name' => 'Barber 4'),        
        array('name' => 'Barber 5'),        
    );
    $insert = "INSERT INTO [barber] (barber_name) VALUES (:name)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':name', $name);
    foreach ($items as $m) {
      $name = $m['name'];
      $stmt->execute();
    }

}

?>
