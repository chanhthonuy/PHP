        <title></title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        
        
    </head>
    <body>
        <h2>Schools View</h2>



        <?php
        
           include_once './dbconnect.php';
           include_once './header.php';
           include_once './sort.php';
           include_once './filter.php';
           
           
          $column = filter_input(INPUT_GET, 'columns'); 
          if ($column == " ") {
              $column = "schoolName";
          }
          $db = getDatabase();
           //$column = 'corp';
           //$order = 'DESC'; //DESC
           $sortBy = filter_input(INPUT_GET, 'sortBy');  
           if ($sortBy == " ") {
              $sortBy = "schoolName";
          }
          
          $search = filter_input(INPUT_GET, 'search');  
           if ($search == " ") {
              $search = "schoolName";
          }
          
           $stmt = $db->prepare("SELECT * FROM school ORDER BY $column $sortBy");

             $results = array();
             if ($stmt->execute() && $stmt->rowCount() > 0) {
                 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
             }

        ?>
          
        <table border="1">
            <thead>
                <tr>
                     
                     <th>School Name</th>
                    <th>City</th>
                    <th>State</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    
                    <td><?php echo $row['schoolName']; ?></td>
                    <td><?php echo $row['city']; ?></td> 
                    <td><?php echo $row['state']; ?></td> 
                    
                              
                     </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
       
    </body>
</html>
