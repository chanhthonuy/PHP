
 <body>
        <?php
            session_start();
            
            include_once './header.php';
            include_once './dbconnect.php';
            
            if ( !empty($_POST) ) {
               
                $username = filter_input(INPUT_POST, 'username');
                
                if ( $username === 'Chan' ) {
                   $_SESSION['loggedin'] = true;                   
                } else {
                    echo 'Incorrect Username';
                }
            
            }
                   
                   
            if ( !empty($_POST) ) {
               
                $passcode = filter_input(INPUT_POST, 'passcode');
                
                if ( $passcode === 'mypassword' ) {
                   $_SESSION['loggedin'] = true;
                   header('Location: upload.php');
                } else {
                    echo 'Incorrect Passcode';
                }
            
            }
        ?>
        
        <form method="post" action="#">    
            Username <input type="username" value="" name="username" />
            Passcode <input type="password" value="" name="passcode" />            
            <input type="submit" value="Login" />          
        </form>
    </body>