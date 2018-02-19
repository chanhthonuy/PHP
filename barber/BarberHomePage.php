<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/barberHomePage.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Barber Home</title>

    </head>
    <style>
        .div{
            overflow:auto;
            width:850px; 
            background-color:rgba(0, 0, 0, 0.8);
            border-radius:20px; 
            border:1px solid red;
            padding:10px;
        }
        .div-text{
            overflow:auto;
            width:450px; 
            border-radius:10px; 
            border:1px solid gray;
            padding:4px;
        }
        .review-div{
            position:relative;
        }
        .label{
            color:whitesmoke;
            font-size: 1em;

        }
    </style>
    <body>
        <?php
        include './functions/dbconnect.php';
        include './functions/postrequest.php';
        include './functions/getrequest.php';

        session_start();

        $_SESSION['LoggedIn'] = true;

        $getDB = getDatabase();
        // print_r($getDB); 
        $db = getDatabase();

        $stmt = $db->prepare("SELECT * FROM Reviews;");

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $message = "Data Read";
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $message = "No Data Has Been Read, There Was An Error";
        }
        ?>
        <!-- Use any element to open the sidenav -->
        <span class="mainmenu" onclick="openNav()">
            <span class="glyphicon glyphicon-menu-hamburger" style="color: whitesmoke; font-size: 50px;">

            </span>

        </span>

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="position:absolute;" >&times;</a>
            <p style="color:whitesmoke; font-size: 25px;; font-family: Raleway; font-weight: bold;">
                Barber<span style="color: red; font-size: 25px; font-family: Raleway; font-weight: bolder;">Stop </span>
            </p>
            <a style="font-family: Raleway;" href="#">About</a>
            <a style="font-family: Raleway;" href="#">Services</a>
            <a style="font-family: Raleway;" href="#">Clients</a>
            <a style="font-family: Raleway;" href="#">Contact</a>
        </div>
<br/>
<?php foreach ($results as $data): ?>
            <div class="review-div" align="center">
                <div class="div">
                    <div class="div-text" style="float:right;">
                        <label class="label" style="float:left;"><?php echo $data["review_text"]; ?></label>
                    </div>
                    <br/>
                </div>
                <br/>
            </div>
<?php endforeach; ?>








        <script type="text/javascript" src="assets/js/js_functions.js">
        </script>

    </body>



</html>
