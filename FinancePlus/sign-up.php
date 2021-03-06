<!doctype HTML>
<html>
<head>
	<title>FinancePlus Signup</title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
    <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
		include_once './functions/salt.php';
        
        $db = dbconnect();
        
        $uname = '';
		$firstName = '';
		$lastName = '';
        $pwd1 = '';
		$pwd2 = '';
		$salt = salt();
		
        if (isPostRequest()) {
			$uname = strtolower(filter_input(INPUT_POST, 'n_uname'));
            $fname = filter_input(INPUT_POST, 'n_firstname');
			$lname = filter_input(INPUT_POST, 'n_lastname');
			$email = filter_input(INPUT_POST, 'n_email');
			$pwd1 = sha1(filter_input(INPUT_POST, 'n_pwd1').$salt);
			$pwd2 = sha1(filter_input(INPUT_POST, 'n_pwd2').$salt);
            
			if ($pwd1 === $pwd2) {
				$stmt = $db->prepare("INSERT INTO user_accounts (uname, pwd, fname, lname, email, last_login, locked) VALUES (:uname, :pwd, :fname, :lname, :email, now(), 0)");
				
				$binds = array(
					":uname" => $uname,
					":pwd" => $pwd1,
					":fname" => $fname,
					":lname" => $lname,
					":email" => $email
				);
				
				// Grab data from the database. ##
				$result = array();
				if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					header('Location: login.php');
				} else {
					$err = "Username already taken!";
				}
			} else {
				$err = "Password did not match!";
			}
        }
        
    ?>
    <br><br><br><br>
	<div id="content-signup">
		<form method="post" action="#">
			<h1 class="title" style="text-align:center;" > Create an Account</h1><br>

			<input type="text" class="field" name="n_uname" placeholder="Username" required autofocus /><br><br>
			<input type="text" class="field" name="n_firstname" placeholder="First Name" required />
			<input type="text" class="field" name="n_lastname" placeholder="Last Name" required /><br><br>
			<input type="email" class="field" name="n_email" placeholder="Email Address" required /><br><br>
			<input type="password" class="field" name="n_pwd1" placeholder="Password" required /><br>
			<input type="password" class="field" name="n_pwd2" placeholder="Password Confirm " required /><br><br>
			<br>
			<input type="text" class="error" value="<?php echo $err ?>" readonly /><br>
			<br>
			<input id="buttonSubmit" class="sbtn" type="submit" value="Register" />
		</form>
		<a href="login.php" style="float:right;"> ◄ Back</a>
	</div>
</body>
</html>