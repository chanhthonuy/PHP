<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


    </head>
    <body>
        <?php
        include './dbconnect.php';
        include './functions.php';

        $results = '';

        if (isPostRequest()) {
            $db = getDatabase();

            $stmt = $db->prepare("INSERT INTO friends SET friendId = :friendId, friendFirstName = :friendFirstName, friendLastName = :friendLastName");

            $friendId = filter_input(INPUT_POST, 'friendId');
            $friendFirstName = filter_input(INPUT_POST, 'friendFirstName');
            $friendLastName = filter_input(INPUT_POST, 'friendLastName');
           

            $binds = array(
                ":friendId" => $friendId,
                ":friendFirstName" => $friendFirstName,
                ":friendLastName" => $friendLastName
               
            );


            /*
             * empty()
             * isset()
             */

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $results = 'Data Added';
            }
        }
        ?>

        <h1>Add Friend's Data</h1>
    
    
    <h2><?php echo $results; ?></h2>

    <form method="post" action="addFriends.php">            
       
        First Name <input type="text" value="" name="friendFirstName" />
        <br />
        Last Name <input type="now" value="" name="friendLastName" />
        <br />          
       
<a href="viewFriends.php"> Go back </a>

        <input type="submit" value="Submit" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </form>
</body>
</html>
