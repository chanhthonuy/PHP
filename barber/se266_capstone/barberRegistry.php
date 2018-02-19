<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Website CSS style -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="assets/stylesBarberReg.css">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="style.css">
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

		<title>Admin</title>
	</head>
        <body style="background-image: url(images/barberRegBG.jpg)">
            <?php
            
            include './functions/dbconnect.php'; 
            include './functions/postrequest.php'; 
            include './functions/salt.php'; 
            
            session_start(); 
            
            $_SESSION['LoggedIn'] = false; 
            
            $getDB = getDatabase();
            print_r($getDB); 
            
            if(isPostRequest()){
                
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
                    ":barberName"=> $barberName, 
                    ":barberEmail"=> $barberEmail, 
                    ":barberUserName"=> $barberUserName, 
                    ":password"=> $encryptedPwd, 
                    ":barberShopName"=> $barberShopName, 
                    ":barberShopCity" => $barberCity, 
                    ":barberShopState" => $barberState
                    
                );
                
                if($sql->execute($binds) && $sql->rowCount() > 0)
                {
                    $_SESSION['LoggedIn'] = true; 
                    header("Location: home.php"); 
                }
                else
                {
                    echo "ERROR! PLEASE TRY AGAIN"; 
                }
                
                
                
            }
            ?>
            <div class="container">
                <div class="row main">
                    <div class="main-login main-center" style="background-color: red;">
                        <h5 class="bsignup" style="font-size: 30px; font-weight: bold;">Barber Sign-Up</h5>
                            <form class="" style="background-color: red;" method="post" action="#">

                            <div class="form-group">
                                <label for="barberName" class="cols-sm-2 control-label">Your Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="barberName" id="barberName"  placeholder="Enter your Name"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="barberEmail" class="cols-sm-2 control-label">Your Email</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="barberEmail " id="email"  placeholder="Enter your Email"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="barberUserName" class="cols-sm-2 control-label">Username</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="cols-sm-2 control-label">Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="compName" class="cols-sm-2 control-label">Company Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="compName" id="compName"  placeholder="Company Name"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="compCity" class="cols-sm-2 control-label">City</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="compCity" id="compCity"  placeholder="Company City"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="compState" class="cols-sm-2 control-label">State</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="compState" id="compState"  placeholder="Company State"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <input  type="submit" value="Register" class="btn btn-primary btn-lg btn-block login-button">
                            </div>
                                
                            <div class="form-group ">
                                <button onclick="goBack()" class="btn btn-primary btn-lg btn-block login-button">Go Back</button>
                            </div>

                        </form>
                    </div>
                </div>
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
</html>