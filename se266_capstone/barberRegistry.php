<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Website CSS style -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="assets/ICONS/favicon.png" type="image/x-icon" />
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
        $messages = $file_err = "";
        $_SESSION['LoggedIn'] = false;

        $getDB = getDatabase();

        if (isset($_POST['barbRegSubmit'])) {
            //IMAGE UPLOAD
            $num = rand(1, 999999);
            $num_string = (string) $num;
            $target_dir = "USER_BARBER_IMAGES/";
            $target_file = $target_dir . $num_string . $_FILES["file_barb"]["name"];
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            
            $check = getimagesize($_FILES["file_barb"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $file_err = "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $file_err = "Sorry, Image Already Exists.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $file_err = "Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $file_err = "Sorry, your file was not uploaded. Might Already Exist";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["file_barb"]["tmp_name"], $target_file)) {
                    
                } else {
                    $file_err = "Sorry, there was an error uploading your file.";
                }
            }

            $image_path = $num_string . $_FILES["file_barb"]["name"];

            //BARBER DATA
            $salt = Salt();
            $barberName = filter_input(INPUT_POST, 'barberName');
            $barberEmail = filter_input(INPUT_POST, 'barberEmail');
            $barberUserName = filter_input(INPUT_POST, 'username');
            $password = sha1(filter_input(INPUT_POST, 'password'));
            $confirm_password = sha1(filter_input(INPUT_POST, 'confirm_password'));
            $security_question = filter_input(INPUT_POST, 'sq');
            $sq_answer = sha1(filter_input(INPUT_POST, 'sq_answer')) . $salt;
            $barbershop = filter_input(INPUT_POST, 'barbershop');

            if ($password != $confirm_password) {
                $messages = "ERROR: <label class='label-white'> Your Passwords Do Not Match!</label>";
            } else {
                $encryptedPwd = $password . $salt;
                $sql = $getDB->prepare("INSERT INTO barber_accounts SET barberName = '$barberName', barberEmail = '$barberEmail', barberUserName = '$barberUserName', pw = '$encryptedPwd', security_question = '$security_question', sq_answer = '$sq_answer', account_type = 'barber', account_status = 'active',image_path = '$image_path', BarberShopID = '$barbershop';");

                if ($sql->execute() && $sql->rowCount() > 0) {
                    $messages = "Your Account Has Been Sucessfully Created Click <a href='barberlogin.php' class='a'>Here</a> To Login";
                } else {
                    echo "ERROR! <label class='WhiteLabel'>There Was An Error Creating Your Account</label>";
                }
            }
        }
        ?>
    <center>
        <div class="container">

            <div class="row main">
                <div class="login" style="width:450px; background-color:rgba(0, 0, 0, 0.9); border-radius:20px; border:5px solid red; padding:35px;">
                    <br style="line-height: 0%;"/>
                    <div style="border: 5px solid red; width: 300px;border-radius:20px; background-color: #d3d3d3; padding: 5px;">
                        <h1 class="title">Barber<span class="BSTOP" style="color: red; font-weight: bolder;">Stop</span></h1>

                    </div>
                    <h1 style="color: whitesmoke; align-content: center;">Barber<span class="BSTOP" style="font-weight: bolder; color: red">Sign-Up</span></h1>
                    <form class="login" method="post" action="" enctype="multipart/form-data">

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
                                    <input type="password" class="textbox" name="confirm_password" id="password"  placeholder="Enter your Retyped Password"required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="BarberShop" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Select Your Barber Shop</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true" style="color:red;"></i></span>
                                    <select name="barbershop" class="textbox" style="width:277px;" required>
                                        <option  value='Select Your BarberShop' disabled selected>Select Your BarberShop</option>
                                        <?php
                                        $sql_barb = $getDB->prepare("SELECT * FROM barber_shop_data;");
                                        if ($sql_barb->execute() && $sql_barb->rowCount() > 0) {
                                            $results2 = $sql_barb->fetchAll(PDO::FETCH_ASSOC);
                                        }
                                        ?>
                                        <?php foreach ($results2 as $selectData): ?>
                                            <option value="<?php echo $selectData['BarberShopID'] ?>"><?php echo $selectData['barberShopName'] ?></option>
                                        <?php endforeach; ?>
                                        <option  value='none'>I Do Not Want To Choose</option>
                                    </select>
                                    <br/>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="security_question" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Security Question </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true" style="color:red;"></i></span>
                                    <select name="sq" class="textbox" style="width:277px;" required>
                                        <option  value="Select A Security Question" disabled selected>Select a Security Question</option>
                                        <option  value="Where Were You Born?">Where Were You Born?</option>
                                        <option  value="What is The Name of Your First Pet?">What is The Name of Your First Pet?</option>
                                        <option  value="What High School Did you Go To?">What High School Did you Go To?</option>
                                        <option  value="What Barber Ruined Your Hair The Worst?">What Barber Ruined Your Hair The Worst?</option>
                                        <option  value="Where Did Your Parents Meet">Where Did Your Parents Meet</option>
                                    </select>
                                    <br/>
                                    <br/>
                                    <label style="font-weight: bold; color:red;" >&quest;&nbsp;</label>
                                    <input type="text" class="textbox" name="sq_answer" id="password"  placeholder="Answer Here" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="images" class="cols-sm-2 control-label" style="color:whitesmoke; font-weight: bold;">Upload Image</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true" style="color:red;"></i></span>
                                    <input type="file" name="file_barb" class="image_upload" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <input  type="submit" value="Submit" class="btn" name="barbRegSubmit"/>
                        </div>
                        <label class="msg"><?php echo $messages; ?></label><br/>
                        <label class="msg"><?php echo $file_err; ?></label>
                        <div class="form-group ">
                            <a href="landingPage.php" class="a">Go Back</a>
                        </div>
                        <br/>
                    </form>
                </div>
            </div>
        </div>
    </center>
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
    .msg{
        color:red;
        font-weight: bold;
        font-family: arial;
    }
    .image_upload{
        content: 'Select Your Image';
        color: black;
        display: inline-block;
        background:none;
        border: 2px solid red;
        border-radius: 3px;
        padding: 5px 8px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        text-shadow: 1px 1px #fff;
        font-weight: 700;
        color: whitesmoke;
        font-size: 10pt;
    }
</style>
</html>