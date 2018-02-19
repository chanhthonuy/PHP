<?php
        /*
         * include the data base connect file
         * and helper functions as if we are adding
         * the code on the page
         */
        include './dbconnect.php';
        include './functions.php';
        
       
         
?>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script
            src="http://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <title>Test Database Connection</title>
    </head>
    <body>
        <div class="container">
            <h2>Test Database Connection</h2>
            <h3>
                <?php if (isset($_SERVER['SERVER_NAME'])) echo $_SERVER['SERVER_NAME']; ?>
            </h3>
             <form action="#" method="post">
                
                 <div class="form-group">
                    <input type="submit" class="btn btn-warning" value="Check Database Connection" name="checkConnection">
                </div>
             </form>   
                 <?php
        
            if (isPostRequest()) {
                $db = getDatabase();
                
                if (is_object($db)) { ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> Database Connection Worked!
                      </div>

                <?php
                } else { ?>
                    <div class="alert alert-danger">
                        <strong>Warning!</strong> Database Connection FAILED!
                      </div>
                <?php
                }
            }
        
            
         
        
        ?>
                 
        </div>
        <hr />
        
        
        
    </body>
</html>
