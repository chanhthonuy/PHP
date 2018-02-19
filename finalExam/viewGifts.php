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
           
           $stmt = $db->prepare("SELECT * FROM gifts");
           
            $results = array();
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        ?>
        
        
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Gift ID</th>
                     <th>Friend ID</th>
                    <th>Gift Description</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
           
                <tr>
                    <td><?php echo $row['giftId']; ?></td>
                    <td><?php echo $row['friendId']; ?></td>
                    <td><?php echo $row['giftDescription']; ?></td> 
                   
                    <td><a class="btn btn-warning" type="submit" href="addGifts.php?id=<?php echo $row['giftId']; ?>">Add</a></td>
                                   
                    <td><a class="btn btn-warning"type="submit" href="deleteGifts.php?id=<?php echo $row['giftId']; ?>">Delete</a></td>
                    <td><a class="btn btn-primary" type="submit"href="updateGifts.php?id=<?php echo $row['giftId']; ?>">Update</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
           <a href="viewFriends.php"> View Friends </a>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    </body>
</html>
