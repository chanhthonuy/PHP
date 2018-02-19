<!doctype HTML>
<?php
session_start();
if ($_SESSION['loggedin'] != "TRUE") {
    $_SESSION['loggedin'] = "FALSE";
    if ($_SESSION['uname'] == "") {
        $_SESSION['uname'] = "";
        $_SESSION['attempts'] = 1;
    }
    $_SESSION['fname'] = "";
    $_SESSION['lname'] = "";
    $_SESSION['email'] = "";
}
?>
<html>
    <head>
        <title>FinancePlus Login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

        <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
        include_once './functions/salt.php';

        $db = dbconnect();

        $uname = '';
        $pwd = '';
        $salt = salt();
        $limit = 10;    // Number of tries to login on a user. ##

        if (isPostRequest()) {
            $uname = strtolower(filter_input(INPUT_POST, 'n_uname'));
            $pwd = sha1(filter_input(INPUT_POST, 'n_pwd') . $salt);

            if ($_SESSION['uname'] != $uname) {
                $_SESSION['attempts'] = 1;
                $_SESSION['uname'] = $uname;
            } else {
                if ($uname != "administrator") {
                    $_SESSION['attempts'] ++;
                }
            }

            $stmt = $db->prepare("SELECT * FROM user_accounts WHERE uname = :uname");

            $binds = array(
                ":uname" => $uname
            );

            // Grab data from the database. ##
            $result = array();
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result['locked']) {
                    header('Location: locked-out.php');
                } else {
                    if ($pwd === $result['pwd']) {
                        $_SESSION['loggedin'] = "TRUE";
                        $_SESSION['fname'] = $result['fname'];
                        $_SESSION['lname'] = $result['lname'];
                        $_SESSION['email'] = $result['email'];
                        $_SESSION['home'] = "true";

                        $stmt = $db->prepare("UPDATE user_accounts SET last_login = now() WHERE uname = :uname");

                        $binds = array(
                            ":uname" => $uname
                        );

                        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                            if ($uname == "administrator") {
                                header('Location: admin.php');
                            } else {
                                header('Location: home.php');
                            }
                        } else {
                            header('Location: error.php');
                        }
                    } else {
                        $err = incorrect();

                        if ($_SESSION['attempts'] >= $limit) {
                            $stmt = $db->prepare("UPDATE user_accounts SET locked = true WHERE uname = :uname");

                            $binds = array(
                                ":uname" => $uname
                            );

                            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                                $_SESSION['attempts'] = 1;
                                header('Location: locked-out.php');
                            }
                        }
                    }
                }
            } else {
                $err = incorrect();
            }
        }

        function incorrect() {
            $_SESSION['loggedin'] = "FALSE";
            $_SESSION['fname'] = "";
            $_SESSION['lname'] = "";
            $_SESSION['email'] = "";
            return "Incorrect Username and/or Password!";
        }
        ?>
        <h1 class="title" style="text-align:center;" > FinancePlus Login</h1>		       


        <img class="pic" src="imgs/money.png"/>

        <div class="logmod">
            <div class="logmod__wrapper">
                <span class="logmod__close">Close</span>
                <div class="logmod__container">
                    <ul class="logmod__tabs">
                        <li data-tabtar="lgm-2"><a href="login.php">Login</a></li>
                        <li data-tabtar="lgm-1"><a href="sign-up.php">Sign Up</a></li>
                    </ul>
                    <div class="logmod__tab-wrapper">
                        <div class="logmod__tab lgm-1">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle">Enter your personal details <strong>to create an account</strong></span>
                            </div>
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="sign-up.php" class="simform" method="post">

                                        <div class="sminputs">
                                            <div class="input string optional">
                                                <label class="string optional" name="n_uname">Username *</label>
                                                <input type="text" class="field" name="n_uname" placeholder="Username" autocomplete="off" required autofocus />
                                            </div>
                                            <div class="input string optional">
                                                <label class="string optional" name="n_email">Email Address *</label>
                                                <input type="email" class="field" name="n_email" placeholder="Email Address" autocomplete="off" required />
                                            </div>
                                        </div>
                                        <div class="sminputs">
                                            <div class="input string optional">
                                                <label class="string optional" name="n_firstname">First Name *</label>
                                                <input type="text" class="field" name="n_firstname" placeholder="First Name" autocomplete="off" required />
                                            </div>
                                            <div class="input string optional">
                                                <label class="string optional" name="n_lastname">Last Name *</label>
                                                <input type="text" class="field" name="n_lastname" placeholder="Last Name" autocomplete="off" required /><br><br>
                                            </div>
                                        </div>
                                        <div class="sminputs">
                                            <div class="input string optional">
                                                <label class="string optional" for="user-pw">Password *</label>
                                                <input type="password" class="field" name="n_pwd1" placeholder="Password" autocomplete="off" required /><br>
                                            </div>
                                            <div class="input string optional">
                                                <label class="string optional" for="user-pw-repeat">Repeat password *</label>
                                                <input type="password" class="field" name="n_pwd2" placeholder="Password Confirm" autocomplete="off" required /><br><br>
                                            </div>
                                        </div>
                                        <div class="simform__actions">
                                            
                                            <input id="buttonSubmit" class="submit" type="submit" value="Create Account" name="commit"/>
                                      
                                            <span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="#" target="_blank" role="link">Terms & Privacy</a></span>
                                        </div> 
                                    </form>
                                   
                            </div> 
                            <div class="logmod__alter">
                                <div class="logmod__alter-container">
                                    <a href="https://en-gb.facebook.com/r.php" class="connect facebook">
                                        <div class="connect__icon">
                                            <i class="fa fa-facebook"></i>
                                        </div>
                                        <div class="connect__context">
                                            <span>Create an account with <strong>Facebook</strong></span>
                                        </div>
                                    </a>

                                    <a href="https://myaccount.google.com/" class="connect googleplus">
                                        <div class="connect__icon">
                                            <i class="fa fa-google-plus"></i>
                                        </div>
                                        <div class="connect__context">
                                            <span>Create an account with <strong>Google+</strong></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="logmod__tab lgm-2">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle">Enter your username and password <strong>to sign in</strong></span>
                            </div> 
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="#" class="simform" method="post">
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label for="inputUname3" class="form-control form-element">Username</label>
                                            <input type="textbox" class="form-control form-element" name="n_uname" placeholder="Username" id="user" autocomplete="off" value="<?php echo $_SESSION['uname'] ?>" <?php if ($_SESSION['uname'] == "") echo"autofocus" ?> required autofocus/>
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label for="inputPassword3" class="glyphicon glyphicon-eye-open">Password</label>
                                            <input type="password" class="form-control form-element" name="n_pwd" placeholder="Password" id="pass" autocomplete="off" <?php if ($_SESSION['uname'] != "") echo"autofocus" ?> required/>
                                            <span class="hide-password">Show</span>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="remember-me"> Remember me
                                        </label>
                                    </div>
                                    <label>

                                    </label>
                                    <br>
                                    <div class="simform__actions">
                                  <input id="buttonSubmit" class="btn btn-default btn-success btn-block submit-btn login-btn" type="submit" value="Login" />
                                  <span class="simform__actions-sidetext"><a class="special" role="link" href="#">Forgot your password?<br>Click here</a></span>
            </div> 
                                </form>
                                <div class="logmod__alter">
                                    <div class="logmod__alter-container">
                                        <a href="https://en-gb.facebook.com/login/" class="connect facebook">
                                            <div class="connect__icon">
                                                <i class="fa fa-facebook"></i>
                                            </div>
                                            <div class="connect__context">
                                                <span>Sign in with <strong>Facebook</strong></span>
                                            </div>
                                        </a>
                                        <a href="https://myaccount.google.com/" class="connect googleplus">
                                            <div class="connect__icon">
                                                <i class="fa fa-google-plus"></i>
                                            </div>
                                            <div class="connect__context">
                                                <span>Sign in with <strong>Google+</strong></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>



    <script  src="js/login.js"></script>
</body>
</html>