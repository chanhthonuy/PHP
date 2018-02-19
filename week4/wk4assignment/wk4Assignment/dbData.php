<?php

function getAllTestData() {
   $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM corps");

    $results = array();
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}

/*
 * $stmt = $db->prepare("SELECT * FROM corps ORDER BY $column $order");
 */

function searchTest($column, $search) {
   
    $db = getDatabase();

    $stmt = $db->prepare("SELECT * FROM corps WHERE $column LIKE :search");

   
    $binds = array(
        ":search" => $search
    );
    $results = array();
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}
