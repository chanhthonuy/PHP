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
        //declare error message variable and data for form refill
        $pw_err = $data_err = $reg_success = "";

        $name_data = $email_data = $un_data = "";
        if (isset($_POST['submit_btn'])) {


            if (!empty(filter_input(INPUT_POST, 'name')) && !empty(filter_input(INPUT_POST, 'email')) && !empty(filter_input(INPUT_POST, 'username')) && !empty(filter_input(INPUT_POST, 'password')) && !empty(filter_input(INPUT_POST, 'password_confirm'))) {

                $name = filter_input(INPUT_POST, 'name');
                $email = filter_input(INPUT_POST, 'email');
                $username = filter_input(INPUT_POST, 'username');
                $password = filter_input(INPUT_POST, 'password');
                $password_confirm = filter_input(INPUT_POST, 'password_confirm');
                $sq = $_POST['sq'];
                $Salt = Salt();
                $sq_answer = Sha1(filter_input(INPUT_POST, 'sq_answer')) . $Salt;

                $sha1pwd = sha1($password) . $Salt;
                $sha1pwd_confirm = sha1($password_confirm) . $Salt;

                if ($sha1pwd != $sha1pwd_confirm) {

                    $pw_err = "Passwords Do Not Match!";
                } else {
                    $sqlQuery = $getDB->prepare("INSERT INTO usersignup SET name = '$name', email = '$email', userName = '$username', password = '$sha1pwd', security_question = '$sq', sq_answer = '$sq_answer';");

                    if ($sqlQuery->execute() && $sqlQuery->rowCount() > 0) {

                        $reg_success = "Successfully Registered, Click <a href ='userlogin.php'>Here</a> To Login";
                    } else {
                        $reg_success = "Oops, Something Went Wrong, Contact An Administrator Please!";
                    }
                }
            } else {
                $data_err = "Please Fill In All Fields";
            }
        }
        ?>
        <div class="container">
            <div class="row main">
                <div class="main-login main-center" style="width:450px; background-color:rgba(0, 0, 0, 0.9); border-radius:20px; border:5px solid red;">
                    <br/>
                    <div style="border: 5px solid red; border-radius:20px; background-color: #d3d3d3; padding: 5px;">
                        <h1 class="title">Barber<span class="BSTOP" style="color: red; font-weight: bolder;">Stop</span></h1>

                    </div>
                    <h1 style="color: whitesmoke; align-content: center;">User<span class="BSTOP" style="font-weight: bolder; color: red">Sign-Up</span></h1>
                    <form class="login" method="post" action="#">
                        <center><label style="color:red; font-size:20px; font-weight: bold;">Please Enter Your Information</label></center>
                        <br/>
                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Your Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"  style="color:red;"></i></span>
                                    <input type="text" class="textbox" name="name" id="name"  placeholder="Enter your Name" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Your Email</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true" style="color:red;"></i></span>
                                    <input type="text" class="textbox" name="email" id="email"  placeholder="Enter your Email" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Username</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true" style="color:red;"></i></span>
                                    <input type="text" class="textbox" name="username" id="username"  placeholder="Enter your Username"  required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true" style="color:red;"></i></span>
                                    <input type="password" class="textbox" name="password" id="password"  placeholder="Enter Your Password" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Confirm Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true" style="color:red;"></i></span>
                                    <input type="password" class="textbox" name="password_confirm" id="password"  placeholder="Please Retype Your Password" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="security_question" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Security Question </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true" style="color:red;"></i></span>
                                    <select name="sq" class="textbox" style="width:277px;" required>
                                        <option  value="Select A Security Question" disabled selected>Select A Security Question</option>
                                        <option  value="Where Were You Born?">Where Were You Born?</option>
                                        <option  value="What is The Name of Your First Pet?">What is The Name of Your First Pet?</option>
                                        <option  value="What High School Did you Go To?">What High School Did you Go To?</option>
                                        <option  value="What Barber Ruined Your Hair The Worst?">What Barber Ruined Your Hair The Worst?</option>
                                        <option  value="Where Did Your Parents Meet">Where Did Your Parents Meet</option>
                                    </select>
                                    <label class="cols-sm-2 control-label">&nbsp;<a target="" href="#" title="If You Ever Need To Reset Your Password, We Will Ask You This Question."><img src="https://shots.jotform.com/kade/Screenshots/blue_question_mark.png" height="13px"/></a></label>
                                    <br/>
                                    <br/>
                                    <label style="font-weight: bold; color:red;" >&quest;&nbsp;</label>
                                    <input type="text" class="textbox" name="sq_answer" id="password"  placeholder="Answer Here" required/>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="form-group ">
                                <input type="submit" value="Register" name="submit_btn" id="sub_button">
                            </div>

                            <div class="login-register">
                                <a id="login_link" href="userlogin.php">Login</a>
                            </div>
                        </center>
                        <br/>
                        <label style="color:red;"><?php echo $pw_err ?></label>
                        <label style="color:red;"><?php echo $data_err ?></label>
                        <label style="color:red;"><?php echo $reg_success ?></label>
                        <br/>
                        <br/>
                        <a class="a" href="landingPage.php">Go Back</a>

                    </form>
                </div>
            </div>
        </div>

        <style>
            #sub_button{
                width:75px;
                height:30px;
                background-color: black;
                border-radius: 14px;
                border: 1px solid red;
                color:red;
                font-size:16px;
                font-weight: bold;

            }

            #sub_button:hover{
                color: whitesmoke;
                cursor: pointer;
            }
            #login_link{
                text-decoration: none;
                font-size: 14px;
                color: whitesmoke;
                font-weight: bold;
            }

            #login_link:hover{
                color:red;
                cursor: pointer;
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
            a:hover{
                color:whitesmoke; 
                transition: .2s;
            }
            .a{
                color:red;
                font-weight:bold;
                text-decoration: none;
                font-family: arial;
            }
        </style>


        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    </body>

</html>
