<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">

		<!-- Website CSS style -->
                <link rel="stylesheet" type="text/css" href="assets/stylesUserReg.css">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

                <title>User Registry</title>
    <div style="border: 5px solid black; background-color: #d3d3d3;">      
        <h1 class="title">Barber<span class="BSTOP" style="color: red; font-weight: bolder;">Stop</span></h1>
        <h1 style="color: black; float: right;">User<span class="BSTOP" style="font-weight: bolder; color: red">Sign-Up</span></h1>
    </div>           
    
	</head>
        <body>
        
            <?php 
            
            include './functions/dbconnect.php'; 
            include './functions/postrequest.php'; 
            include './functions/salt.php'; 
            // START THE SESSION: 
            session_start(); 
            
            //THE USER DOES NOT HAVE AN ACCOUNT SO THEY SHOULD NOT BE ABLE TO FORWARD 
            // TO ANY OTHER PAGE WITHOUT CREATING A LOGIN 
            
            $_SESSION['LoggedIn'] = false; 
            
            //GET CONNECTED TO THE DATABASE AND DOUBLE CHECK THAT YOU ARE ACTUALLY CONNECTING: 
            $getDB = getDatabase(); 
            // print_r($getDB); 
            
            
            if(isPostRequest())
            {
            
            $name = filter_input(INPUT_POST, 'name'); 
            $email = filter_input(INPUT_POST, 'email'); 
            $username = filter_input(INPUT_POST, 'username'); 
            $password = filter_input(INPUT_POST, 'password'); 
            $Salt = Salt(); 
            $sha1pwd = sha1($password).$Salt; 
            
            $sqlQuery = $getDB->prepare('INSERT INTO userSignUp SET name = :name, email = :email, userName = :userName, password = :password');
            
            $binds = array(
               ":name"=> $name, 
                ":email"=> $email, 
                ":userName"=>$username, 
                ":password"=> $sha1pwd
            ); 
            
            
            
            if($sqlQuery->execute($binds) && $sqlQuery->rowCount() > 0)
            {
                
                $_SESSION['LoggedIn'] = true; 
                header("Location: home.php"); 
            }
            
            else {
                echo "ERROR!"; 
            }
            
            
            
            } // END POST REQUEST 
            
            
            ?>
            <div class="container">
                <div class="row main">
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            
                            <hr />
                        </div>
                    </div> 
                    <div class="main-login main-center">
                        <form class="form-horizontal" method="post" action="#">

                            <div class="form-group">
                                <label for="name" class="cols-sm-2 control-label">Your Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="cols-sm-2 control-label">Your Email</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="cols-sm-2 control-label">Username</label>
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



                            <div class="form-group ">
                                <input type="submit" value="Register" class="btn btn-primary btn-lg btn-block login-button">
                            </div>
                            <div class="login-register">
                                <a href="login.php">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            

            <script type="text/javascript" src="assets/js/bootstrap.js"></script>
        </body>
        
</html>
