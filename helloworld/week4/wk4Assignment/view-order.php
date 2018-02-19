        <title></title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        
        
    </head>
    <body>
        <h2>Corporations View</h2>



        <?php
        
           include_once './dbconnect.php';
           include_once './dbData.php';
           include './sort.php'; 
           include './filter.php';
           include './functions.php';
           
          $column = filter_input(INPUT_GET, 'columns'); 
          if ($column == " ") {
              $column = "id";
          }
          $db = getDatabase();
           //$column = 'corp';
           //$order = 'DESC'; //DESC
           $sortBy = filter_input(INPUT_GET, 'sortBy');  
           if ($sortBy == " ") {
              $sortBy = "id";
          }
          
           $stmt = $db->prepare("SELECT * FROM corps ORDER BY $column $sortBy");

             $results = array();
             if ($stmt->execute() && $stmt->rowCount() > 0) {
                 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
             }

        ?>
          
        <table border="1">
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
                              
                     </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
       
    </body>
</html>
