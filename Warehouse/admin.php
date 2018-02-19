<!doctype HTML>
<?php include_once './functions/logged-in-admin.php' ?>
<html>
<head>
	<title>Home</title>
	<meta name="google" value="notranslate" />
	
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<script src="js/money.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="js/chart.js"></script>
</head>
<body>
	<?php
	    include_once './functions/dbconnect.php';
        include_once './functions/dbData.php';
		
	    $db = dbconnect();
		
		$home_color = "#434343";
        
        $stmt = $db->prepare("SELECT * FROM user_accounts");
        
        // Grab data from the database. ##
        $results = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
		if ($_GET['logout']) {
			session_destroy();
			header('Location: login.php');
		}
	?>
	<h1 style="font-family:Verdana;background-color:<?php echo $home_color ?>;color:#fff;text-align:center" ><b>Logged in as <?php echo $_SESSION['fname'] ?><br>User Accounts</b></h1>
    <div style="margin-left:8px;margin-right:8px;" >
        <a href="admin.php?logout=true" class="btn btn-danger tableFont" >Logout</a> of <?php echo $_SESSION['uname'] ?>
        <br><br>
        <center>
        <table border="1" cellpadding="4" style="font-family:Arial;border-color:#000;text-align:center;background-color:#efefef;" >
            <tr style="background-color:<?php echo $home_color ?>;color:#fff;" >
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Last Login</th>
                <th>Locked Out</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
                foreach ($results as $row):
                if ($row['uname'] != "administrator") {
            ?>
            <tr>
                <td><?php echo $row['uname'] ?></td>
                <td><?php echo $row['fname'] ?></td>
                <td><?php echo $row['lname'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo date("m-d-Y h:i:s a", strtotime($row['last_login'])); ?></td>
                <td><a href="lock-admin.php?uname=<?php echo $row['uname'] ?>&locked=<?php if($row['locked'])echo"true";else echo"false"; ?>" style="color:<?php if($row['locked'])echo"#f00";else echo"#000"; ?>;" ><?php if($row['locked'])echo"true";else echo"false"; ?></a></td>
                <td><a href="" class="btn btn-warning" ></a></td>
                <td><a href="delete-account-admin.php?uname=<?php echo $row['uname'] ?>&fname=<?php echo $row['fname'] ?>" class="btn btn-danger" ></a></td>
            </tr>
            <?php
                }
                endforeach
            ?>
        </table>
        </center>
    </div>
</body>
</html>