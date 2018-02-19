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
        $giftId = '';
        $friendId = '';
        $giftDescription = '';
        


        if (isPostRequest()) {


            $id = filter_input(INPUT_POST, 'giftId');
            $corp = filter_input(INPUT_POST, 'friendId');
            $incorp_dt = filter_input(INPUT_POST, 'giftDescription');
            
            $stmt = $db->prepare("UPDATE gifts SET giftId = :giftId, friendId = :friendId, giftDescription = :giftDescription");

            $binds = array(
                ":giftId" => $giftId,
                ":friendId" => $friendId,
                ":giftDescription" => $giftDescription,
                
            );

            $message = 'Update failed';
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $message = 'Update Complete';
            }
        } else {
            $giftId = filter_input(INPUT_GET, 'giftId');
        }

        $stmt = $db->prepare("SELECT * FROM gifts where giftId = :giftId");

        $binds = array(
            ":giftId" => $giftId
        );

        $result = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $friendId = $result['friendId'];
            $giftDescription = $result['giftDescription'];
            
        } else {
            header('Location: updateGifts.php');
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

            Friend ID <input type="text" name="friendId" value="<?php echo $friendId ?>" />
            <br />
            giftDescription <input type="now" name="giftDescription" value="<?php echo $giftDescription ?>" />
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
