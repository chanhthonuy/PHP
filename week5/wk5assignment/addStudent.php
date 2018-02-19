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

            $stmt = $db->prepare("INSERT INTO students SET firstName = :firstName, lastName = :lastName, studentId= :studentId,password= :password");

            
            $firstName = filter_input(INPUT_POST, 'firstName');
            $lastName = filter_input(INPUT_POST, 'lastName');
            $studentId = filter_input(INPUT_POST, 'studentId');
            $password = filter_input(INPUT_POST, 'password');
        
            $binds = array(
               
                ":firstName" => $firstName,
                ":lastName" => $lastName,
                ":studentId" => $studentId,
                ":password" => $password                
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

        <h1>Add Student Data</h1>
    
    
    <h2><?php echo $results; ?></h2>

    <form method="post" action="addStudent.php">            
       
        <br />
        First Name <input type="text" value="" name="firstName" />
        <br />
        Last Name <input type="now" value="" name="lastName" />
        <br />          
        Student ID <input type="text" value="" name="studentId" />
        <br />
        Password <input type="text" value="" name="password" />
        <br />
      
<a href="view.php"> Go back </a>
        <input type="submit" value="Submit" />
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </form>
</body>
</html>
