<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>
<link rel="stylesheet" type="text/css" href="assets/barberLogin.css">

</head>
<body>
    <?php 
   
    include './functions/dbconnect.php'; 
    include './functions/postrequest.php';
    include './functions/salt.php'; 
    
    session_start(); 
    
    $_SESSION['LoggedIn'] = false; 
    
    $getDB = getDatabase(); 
    
    
  //  print_r($getDB); 
    
    if(isPostRequest()){
        
        $username = filter_input(INPUT_POST, 'username'); 
       
        $password = filter_input(INPUT_POST, 'password'); 
       
        $salt = Salt();
        
        $encryptedPwd = sha1($password) . $salt; 
        
        $sql = $getDB->prepare("SELECT * FROM barberSignUp WHERE barberUserName = :barberUserName AND password = :password"); 
        $binds = array(
            ":barberUserName"=> $username, 
            ":password"=> $encryptedPwd 
            
            
        ); 
        
        
        
        if($sql->execute($binds) && $sql->rowCount() > 0)
        {
            $_SESSION['LoggedIn'] = true; 
            header("Location: home.php"); 
        }
        else {
            header("Location: barberLogin.php"); 
        }
        
        
    } // END POST REQUEST
    
    
    ?>

<div class="login">
    <form action="#" method="POST">
        <h1 style="font-family: Raleway; font-weight: bold;">Barber<span style="color: red; border: solid black 3px; border-radius: 9px; font-family:Raleway; font-weight: bolder;">Stop</span></h1>
        <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required><br><br>
<input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required><br><br>
<input type="submit" name="submit" id="submit">
</form>
</div>
</body>
</html>