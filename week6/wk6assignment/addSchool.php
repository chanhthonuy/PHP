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

            $stmt = $db->prepare("INSERT INTO school SET schoolName = :schoolName, city = :city, state= :state");

            $schoolName = filter_input(INPUT_POST, 'schoolName');
            $city = filter_input(INPUT_POST, 'city');
            $state = filter_input(INPUT_POST, 'state');
           

            $binds = array(
                ":schoolName" => $schoolName,
                ":city" => $city,
                ":state" => $state
                
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

    <form method="post" action="addStudent.php">            
       
        School Name <input type="text" value="" name="schoolName" />
        <br />
        City<input type="now" value="" name="city" />
        <br />          
        State <input type="text" value="" name="state" />
        <br />
      input type="text" value="" name="phone" />
        <br />
//<a href="view.php"> Go back </a>
        <input type="submit" value="Submit" />
         //<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </form>
</body>
</html>
