<!doctype HTML>
<?php
    include_once './functions/logged-in.php';
?>

<html>
<head>
	<title>Delete Account</title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
    <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
        
        $db = dbconnect();
        
		$uname = $_SESSION['uname'];
        $account_number = (int)filter_input(INPUT_GET, 'account');
		
        if (isPostRequest()) {
            
			$stmt = $db->prepare("DELETE FROM transactions WHERE uname = :uname AND account_number = :account_number");
			
			$binds = array(
				":uname" => $uname,
				":account_number" => $account_number
			);
			
			// Grab data from the database. ##
			if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				// Do Nothing. ##
			}
			$stmt = $db->prepare("DELETE FROM tabs WHERE uname = :uname AND account_number = :account_number");
				
			if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				header('Location: home.php');
			} else {
				echo "Failed!";
				die();
			}
		}
		
    ?>
    <br><br><br><br>
	<center>
	<div>
		<form method="post" action="#">
			<h1 class="title"><?php echo $_SESSION['fname'] ?>, are you sure you want to <u><b style="color:red;" >delete</b></u> this profile?</h1>
			<br><br><br>
			<input id="buttonSubmit" class="btn btn-danger" type="submit" value="Yes" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="home.php" class="btn btn-primary" >Cancel</a>
		</form>
	</div>
	</center>
</body>
</html>