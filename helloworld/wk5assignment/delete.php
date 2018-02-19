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
        
        $id = filter_input(INPUT_GET, 'id');
        
        $db = getDatabase();
           
        $stmt = $db->prepare("DELETE FROM corps where id = :id");
           
        $binds = array(
             ":id" => $id
        );
           
        $isDeleted = false;
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $isDeleted = true;
        }         
        
        ?>
        
        <h1> Record <?php echo $id; ?>  
            <?php if ( !$isDeleted ): ?>Not<?php endif; ?> 
            Deleted
        </h1>
        <a href="view.php"> Go back </a>
        <a href="<?php echo filter_input(INPUT_SERVER, 'HTTP_REFERER'); ?>"> Go back </a>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
