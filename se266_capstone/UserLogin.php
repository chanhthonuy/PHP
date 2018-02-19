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
        <link rel="icon" href="assets/ICONS/favicon.png" type="image/x-icon" />
        <title>User Login</title>
    </head>

    <?php
    session_start();

    $_SESSION['LoggedIn'] = false;

    include './functions/dbconnect.php';
    include './functions/postrequest.php';
    include './functions/salt.php';
    $messages = "";
    $getDB = getDatabase();

    if (isset($_POST['submit'])) {
        $username = filter_input(INPUT_POST, 'username');
        $_SESSION['uname'] = $username;
        $password = filter_input(INPUT_POST, 'password');
        $salt = Salt();
        $table = filter_input(INPUT_POST, 'account_type');
        $encryptedPwd = sha1($password) . $salt;

        if ($table == 'barber_accounts') {
            $table_name = $table;
            $table_uname = 'barberUserName';
        } else if ($table == 'user_accounts') {
            $table_name = $table;
            $table_uname = 'uname';
        }
        $sql = $getDB->prepare("SELECT * FROM $table WHERE $table_uname = '$username' AND pw = '$encryptedPwd';");
        echo "SELECT * FROM $table WHERE $table_uname = '$username' AND pw = '$encryptedPwd';";

        if ($sql->execute() && $sql->rowCount() > 0) {
            $results = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $data) {
                $status = $data['account_status'];
                if ($status == 'disabled') {
                    echo $status;
                    $messages = "ERROR: <label class='label-white'>Your Account Has Been Disabled</label>";
                } else if ($status == 'banned') {
                    echo $status;
                    $messages = "ERROR: <label class='label-white'>Your Account Has Been Permanantly Banned</label>";
                } else {
                    //LOGS IN IF ACCOUNT IS VALID AND ACTIVE
                    $_SESSION['LoggedIn'] = true;
                    header("Location: BarberHomePage.php");
                }
            }
        } else {
            //GIVE APPROPRIATE FRONT END ERROR
            $messages = "ERROR: <label class='label-white'>The Account Entered <br/> Does Not Exist</label>";
        }
    }
    ?>
    <body>
    <center>
        <div class="login" style="width:350px; background-color:rgba(0, 0, 0, 0.9); border-radius:20px; border:5px solid red;">
            <form action="#" method="POST">
                <div style="align-content: center;">
                    <h1>Barber<span style="color: red; border: solid black 3px; border-radius: 9px;">Stop</span></h1>
                    <input type="text" name="username" class="textbox" id="username" placeholder="username" required><br><br>
                    <input type="password" name="password" class="textbox" id="password" placeholder="password" required><br><br>
                    <label class='label-white'>Select your Account Type</label>
                    <br/><br/>
                    <label class='label-white'>Barber</label><input type='radio' style="width:16px; height:16px;" name='account_type' value='barber_accounts' required>
                    <label class='label-white'>User</label><input type='radio' style="width:16px; height:16px;" name='account_type' value='user_accounts' required>
                    <br/><br/>
                    <input type="submit" name="submit" id="submit">
                    <br/>
                    <br/>
                    <label class="label"><?php echo $messages ?></label>
                </div>
                <br/>
                <label style="color:whitesmoke; font-family: arial;">Not A Member? Choose An Option Below!</label>
                <br/>
                <br/>
                <a href="BarberRegistry.php" class="a">Register as Barber</a><label class="symbols">&nbsp;&#9900;&nbsp;</label>
                <a href="userRegistry.php" class="a">Register as User</a>
                <br/><br/><br/>
                <a class="a" href="forgotPW.php">Forgot Password?</a>
                <br/><br/>
                <a class="a" href="landingPage.php">Go Back</a>
            </form>
        </div>
    </center>
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
    .label{
        color:red;
        font-weight: bold;
        font-family: arial;
    }
    .label-white{
        color:white;
        font-weight: bold;
        font-family: arial;
    }
    .radio{
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
        border: 1px solid red;
    }
    #submit:hover{
        border:1px solid whitesmoke;
    }

    @import url('https://fonts.googleapis.com/css?family=Raleway');
    @import url('https://fonts.googleapis.com/css?family=Oswald');

    body{

        padding:50px;
        background: url(https://www.barbershop-graz.at/wp-content/uploads/2016/10/Barbershop_034smoke_c_Lupi_Spuma-2.jpg);
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        color: #e7e7e7;
        background-attachment: fixed;

    }
    .login {


        position: absolute;
        top: 60%;
        left: 50%;
        margin: -184px 0px 0px -155px;
        background: rgba(0,0,0,0.5);
        padding: 20px 30px;
        border-radius: 5px;
        box-shadow: 0px 1px 0px rgba(0,0,0,0.3),inset 0px 1px 0px rgba(255,255,255,0.07)
    }

    h1{
        color:white;
    }
    input{
        width:250px;
        height:30px;
    }
    input[type="submit"]{
        background: red;
        border: 0;
        width: 250px;
        height: 40px;
        border-radius: 3px;
        color: white;
        cursor: pointer;
        transition: background 0.4s linear;
    }
</style>
</html>
