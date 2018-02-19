
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
        <h2>Corporations View</h2>
        

<form name="sort" action="#" method="get">
    <label>Sort By:</label>
    <select name='columns'><option value='id'>ID</option><option value='corp'>Company Name</option><option value='incorp_dt'>Date</option><option value='email'>Email</option><option value='zipcode'>Zipcode</option><option value='owner'>Owner</option><option value='phone'>Phone</option></select>    
    <input type="radio" name="sortBy" value="asc" >Ascending
    <input type="radio" name="sortBy" value="desc">Descending
    <input type="hidden" name="action" value="sort">
    <input type="submit" name="submit" value="Sort" class="btn btn-success">
   
        
    <br />
</form>
<form name="filter" action="#" method="get">
    <label>Filter By:</label>
     <select name='columns'><option value='id'>ID</option><option value='corp'>Company Name</option><option value='incorp_dt'>Date</option><option value='email'>Email</option><option value='zipcode'>Zipcode</option><option value='owner'>Owner</option><option value='phone'>Phone</option></select>    
     <input type="text" name="search" value="">
   <input type="hidden" name="action" value="filter">
    <input type="submit" name="submit" value="Filter"  class="btn btn-success">
    
    
    
</form>    
        
 <?php
            
           include_once './dbData.php';
           include_once './dbconnect.php';           
           
          $column = filter_input(INPUT_GET, 'columns');  
          $db = getDatabase();
           //$column = 'corp';
           $order = 'ASC'; //DESC
           
          
           $stmt = $db->prepare("SELECT * FROM corps ORDER BY $column $order");

             $results = array();
             if ($stmt->execute() && $stmt->rowCount() > 0) {
                 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
             }
          
        ?>
   
        
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                     <th>Company Name</th>
                    <th>Incorporated Date</th>
                    <th>Email</th>
                    <th>Zipcode</th>
                    <th>Owner</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['corp']; ?></td>
                    <td><?php echo $row['incorp_dt']; ?></td> 
                    <td><?php echo $row['email']; ?></td> 
                    <td><?php echo $row['zipcode']; ?></td> 
                    <td><?php echo $row['owner']; ?></td> 
                    <td><?php echo $row['phone']; ?></td> 
<!--                    <td><a class="btn btn-warning" type="submit" href="addCorp.php?id=<?php echo $row['id']; ?>">Add</a></td>
                    <td><a class="btn btn-warning"type="submit" href="read.php?id=<?php echo $row['id']; ?>">Read</a></td>                    
                   <td><a class="btn btn-warning"type="submit" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                    <td><a class="btn btn-primary" type="submit"href="update.php?id=<?php echo $row['id']; ?>">Update</a></td>-->
                </tr>
            <?php endforeach; ?>
  
    </body>
</html>
