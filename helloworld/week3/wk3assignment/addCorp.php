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

            $stmt = $db->prepare("INSERT INTO corps SET id = :id, corp = :corp, incorp_dt = :incorp_dt, email= :email,zipcode= :zipcode, owner= :owner, phone= :phone");

            $id = filter_input(INPUT_POST, 'id');
            $corp = filter_input(INPUT_POST, 'corp');
            $incorp_dt = filter_input(INPUT_POST, 'incorp_dt');
            $email = filter_input(INPUT_POST, 'email');
            $zipcode = filter_input(INPUT_POST, 'zipcode');
            $owner = filter_input(INPUT_POST, 'owner');
            $phone = filter_input(INPUT_POST, 'phone');

            $binds = array(
                ":id" => $id,
                ":corp" => $corp,
                ":incorp_dt" => $incorp_dt,
                ":email" => $email,
                ":zipcode" => $zipcode,
                ":owner" => $owner,
                ":phone" => $phone
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

    <form method="post" action="addCorp.php">            
        ID <input type="text" value="" name="id" />
        <br />
        Company Name <input type="text" value="" name="corp" />
        <br />
        Incorparated Date <input type="now" value="" name="incorp_dt" />
        <br />          
        Email <input type="text" value="" name="email" />
        <br />
        Zipcode <input type="text" value="" name="zipcode" />
        <br />
        Owner <input type="text" value="" name="owner" />
        <br />
        Phone <input type="text" value="" name="phone" />
        <br />
<a href="view.php"> Go back </a>
        <input type="submit" value="Submit" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </form>
</body>
</html>
