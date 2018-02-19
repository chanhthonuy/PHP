<!DOCTYPE html>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <meta charset="UTF-8">
        <title>Sort/Search Corps DataBase</title>        
    </head>
    <body style="padding:20px; background-color: lightskyblue;">
        <div style="border:2px solid black; border-radius: 10px; padding:20px; background-color: white; overflow:hidden; display:inline-block;">
            <?php
            //include the other php pages
            include_once './functions/dbconnect.php';
            include_once './functions/functions.php';
            include 'includes/form1.php';
            include 'includes/form2.php';

            $db = getDatabase();

            //Get Sort Data From Form 1 / Test isset statement in functions.php
            getSortData();

            //Get Search Data From Form 2 / Test isset statement in functions.php
            getSearchData();
            
            ?>
            <br/>
            <br/>
        </div>
    </body>
</html>
