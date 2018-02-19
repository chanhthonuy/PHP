<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Website CSS style -->
        <link rel="stylesheet" type="text/css" href="assets/stylesUserReg.css">



        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

        <title>Forgot Password</title>


    </head>
    <style>
        .div-form{
            width:450px; 
            background-color:rgba(0, 0, 0, 0.9);
            border-radius:20px; 
            border:5px solid red;
            padding:20px;
        }

        .label{
            color:whitesmoke;
            font-weight: bold;
            padding-bottom:10px;
        }
        .a:hover{
            color:whitesmoke; 
            transition: .2s;
            cursor:pointer;
        }
        .a{
            color:red;
            font-weight:bold;
            text-decoration: none;
            cursor:pointer;
        }
        .label-red{
            color:red;
            padding-bottom:10px;
            font-weight:bold;
            font-size:1.75em;
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
        .symbols{
            color:whitesmoke;
        }
        .title-red{
            color:red;
            font-size:2em;
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
    <body>

        <?php
        include './functions/dbconnect.php';
        include './functions/postrequest.php';
        include './functions/salt.php';
        // START THE SESSION:
        session_start();
        $message = $name_found = $uname = $sq_form = $pw_form = "";
        $results = array();
        $_SESSION['LoggedIn'] = false;
        $db = getDatabase();
        $salt = Salt();

        //INITIAL USERNAME FORM
        $un_form = "<form method='post' id='name-form'>"
                . "<label class='label-red'>Enter Your Username</label>"
                . "<br/>"
                . "<br/>"
                . "&nbsp;&nbsp;<input type='text' name='uname' class='textbox' required placeholder='Enter Here'/>"
                . "<br/>"
                . "<br/>"
                . "<input type='submit' id='sub_button' class='btn' name='submit'/>"
                . "<br/>"
                . "</form>";

        //FIND USERNAME, DISPLAY SECURITY QUESTION
        if (isset($_POST['submit'])) {
            $uname = filter_input(INPUT_POST, 'uname');
            $_SESSION['uname'] = $uname;
            $stmt = $db->prepare("SELECT security_question, userID FROM usersignup WHERE userName = '$uname';");
            $un_form = "";
            if ($stmt->execute() && $stmt->rowCount() > 0) {

                $message = "1 User Found: " . "<label style='color:red;'>" . "$uname" . "</label><br/>";
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //DISPLAY SECURITY QUESTION FORM
                foreach ($results as $data) {
                    $_SESSION["userID"] = $data['userID'];
                    $sq_form = "<br/>"
                            . "<form method='post'>"
                            . "<label class='label-red'>Answer This Security Question: </label>"
                            . "<br/><br/>"
                            . "<label class='label'>" . $data['security_question'] . " </label><br/>"
                            . "<br/>"
                            . "&nbsp;&nbsp;<input type='text' name='sq_answer_text' class='textbox' required='required' placeholder='Answer Here'/>"
                            . "<br/><br/>"
                            . "<input type='submit' name='answer_submit' class='btn'value='Submit'/>"
                            . "</form>";
                }
            } else {
                //DISPLAY NO USER ERROR
                $message = "No Users Have Been Found With The Username ' <label style='color:red;'>$uname</label> '"
                        . "<br/><br/><a class='a' href='forgotPW.php'>Try Again</a><br/><br/>";
            }
        }

        //COMPARE ANSWER TO DATABAS DATA. SECURE
        if (isset($_POST['answer_submit'])) {
            //Encrypt and Add Salt
            $sq_answer = Sha1(filter_input(INPUT_POST, 'sq_answer_text')) . $salt;
            $answer_stmt = $db->prepare("SELECT * FROM usersignup WHERE sq_answer = '$sq_answer';");
            $un_form = "";

            //CHECk DATABASE, ADD PASSWORD FORM
            if ($answer_stmt->execute() && $answer_stmt->rowCount() > 0) {
                $message = "<span style='color:red;'>*" . ' ' . "</span>Your Answer Is Correct, Please Enter a New Password<span style='color:red;'>" . ' ' . "*</span><br/>";

                $pw_form = "<br/>"
                        . "<form method='post'>"
                        . "<label class='label-red'>Enter a New Password</label>"
                        . "<br/><br/>"
                        . "&nbsp;&nbsp;<input type='text' name='pw_answer_text' class='textbox' required='required' placeholder='Enter New Password Here'/>"
                        . "<br/><br/>"
                        . "<input type='submit' name='pw_answer_submit' class='btn'value='Submit'/>"
                        . "</form>";
            } else {
                $message = "<span style='color:red;'>*" . ' ' . "</span>Your Answer's Invalid<span style='color:red;'>" . ' ' . "*</span>"
                        . "<br/><br/><a class='a' href='forgotPW.php'>Try Again</a><br/><br/>";
            }
        }
        //HANDLE PASSWORD
        if (isset($_POST['pw_answer_submit'])) {

            //GET NEW PASSWORD, ENCRYPT PW, AND ADD A SALT
            $id = $_SESSION["userID"];
            $un = $_SESSION['uname'];
            $new_pw = sha1(filter_input(INPUT_POST, 'pw_answer_text')) . $salt;
            $pw_update_stmt = $db->prepare("UPDATE usersignup SET password = '$new_pw' WHERE userID='$id' AND userName = '$un';");

            //EXECUTE SQL AND CHECK FOR RETURNED ROWS
            if ($pw_update_stmt->execute() && $pw_update_stmt->rowCount() > 0) {
                $message = "<span style='color:red;'>*" . ' ' . "</span>Hey $uname, Your Password Has Successfully Been Updated!<span style='color:red;'>" . ' ' . "*</span>"
                        . "<br/>"
                        . "<br/>"
                        . "<span style='color:red;'>*" . ' ' . "</span>Click <a href='UserLogin.php' class='a'>Here</a> To Log In To Your Account!<span style='color:red;'>" . ' ' . "*</span>";
            } else {
                $message = "<span style='color:red;'>*" . ' ' . "</span>Oh No! There Was An Issue Updating Your Password!<span style='color:red;'>" . ' ' . "*</span>";
            }
        }
        ?>
    <center>
        <div class="div-form">
            <div style="border: 5px solid red; border-radius:20px; background-color: #d3d3d3;">
                <h1 class="title">Barber<span class="BSTOP" style="color: red; font-weight: bold; ">Stop</span></h1>
            </div>
            <h1 style="color: whitesmoke; align-content: center;">Forgot<span class="BSTOP" style="font-weight: bolder; color: red"> Password</span></h1>
            <div id="usernameForm">
                <?php echo $un_form; ?>
            </div>
            <?php echo $sq_form ?>
            <?php echo $pw_form ?>
            <br/>
            <label class="label"><?php echo $message; ?></label>
            <br/>
            <br/>
            <label class="label">Login Options</label>
            <br/>
            <br/>
            <a href="UserLogin.php" class="a">User Login</a><label class="symbols">&nbsp;&#9900;&nbsp;</label>
            <a href="barberLogin.php" class="a">Barber Login</a><label class="symbols">&nbsp;&#9900;&nbsp;</label>
            <a href="userRegistry.php" class="a">User Registry</a><label class="symbols">&nbsp;&#9900;&nbsp;</label>
            <a href="barberRegistryphp" class="a">Barber Registry</a>
            <br/>
    </center>
</div>

<script type="text/javascript">
</script>


<script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>

</html>
