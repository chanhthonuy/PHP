<?php

/* * *****************************************************************

  MAIN FUNCTIONS PAGE

 * **************************************************************** */

//Get Search Data From DataBase, return Results
function searchCorps($column, $searchWord) {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM corps WHERE $column LIKE :search");
    $search = '%' . $searchWord . '%';

    $binds = array(
        ":search" => $search
    );

    $results = array();

    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowCount = $stmt->rowCount();

        include 'formprocess.php';
        echo "<br /><br />";
        if ($searchWord == null) {
            echo $rowCount . " Rows Retrieved From The Corps Database";
        } else {
            echo $rowCount . " Rows Retrieved From The Corps Database Column "."\"" . $column.  "\"" . " That Includes " . "\"" . $searchWord . "\"";
        }
        echo "<br /><br />";
        include 'view-order.php';
    } else {
        include 'includes/error.php';
    }
    return $results;
}

//Get Sorted Data From DataBase, return Results
function sortData($column, $sortby) {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM corps ORDER BY $column $sortby");
    $results = array();

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowCount = $stmt->rowCount();

        include 'formprocess.php';
        echo "<br /><br />";
        echo $rowCount . " Rows Retrieved and Sorted By $column $sortby From The Corps Database.";
        echo "<br /><br />";
        include 'view-order.php';
    } else {
        include 'includes/error.php';
    }
    return $results;
}

//Get Data From Form 1
function getSortData() {
    if (isset($_GET["sortAction"])) {
        $column = filter_input(INPUT_GET, "sortOption");
        $sortby = filter_input(INPUT_GET, "radioOPTION");

        if ($column == null || $sortby == null) {
            echo "<p style='font-weight:bold; font-size:20px; color:red;'>" . "Please Complete The The Sort/Filter Form" . "</p>";
        } else {
            $results = sortData($column, $sortby);
        }
    }
}

//Get Data from Form 2
function getSearchData() {
    if (isset($_GET["searchAction"])) {
        $searchWord = filter_input(INPUT_GET, "searchBox");
        $column = filter_input(INPUT_GET, "searchOption");

        if ($column == null) {
            echo "<p style='font-weight:bold; font-size:20px; color:red;'>" . "Choose a Column To Search" . "</p>";
        } else {
            $results = searchCorps($column, $searchWord);
        }
    }
}
