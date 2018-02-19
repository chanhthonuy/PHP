<?php

function getAllTestData() {
    $db = dbconnect();
           
    $stmt = $db->prepare("SELECT * FROM school");

    $results = array();
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}

function sortTest($column, $order) {
    $db = dbconnect();

    $stmt = $db->prepare("SELECT * FROM school ORDER BY $column $order");
    
    $results = array();
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $results;
}

function searchTest($column, $search) {
    $db = dbconnect();
    
    $stmt = $db->prepare("SELECT * FROM school WHERE $column LIKE :search");


    $binds = array(
        ":search" => $search
    );
    $results = array();
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $results;
}
