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
           
           $stmt = $db->prepare("SELECT * FROM friends");
           
            $results = array();
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        ?>
        
        
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Friend ID</th>
                     <th>Friend's First Name</th>
                    <th>Friend's Last Name</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
               
                <tr>
                    <td><?php echo $row['friendId']; ?></td>
                    <td><?php echo $row['friendFirstName']; ?></td>
                    <td><?php echo $row['friendLastName']; ?></td> 
                   
                    <td><a class="btn btn-warning" type="submit" href="addFriend.php?id=<?php echo $row['friendId']; ?>">Add</a></td>
                    <td><a class="btn btn-warning"type="submit" href="read.php?id=<?php echo $row['friendId']; ?>">Read</a></td>                    
                   <td><a class="btn btn-warning"type="submit" href="delete.php?id=<?php echo $row['friendId']; ?>">Delete</a></td>
                    <td><a class="btn btn-primary" type="submit"href="update.php?id=<?php echo $row['friendId']; ?>">Update</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="viewGifts.php"> View Gifts </a>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    </body>
</html>
