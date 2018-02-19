<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include './dbconnect.php';
        include './functions.php';

        $results = '';

        if (isPostRequest()) {
            $db = getDatabase();

            $stmt = $db->prepare("INSERT INTO corps SET id = :id, corp = :corp, incorp_dt = :incorp_dt, email= :email");

            $id = filter_input(INPUT_POST, 'id');
            $corp = filter_input(INPUT_POST, 'corp');
            $incorp_dt = filter_input(INPUT_POST, 'incorp_dt');          
            $email = filter_input(INPUT_POST, 'email');

            $binds = array(
                ":id" => $id,
                ":corp" => $corp,
                ":incorp_dt" => $incorp_dt,               
                ":email" => $email
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

        <h1>Add Actor Data</h1>
        <form method="post" action="viewCorp.php">
            <button type="submit">View Actor Table</button>
            <br />
        </form>
        <h2><?php echo $results; ?></h2>

        <form method="post" action="addActor.php">            
            ID <input type="number" value="" name="id" />
            <br />
            Company Name <input type="text" value="" name="corp" />
            <br />
            Incorparated Date <input type="now" value="" name="incorp_dt" />
            <br />          
            Email <input type="text" value="" name="email" />
            <br />
<a href="view.php"> Go back </a>
            <input type="submit" value="Submit" />
        </form>
    </body>
</html>
