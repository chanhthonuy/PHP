<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/barberLogin.css">
        <title>User Login</title>
    </head>
    <body>
        <?php
        session_start();

        $_SESSION['LoggedIn'] = false;

        include './functions/dbconnect.php';
        include './functions/postrequest.php';
        include './functions/salt.php';

        $getDB = getDatabase();

        if (isPostRequest()) {
            $username = filter_input(INPUT_POST, 'username');
            $password = filter_input(INPUT_POST, 'password');
            $salt = Salt();

            $encryptedPwd = sha1($encryptedPwd) . $salt;

            $sql = $getDB->prepare("SELECT * FROM userSignUp WHERE userName = :username AND password = :password");

            $binds = array(
                ":username" => $username,
                ":password" => $encryptedPwd
            );
            
            if($sql->execute($binds) && $sql->rowCount() > 0)
            {
                $_SESSION['LoggedIn'] = true; 
                header("Location: home.php"); 
            }
            else {
                header("Location: UserLogin.php"); 
            }
            
        }
        ?>
        <div class="login">
            <form action="#" method="POST">
                <h1>Barber<span style="color: red; border: solid black 3px; border-radius: 9px;">Stop</span></h1>
                <input type="text" name="username" id="username" placeholder="Username" required><br><br>
                <input type="password" name="password" id="password" placeholder="Password" required><br><br>
                <input type="submit" name="submit" id="submit">
            </form>
    </body>
</html>
