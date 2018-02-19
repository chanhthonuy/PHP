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
            
           $db = getDatabase();
           
           $stmt = $db->prepare("SELECT * FROM students");
           
            $results = array();
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        ?><td><a class="btn btn-warning" type="submit" href="addStudent.php?">Add Student</a></td>
                    <td><a class="btn btn-warning"type="submit" href="view.php?">View Students</a></td>
                    <td><a class="btn btn-warning"type="submit" href="addLabUsage.php?">Add Lab Usage</a></td>                    
                    <td><a class="btn btn-warning" type="submit"href="viewLabs.php?">View Lab Room</a></td>
                    <td><a class="btn btn-primary" type="submit"href="viewLabUsage.php?">View Lab Usage"</a></td>
                    
        
        
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    
                     <th>First Name</th>
                    <th>Last Name</th>
                    <th>Student Id</th>
                    <th>Password</th>
                  
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                   
                    <td><?php echo $row['firstName']; ?></td>
                    <td><?php echo $row['lastName']; ?></td> 
                    <td><?php echo $row['studentId']; ?></td> 
                    <td><?php echo $row['password']; ?></td> 
                  
                    
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
           
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    </body>
</html>
