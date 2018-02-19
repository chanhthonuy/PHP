<!doctype HTML>
<?php
    include_once './functions/logged-in.php';
?>

<html>
<head>
	<title>Change Password</title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
    <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
		include_once './functions/salt.php';
        
        $db = dbconnect();
        
        $old = '';
		$pwd = '';
        $pwd2 = '';
		$salt = salt();

        if (isPostRequest()) {
			$old = sha1(filter_input(INPUT_POST, 'n_old').$salt);
            $pwd = sha1(filter_input(INPUT_POST, 'n_pwd').$salt);
			$pwd2 = sha1(filter_input(INPUT_POST, 'n_pwd2').$salt);
            if ($pwd === $pwd2) {
				$stmt = $db->prepare("SELECT * FROM user_accounts WHERE uname = :uname AND pwd = :pwd");
				
				$binds = array(
					":uname" => $_SESSION['uname'],
					":pwd" => $old
				);
				
				// Grab data from the database. ##
				$result = array();
				if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
					//$result = $stmt->fetch(PDO::FETCH_ASSOC);
					
					$stmt = $db->prepare("UPDATE user_accounts SET pwd = :pwd WHERE uname = :uname");
				
					$binds = array(
						":uname" => $_SESSION['uname'],
						":pwd" => $pwd
					);
					
					// Grab data from the database. ##
					$result = array();
					if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
						header('Location: home.php');
					} else {
						$err = "Cannot change password to itself!";
					}
				} else {
					$err = "Incorrect Password!";
				}
			} else {
				$err = "Password did not match!";
			}
        }
        
    ?>
    <br><br><br><br>
	<div id="content-login" >
		<form method="post" action="#" >
			<h1 class="title" style="text-align:center;" > Change Password</h1>
			
			<input type="password" class="field" name="n_old" placeholder="Old Password" style="text-align:center;font-weight:bold;" required /><br>
			<br>
			<input type="password" class="field" name="n_pwd" placeholder="New Password" style="text-align:center;font-weight:bold;" required /><br>
			<input type="password" class="field" name="n_pwd2" placeholder="New Password Confirm" style="text-align:center;font-weight:bold;" required /><br>
			<br>
			<input type="text" class="error" value="<?php echo $err ?>" readonly /><br>
			<br>
			<input id="buttonSubmit" class="sbtn" type="submit" value="Change" />
		</form>
		<a href="home.php" style="float:right;"> ◄ Home</a>
	</div>
</body>
</html>