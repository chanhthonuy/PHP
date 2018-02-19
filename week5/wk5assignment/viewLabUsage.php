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
        
//           $db = getDatabase();
//           
//           $stmt = $db->prepare("SELECT * FROM labusage");
//           
//            $results = array();
//            if ($stmt->execute() && $stmt->rowCount() > 0) {
//                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            }
            
              include_once './dbconnect.php';
           include_once './dbData.php';
           include './sort.php'; 
           include './filter.php';
            include_once './includes/sort.php';
            include_once './includes/search.php';
           
            $action = filter_input(INPUT_GET, 'action');
            if ($action === 'sortBy') {
                $column = filter_input(INPUT_GET, 'labUsageid');
                $order = filter_input(INPUT_GET, 'sortBy');
                $results = sortTest($column, $order);
            } else if ($action === 'search') {
                $column = filter_input(INPUT_GET, 'labUsageid');
                $searchWord = filter_input(INPUT_GET, 'search');
                $search = '%'.$searchWord.'%';
                $results = searchTest($column, $search);
            }
           
          /*$column = filter_input(INPUT_GET, 'columns'); 
          if ($column == " ") {
              $column = "labUsageid";
          }
          $db = getDatabase();
           //$column = 'corp';
           //$order = 'DESC'; //DESC
           $sortBy = filter_input(INPUT_GET, 'sortBy');  
           if ($sortBy == " ") {
              $sortBy = "labUsageid";
          }*/
          
           $stmt = $db->prepare("SELECT * FROM labusage ORDER BY $column $sortBy");

             $results = array();
             if ($stmt->execute() && $stmt->rowCount() > 0) {
                 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
             }

            
        ?>
        
        
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Lab Usage ID</th>
                     <th>Student ID</th>
                    <th>Room Number</th>
                    <th>Time Sign In</th>
                    <th>Time Sign Out</th>
                  
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row['labUsageId']; ?></td>
                    <td><?php echo $row['studentId']; ?></td>
                    <td><?php echo $row['roomNumber']; ?></td> 
                    <td><?php echo $row['dayTimeSignIn']; ?></td> 
                    <td><?php echo $row['dayTimeSignOut']; ?></td> 
                  
                  <td><a class="btn btn-warning" type="submit" href="addStudent.php?id=<?php echo $row['id']; ?>">Add Student</a></td>
                    <td><a class="btn btn-warning"type="submit" href="view.php?id=<?php echo $row['id']; ?>">View Students</a></td>
                    <td><a class="btn btn-warning"type="submit" href="addLabUsage.php?id=<?php echo $row['id']; ?>">Add Lab Usage</a></td>                    
                    <td><a class="btn btn-warning" type="submit"href="viewLabs.php?id=<?php echo $row['id']; ?>">View Lab Room</a></td>
                    <td><a class="btn btn-primary" type="submit"href="viewLabUsage.php?id=<?php echo $row['id']; ?>">View Lab Usage</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
           
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    </body>
</html>
