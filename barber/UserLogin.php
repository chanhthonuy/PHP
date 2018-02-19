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

            $encryptedPwd = sha1($password) . $salt;

            $sql = $getDB->prepare("SELECT * FROM userSignUp WHERE userName = '$username' AND password = '$encryptedPwd';");

            if ($sql->execute() && $sql->rowCount() > 0) {
                $_SESSION['LoggedIn'] = true;
                header("Location: BarberHomePage.php");
            } else {
                header("Location: UserLogin.php");
            }
        }
        ?>
        <div class="login" style="width:300px; background-color:rgba(0, 0, 0, 0.9); border-radius:20px; border:5px solid red;">
            <form action="#" method="POST">
                <div style="align-content: center;">
                    <h1>Barber<span style="color: red; border: solid black 3px; border-radius: 9px;">Stop</span></h1>
                    <input type="text" name="username" class="textbox" id="username" placeholder="username" required><br><br>
                    <input type="password" name="password" class="textbox" id="password" placeholder="password" required><br><br>
                    <input type="submit" name="submit" id="submit">
                    <br/>
                    <br/>
                </div>
                <br/>
                <label style="color:whitesmoke; font-family: arial;">Not A Member? Click<a class="a"href="userRegistry.php" id="login_link"> Here </a>To Sign Up</label>
                <br/>
                <br/>
                <a class="a" href="forgotPW.php">Forgot Password?</a>
                <br/>
                <br/>
                <a class="a" href="landingPage.php">Go Back</a>
            </form>
        </div>
    </body>
    <style>

        a:hover{
            color:whitesmoke; 
            transition: .2s;
        }
        .a{
            color:red;
            font-weight:bold;
            text-decoration: none;
            font-family: arial;
            cursor:pointer;
        }
        .textbox{
            border: 2px solid red;
            border-radius: 4px;
            color:black;
            padding:5px;
            font-size: 14px;
            font-weight: bold;
            background-color: whitesmoke
        }
    </style>
</html>
