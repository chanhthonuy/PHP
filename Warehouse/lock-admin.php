<!doctype HTML>
<?php include_once './functions/logged-in-admin.php' ?>
<html>
<head>
	<title></title>
</head>
<body>
    <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
    
        $db = dbconnect();
		
        $uname = filter_input(INPUT_GET, 'uname');
        $locked = filter_input(INPUT_GET, 'locked');
		
		if ($locked == 'true') {
			$stmt = $db->prepare("UPDATE user_accounts SET locked = false WHERE uname = :uname");
		} else {
			$stmt = $db->prepare("UPDATE user_accounts SET locked = true WHERE uname = :uname");
		}
		
		$binds = array(
		   ":uname" => $uname  
		); 
		
		if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
			header('Location: profile.php?account='.$account_number);
		} else {
			echo "<br> SQL failed!";
		}
    ?>
</body>
</html>