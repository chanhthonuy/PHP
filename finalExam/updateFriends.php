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
        include_once './dbconnect.php';
        include_once './functions.php';

        $db = getDatabase();
        $friendId = '';
        $friendFirstName = '';
        $friendLastName = '';
      

        if (isPostRequest()) {


            $friendId = filter_input(INPUT_POST, 'friendId');
            $friendFirstName = filter_input(INPUT_POST, 'friendFirstName');
            $friendLastName = filter_input(INPUT_POST, 'friendLastName');
            

            $stmt = $db->prepare("UPDATE friends SET friendId = :friendId, friendFirstName = :friendFirstName, friendLastName = :friendLastName");

            $binds = array(
                ":friendId" => $friendId,
                ":friendFirstName" => $friendFirstName,
                ":friendLastName" => $friendLastName
                
            );

            $message = 'Update failed';
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $message = 'Update Complete';
            }
        } else {
            $friendId = filter_input(INPUT_GET, 'friendId');
        }

        $stmt = $db->prepare("SELECT * FROM friends where friendId = :friendId");

        $binds = array(
            ":friendId" => $friendId
        );

        $result = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $friendFirstName = $result['friendFirstName'];
            $friendLastName = $result['friendLastName'];
            
            /*
              $id = filter_input(INPUT_POST, 'id');
              $corp = filter_input(INPUT_POST, 'corp');
              $incorp_dt = filter_input(INPUT_POST, 'incorp_dt');
              $email = filter_input(INPUT_POST, 'email');
              $zipcode = filter_input(INPUT_POST, 'zipcode');
              $owner = filter_input(INPUT_POST, 'owner');
              $phone = filter_input(INPUT_POST, 'phone');

             */
        } else {
            header('Location: viewFriends.php');
            die('ID not found');
        }
        ?>

        <p>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
        </p>

        <form method="post" action="updateFriends.php"> 
            
            First Name <input type="text" name="friendFirstName" value="<?php echo $friendFirstName ?>" />
            <br />
            Last name <input type="text" name="friendLastName" value="<?php echo $friendLastName ?>" />
            <br />          
           
             <input type="hidden" name="i-d" value="<?php echo $friendId ?>" />
            <input type="submit" value="Submit" />
        </form>

        <a href="viewFriends.php"> Go back </a>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
