<!doctype HTML>
<?php
    session_start();
    if ($_SESSION['loggedin'] != "TRUE") {
        $_SESSION['loggedin'] = "FALSE";
		if ($_SESSION['uname'] == "") {
			$_SESSION['uname'] = "";
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
        
        if (isPostRequest()) {
            $uname = strtolower(filter_input(INPUT_POST, 'n_uname'));
            $pwd = sha1(filter_input(INPUT_POST, 'n_pwd').$salt);
            $_SESSION['uname'] = $uname;
			
            $stmt = $db->prepare("SELECT * FROM user_accounts WHERE uname = :uname AND pwd = :pwd");
            
            $binds = array(
                ":uname" => $uname,
                ":pwd" => $pwd
            );
			
            // Grab data from the database. ##
            $result = array();
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result['locked']) {
					$err = "Your account has been locked!";
				} else {
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
						header('Location: home.php');
					} else {
						header('Location: error.php');
					}
				}
            } else {
                $_SESSION['loggedin'] = "FALSE";
				$_SESSION['fname'] = "";
				$_SESSION['lname'] = "";
				$_SESSION['email'] = "";
				$err = "Incorrect Username and/or Password!";
            }
        } else {
			$_SESSION['uname'] = "";
		}
    ?>
    <br><br><br><br>
	<div id="content-login">
		<form method="post" action="#" >
			<h1 class="title" style="text-align:center;" > FinancePlus Login</h1>
			<img class="pic" src="imgs/money.png"/>

			<input type="text" class="sr-only" name="n_uname" placeholder="Username" id="user" value="<?php echo $_SESSION['uname'] ?>" <?php if($_SESSION['uname']=="")echo"autofocus" ?> /><br>
			<input type="password" class="sr-only" name="n_pwd" placeholder="Password" id="pass" <?php if($_SESSION['uname']!="")echo"autofocus" ?> /><br><br>
			
			<input type="text" class="error" value="<?php echo $err ?>" readonly /><br>
			<br>
			<input id="buttonSubmit" class="sbtn" type="submit" value="Login" />
		</form>
		<a href="sign-up.php" style="float:right;"> Sign Up</a>
	</div>
</body>
</html>