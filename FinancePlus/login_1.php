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
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/login.css"/>
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
            $pwd = sha1(filter_input(INPUT_POST, 'n_pwd').$salt);
            
            if ($_SESSION['uname'] != $uname) {
                $_SESSION['attempts'] = 1;
                $_SESSION['uname'] = $uname;
            } else {
                if ($uname != "administrator") {
                    $_SESSION['attempts']++;
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
                        
                        if($_SESSION['attempts'] >= $limit) {
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
    <br><br><br><br>
	<div id="content-login">
		<form method="post" action="#" >
			<h1 class="title" style="text-align:center;" > FinancePlus Login</h1>
			<img class="pic" src="imgs/money.png"/>

			<input type="text" class="field" name="n_uname" placeholder="Username" id="user" autocomplete="off" value="<?php echo $_SESSION['uname'] ?>" <?php if($_SESSION['uname']=="")echo"autofocus" ?> /><br>
			<input type="password" class="field" name="n_pwd" placeholder="Password" id="pass" autocomplete="off" <?php if($_SESSION['uname']!="")echo"autofocus" ?> /><br><br>
			<input type="text" class="error" value="<?php echo $err ?>" readonly /><br>
			<br>
			<input id="buttonSubmit" class="sbtn" type="submit" value="Login" />
		</form>
		<a href="sign-up.php" style="float:right;" > Sign Up</a>
	</div>
</body>
</html>