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
                ":friendId" => $giftId,
                ":friendFirstName" => $friendFirstName,
                ":friendLastName" => $friendLastName,
                
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
            
        } else {
            header('Location: updateFriends.php');
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

        <form method="post" action="#"> 

            Friend's First Name <input type="text" name="friendFirstName" value="<?php echo $friendFirstName ?>" />
            <br />
            Friend's Last Name <input type="now" name="friendLastName" value="<?php echo $friendLastName ?>" />
            <br />          

            <br />
            <input type="hidden" name="giftId" value="<?php echo $giftId ?>" />
            
            <td><a class="btn btn-warning" href="delete.php?id=<?php echo $giftId; ?>">Delete</a></td>
            <td><a class="btn btn-primary" href="update.php?id=<?php echo $giftId; ?>">Update</a></td>

        </form>
   


    <a href="view.php"> Go back </a>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
