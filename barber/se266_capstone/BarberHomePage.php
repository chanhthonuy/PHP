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

    <body>

        <form style="float: right;" id="hbz-searchbox" action="Search" method="get">
            <input  type="text" id="hbz-input" name="Search" placeholder="Search..." />
            <input  type="hidden" name="Search" value="8" />
            <input  id="hbz-submit" type="submit" value="Search"/>
        </form>  

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <p style="color:whitesmoke; font-size: 25px;; font-family: Raleway; font-weight: bold;">
                Barber<span style="color: red; font-size: 25px; font-family: Raleway; font-weight: bolder;">Stop </span>
            </p>
            <a style="font-family: Raleway;" href="#">About</a>
            <a style="font-family: Raleway;" href="#">Services</a>
            <a style="font-family: Raleway;" href="#">Clients</a>
            <a style="font-family: Raleway;" href="#">Contact</a>
        </div>


        <?php
        include './functions/dbconnect.php';
        include './functions/postrequest.php';
         include './functions/getrequest.php'; 

        session_start();

        $_SESSION['LoggedIn'] = true;

        $getDB = getDatabase();
        // print_r($getDB); 
        
        
        
        
        
        ?>
        
    


        <!-- Use any element to open the sidenav -->
        <span class="mainmenu" onclick="openNav()">
            <span class="glyphicon glyphicon-menu-hamburger" style="color: whitesmoke; font-size: 50px;">

            </span>

        </span>
       



        <script type="text/javascript" src="assets/js/js_functions.js">
        </script>

    </body>



</html>
