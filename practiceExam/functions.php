<?php

function isLoggedIn() {
    
    if ( !isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false 
            ) {
            return false;
        }
        return true;
}

function getSearchData() {
    if (isset($_GET["searchAction"])) {
        $searchWord = filter_input(INPUT_GET, "searchBox");
        $column = filter_input(INPUT_GET, "searchOption");

        if ($column == null) {
            echo "<p style='font-weight:bold; font-size:20px; color:red;'>" . "Choose a Column To Search" . "</p>";
        } else {
            $results = searchFriends($column, $searchWord);
        }
    }
}
function getSearchData() {
    if (isset($_GET["searchAction"])) {
        $searchWord = filter_input(INPUT_GET, "searchBox");
        $column = filter_input(INPUT_GET, "searchOption");

        if ($column == null) {
            echo "<p style='font-weight:bold; font-size:20px; color:red;'>" . "Choose a Column To Search" . "</p>";
        } else {
            $results = searchGifts($column, $searchWord);
        }
    }
}