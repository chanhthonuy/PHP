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
        $id = '';
        $corp = '';
        $incorp_dt = '';
        $email = '';
        $zipcode = '';
        $owner = '';
        $phone = '';


        if (isPostRequest()) {


            $id = filter_input(INPUT_POST, 'id');
            $corp = filter_input(INPUT_POST, 'corp');
            $incorp_dt = filter_input(INPUT_POST, 'incorp_dt');
            $email = filter_input(INPUT_POST, 'email');
            $zipcode = filter_input(INPUT_POST, 'zipcode');
            $owner = filter_input(INPUT_POST, 'owner');
            $phone = filter_input(INPUT_POST, 'phone');

            $stmt = $db->prepare("UPDATE corps SET id = :id, corp = :corp, incorp_dt = :incorp_dt, email= :email, zipcode= :zipcode, owner= :owner, phone= :phone");

            $binds = array(
                ":id" => $id,
                ":corp" => $corp,
                ":incorp_dt" => $incorp_dt,
                ":email" => $email,
                ":zipcode" => $zipcode,
                ":owner" => $owner,
                ":phone" => $phone
            );

            $message = 'Update failed';
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $message = 'Update Complete';
            }
        } else {
            $id = filter_input(INPUT_GET, 'id');
        }

        $stmt = $db->prepare("SELECT * FROM corps where id = :id");

        $binds = array(
            ":id" => $id
        );

        $result = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $corp = $result['corp'];
            $incorp_dt = $result['incorp_dt'];
            $email = $result['email'];
            $zipcode = $result['zipcode'];
            $owner = $result['owner'];
            $phone = $result['phone'];


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
            header('Location: view.php');
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
            
            Company Name <input type="text" name="corp" value="<?php echo $corp ?>" />
            <br />
            Incorparated Date <input type="now" name="incorp_dt" value="<?php echo $incorp_dt ?>" />
            <br />          
            Email <input type="text"  name="email" value="<?php echo $email ?>"/>
            <br />
            Zipcode <input type="text" name="zipcode" value="<?php echo $zipcode ?>"/>
            <br />
            Owner <input type="text"  name="owner" value="<?php echo $owner ?>"/>
            <br />
            Phone <input type="text" name="phone" value="<?php echo $phone ?>" />
            <br />
             <input type="hidden" name="i-d" value="<?php echo $id ?>" />
            <input type="submit" value="Submit" />
        </form>

        <a href="view.php"> Go back </a>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
