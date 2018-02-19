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
           
           $stmt = $db->prepare("SELECT * FROM labs");
           
            $results = array();
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        ?>
        
        
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Room Number</th>
                     <th>Capacity</th>
                                  
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row['roomNumber']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                  
                  
         <td><a class="btn btn-warning" type="submit" href="addStudent.php?id=<?php echo $row['id']; ?>">Add Student</a></td>
                    <td><a class="btn btn-warning"type="submit" href="view.php?id=<?php echo $row['id']; ?>">View Students</a></td>
                    <td><a class="btn btn-warning"type="submit" href="addLabUsage.php?id=<?php echo $row['id']; ?>">Add Lab Usage</a></td>                    
                    <td><a class="btn btn-warning" type="submit"href="viewLabs.php?id=<?php echo $row['id']; ?>">View Lab Rooms</a></td>
                    <td><a class="btn btn-primary" type="submit"href="viewLabUsage.php?id=<?php echo $row['id']; ?>">View Lab Usage</a></td>
                    
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
           
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    </body>
</html>
