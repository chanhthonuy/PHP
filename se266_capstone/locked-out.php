<!doctype HTML>
<?php session_start() ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Too Many Login Attempts</title>
        <link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>
    <body>
        <br><br><br><br><br><br>
        <center>
            <h1><u><b style="color:red;" >*** Locked Out ***</u></b></h1>
            <h1>The Account For The User <u style="color:#a0a;" ><?php echo $_SESSION['uname'] ?></u> Has Been Locked.</h1>
            <h1>Please Contact Customer Service To Have Your Account Unlocked.</h1>
            <h1><u>finaceplus@gmail.com</u> Or <u>(555) 555 - 5555</u></h1>
            <br><br><br>
            <a href="login.php" class="btn btn-success tableFont" >◄ Back to Login</a>
        </center>
    </body>
</html>
