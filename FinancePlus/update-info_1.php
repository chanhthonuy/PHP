<!doctype HTML>
<?php include_once './functions/logged-in.php' ?>
<html>
<head>
	<title>Update Info</title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
    <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
        
        $db = dbconnect();
        
        $fname = '';
		$lname = '';
        $email = '';
		
        if (isPostRequest()) {
			$fname = filter_input(INPUT_POST, 'n_fname');
            $lname = filter_input(INPUT_POST, 'n_lname');
			$email = filter_input(INPUT_POST, 'n_email');
			
			$stmt = $db->prepare("UPDATE user_accounts SET fname = :fname, lname = :lname, email = :email WHERE uname = :uname");
			
			$binds = array(
				":uname" => $_SESSION['uname'],
				":fname" => $fname,
				":lname" => $lname,
				":email" => $email
			);
			
			// Grab data from the database. ##
			$result = array();
			if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				$_SESSION['fname'] = $fname;
				$_SESSION['lname'] = $lname;
				$_SESSION['email'] = $email;
				header('Location: home.php');
			} else {
				$err = "Failed!";
			}
        }
        
    ?>
    <br><br><br><br>
	<div id="content-signup" >
		<form method="post" action="#" >
			<h1 class="title" style="text-align:center;" > Update Information</h1>
			
			<input type="text" class="field" value="<?php echo $_SESSION['fname'] ?>" name="n_fname" placeholder="First Name" style="text-align:center;" required />
			<input type="text" class="field" value="<?php echo $_SESSION['lname'] ?>" name="n_lname" placeholder="Last Name" style="text-align:center;" required /><br><br>
			<input type="email" class="field" value="<?php echo $_SESSION['email'] ?>" name="n_email" placeholder="Email Address" style="text-align:center;" required /><br><br>
			<br>
			<input type="text" class="error" value="<?php echo $err ?>" readonly /><br>
			<br>
			<input id="buttonSubmit" class="sbtn" type="submit" value="Update" />
		</form>
		<a href="home.php" style="float:right;">◄ Home</a>
	</div>
</body>
</html>