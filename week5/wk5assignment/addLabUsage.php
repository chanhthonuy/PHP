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

            $stmt = $db->prepare("INSERT INTO labusage SET labUsageId = :labUsageId, studentId = :studentId, roomNumber = :roomNumber, dayTimeSignIn= :dayTimeSignIn,dayTimeSignOut= :dayTimeSignOut");

            $labUsageId = filter_input(INPUT_POST, 'labUsageId');
            $studentId = filter_input(INPUT_POST, 'studentId');
            $roomNumber = filter_input(INPUT_POST, 'roomNumber');
            $dayTimeSignIn = filter_input(INPUT_POST, 'dayTimeSignIn');
            $dayTimeSignOut = filter_input(INPUT_POST, '$dayTimeSignOut');
        
            $binds = array(
                ":labUsageId" => $labUsageId,
                ":studentId" => $studentId,
                ":roomNumber" => $roomNumber,
                ":dayTimeSignIn" => $dayTimeSignIn,
                ":dayTimeSignOut" => $dayTimeSignOut                
            );


            /*
             * empty()
             * isset()
             */

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $results = 'Lab Usage Added';
            }
        }
        ?>

        <h1>Add Lab Usage</h1>
    
   
    <form method="post" action="addLabUsage.php">            
        
        <br />
        Student ID <input type="text" value="" name="studentId" />
        <br />
        Room Number  <select name="Room Number">
        <option>N200</option>
        <option>N201</option>
        <option>N202</option>
        <option>N203</option>
        <option>N204</option>
        <option>N205</option>
        <option>N206</option>
        <option>N207</option>
        <option>N208</option>
        <option>N209</option>
    </select>
        <br />          
        Time Sign In <input type="datetime-local" value="" name="dayTimeSignIn" />
        <br />
        Time Sign Out <input type="datetime-local" value="" name="dayTimeSignOut" />
        <br />
      
<a href="view.php"> Go back </a>
        <input type="submit" value="Submit" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </form>
</body>
</html>
