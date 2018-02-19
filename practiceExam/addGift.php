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
        include './search.php';

        $results = '';

        if (isPostRequest()) {
            $db = getDatabase();

            $stmt = $db->prepare("INSERT INTO gifts SET giftId = :giftId, friendId = :friendId, giftDescription = :giftDescription");

            $giftId= filter_input(INPUT_POST, 'giftId');
            $friendId = filter_input(INPUT_POST, 'friendId');
            $giftDescription = filter_input(INPUT_POST, 'giftDescription');
           

            $binds = array(
                ":giftId" => $giftId,
                ":friendId" => $friendId,
                ":giftDescription" => $giftDescription
                
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

        <h1>Add Corporation Data</h1>
    
    
    <h2><?php echo $results; ?></h2>

    <form method="post" action="addGift.php">            
       
        Gift ID <input type="text" value="" name="giftId" />
        <br />
        Friend's ID<input type="now" value="" name="friendId" />
        <br />          
        Gift's Description <input type="text" value="" name="giftDescription" />
        <br />
      
//<a href="view.php"> Go back </a>
        <input type="submit" value="Submit" />
         //<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </form>
</body>
</html>
