<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Website CSS style -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type=text/css href="assets/stylesBarberReg.css">

        <!-- Website Font style -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="styles.css">
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

        <title>Barbe Registry</title>
    </head>
    <body style="background-image: url(images/barberRegBG.jpg)">
        <?php
        include './functions/dbconnect.php';
        include './functions/postrequest.php';
        include './functions/salt.php';

        session_start();

        $_SESSION['LoggedIn'] = false;

        $getDB = getDatabase();

        if (isPostRequest()) {

            $barberName = filter_input(INPUT_POST, 'barberName');
            $barberEmail = filter_input(INPUT_POST, 'barberEmail');
            $barberUserName = filter_input(INPUT_POST, 'username');
            $password = filter_input(INPUT_POST, 'password');
            $barberShopName = filter_input(INPUT_POST, 'compName');
            $barberCity = filter_input(INPUT_POST, 'compCity');
            $barberState = filter_input(INPUT_POST, 'compState');
            $Salt = Salt();

            $encryptedPwd = sha1($password) . $Salt;

            $sql = $getDB->prepare("INSERT INTO barberSignUp SET barberName = :barberName, barberEmail = :barberEmail, barberUserName = :barberUserName, password = :password, barberShopName = :barberShopName, barberShopCity = :barberShopCity, barberShopState = :barberShopState");

            $binds = array(
                ":barberName" => $barberName,
                ":barberEmail" => $barberEmail,
                ":barberUserName" => $barberUserName,
                ":password" => $encryptedPwd,
                ":barberShopName" => $barberShopName,
                ":barberShopCity" => $barberCity,
                ":barberShopState" => $barberState
            );

            if ($sql->execute($binds) && $sql->rowCount() > 0) {
                $_SESSION['LoggedIn'] = true;
                header("Location: BarberHomePage.php");
            } else {
                echo "ERROR! PLEASE TRY AGAIN";
            }
        }
        ?>
        <div class="container">
            <center>
                <div class="row main">
                    <div class="login" style="width:450px; background-color:rgba(0, 0, 0, 0.9); border-radius:20px; border:5px solid red; padding:15px;">
                        <br style="line-height: 0%;"/>
                        <div style="border: 5px solid red; width: 300px;border-radius:20px; background-color: #d3d3d3; padding: 5px;">
                            <h1 class="title">Barber<span class="BSTOP" style="color: red; font-weight: bolder;">Stop</span></h1>

                        </div>
                        <h1 style="color: whitesmoke; align-content: center;">User<span class="BSTOP" style="font-weight: bolder; color: red">Sign-Up</span></h1>
                        <form class="login" method="post" action="#">

                            <div class="form-group">
                                <label for="barberName" class="WhiteLabel" style="color:whitesmoke;">Your Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="text" class="textbox" name="barberName" id="barberName"  placeholder="Enter your Name" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="barberEmail" class="WhiteLabel" style="color:whitesmoke;">Your Email</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="text" class="textbox" name="barberEmail" id="email"  placeholder="Enter your Email" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="barberUserName" class="WhiteLabel" style="color:whitesmoke;">Username</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa"  style="color:red;" aria-hidden="true"></i></span>
                                        <input type="text" class="textbox" name="username" id="username"  placeholder="Enter your Username"required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="WhiteLabel" style="color:whitesmoke;">Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="password" class="textbox" name="password" id="password"  placeholder="Enter your Password"required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="WhiteLabel" style="color:whitesmoke;">Confirm Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="password" class="textbox" name="password_retype" id="password"  placeholder="Enter your Retyped Password"required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="compName" class="WhiteLabel" style="color:whitesmoke;">Company Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="text" class="textbox" name="compName" id="compName"  placeholder="Company Name" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="compCity" class="WhiteLabel" style="color:whitesmoke;">City</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="text" class="textbox" name="compCity" id="compCity"  placeholder="Company City" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="compState" class="WhiteLabel" style="color:whitesmoke;">State</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" style="color:red;" aria-hidden="true"></i></span>
                                        <input type="text" class="textbox" name="compState" id="compState"  placeholder="Company State" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <input  type="submit" value="Submit" class="btn" name="barbRegSubmit"/>
                            </div>



                            <div class="form-group ">
                                <a href="landingPage.php" class="a">Go Back</a>
                            </div>
                            <br/>
                        </form>
                    </div>
                </div>

            </center>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">

            function goBack() {
                window.history.back();
            }
        </script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>


    <style>
        WhiteLabel{
            color:white;
        }

        bsignup{
            color:red;
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
        .a:hover{
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
        .btn{
            width:75px;
            height:30px;
            background-color: black;
            border-radius: 14px;
            border: 1px solid red;
            color:red;
            font-size:16px;
            font-weight: bold;
            cursor:pointer;
        }
        .btn:hover{
            transition: .2s;
            color:whitesmoke;
        }
    </style>
</html>