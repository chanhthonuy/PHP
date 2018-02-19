<!doctype HTML>
<?php include_once './functions/logged-in.php' ?>
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
	
	<script>
		var obj = {};
		var data = [];
		var other = null;
	</script>
</head>
<body>
	<?php
	    include_once './functions/dbconnect.php';
	    include_once './functions/functions.php';
		
	    $db = dbconnect();
		
		$home_color = "#434343";
		$i = 0;
		$net_balance = 0.00;
		$cash_balance = 0.00;
		$debt_balance = 0.00;
		$receivables_balance = 0.00;
		
	    // ORDER BY type DESC AND name
	    $stmt = $db->prepare("SELECT * FROM tabs WHERE uname = :uname ORDER BY type ASC, name ASC");
	    
		$binds = array(
			":uname" => $_SESSION['uname']
		);
	    
		$results = array();
		if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		if ($_GET['logout']) {
			session_destroy();
			header('Location: login.php');
		}
	?>
	<h1 style="font-family:Verdana;background-color:<?php echo $home_color ?>;color:#fff;text-align:center" ><b>Welcome back <?php echo $_SESSION['fname'] ?>!<br>Home</b></h1>
	<div width="1000" >
		<div class="left" >
			<a href="home.php?logout=true" class="btn btn-danger tableFont" >Logout</a> of <?php echo $_SESSION['uname'] ?>
			<br><br>
			<table border="1" cellpadding="4" class="tableFont" style="border-color:#000;" >
				<head>
					<tr>
						<th style="border-color:#000;background-color:<?php echo $home_color ?>;color:#ffa;text-align:center;width:120px;" >Net Worth</th>
						<th style="border-color:#000;background-color:<?php echo $home_color ?>;color:#afa;text-align:center;width:120px;" >Cash</th>
						<th style="border-color:#000;background-color:<?php echo $home_color ?>;color:#f66;text-align:center;width:120px;" >Debt</th>
						<th style="border-color:#000;background-color:<?php echo $home_color ?>;color:#fff;text-align:center;width:120px;" >Receivables</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td id="net_bal" >Loading...</td>
						<td id="cash_bal" >Loading...</td>
						<td id="debt_bal" >Loading...</td>
						<td id="receivables_bal" >Loading...</td>
					</tr>
				</tbody>
			</table>
			<br>
			<table border="1" cellpadding="4" class="tableFont" style="border-color:#000" >
				<thead>
					<tr>
						<th style="border-color:#000;width:240px;background-color:<?php echo $home_color ?>;color:#fff;text-align:center;" >Profiles</th>
						<th style="border-color:#000;width:120px;background-color:<?php echo $home_color ?>;color:#fff;text-align:center;" >Balance</th>
						<th style="border-color:#000;width:120px;background-color:<?php echo $home_color ?>;color:#fff;text-align:center;" >Type</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $row): ?>
						<?php
							$balance = 0.00;
							
							$stmt = $db->prepare("SELECT * FROM transactions WHERE uname = :uname AND account_number = :account_number");
							
							$binds = array(
								":uname" => $_SESSION['uname'],
								":account_number" => $row['account_number']
							);
							
							$result = array();
							if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							}
							
							foreach ($result as $r):
								$balance += ($r['deposit'] + $r['withdrawal'] + $r['transfer']);
							endforeach;
							if ($row['type'] == 0) {
								$net_balance += $balance;
								$cash_balance += $balance;
							} else if ($row['type'] == 1) {
								$net_balance -= $balance;
								$debt_balance += $balance;
							} else if ($row['type'] == 2) {
								$net_balance += $balance;
								$receivables_balance += $balance;
							}
						?>
						<script>
							<?php if ($row['type'] == 0) { ?>
								obj = {
									value: <?php echo $balance ?>,
									color: "<?php echo $row['bk_color'] ?>",
									label: "<?php echo $row['name'] ?>"
								}
								if (obj.label == "Other") {
									other = obj.value;
									obj.value = -1000000000000000;
								}
								data[<?php echo $i ?>] = obj;
							<?php 
								$i++;
							}
							?>
						</script>
						<tr style="background-color:<?php echo $row['bk_color'] ?>;color:<?php echo $row['money_color'] ?>;">
							<td style="border-color:#000;font-family:Verdana;" ><a href="profile.php?account=<?php echo $row['account_number'] ?>" style="color:<?php echo $row['text_color'] ?>;"><?php echo $row['name'] ?></a></td>
							<td style="border-color:#000;text-align:right;" ><b><script>document.write(moneyFormat('<?php echo $balance ?>'))</script></b></td>
							<td style="border-color:#000;text-align:center;" ><b><?php if($row['type']==0)echo'Cash';elseif($row['type']==1)echo'Debt';elseif($row['type']==2)echo'Receivable'; ?></b></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<table border="1" cellpadding="4" class="tableFont" style="border-color:#000;" >
				<tr>
					<td style="background-color:<?php echo $home_color ?>;text-align:center;" ><a href="add-profile.php" class="btn btn-success tableFont" >Add Profile</a></td>
				</tr>
			</table>
			<br>
			<table border="1" cellpadding="4" class="tableFont" style="border-color:#000;width:240px;" >
				<tr>
					<th style="border-color:#000;background-color:<?php echo $home_color ?>;color:#fff;text-align:center;" >Settings</th>
				</tr>
				<tr>
					<td style="border-color:#000;background-color:<?php echo $home_color ?>;text-align:center;" ><a href="update-info.php" class="btn btn-primary" >Update Info</a></td>
				</tr>
				<tr>
					<td style="border-color:#000;background-color:<?php echo $home_color ?>;text-align:center;" ><a href="change-password.php" class="btn btn-primary" >Change Password</a></td>
				</tr>
				<tr>
					<td style="border-color:#000;background-color:<?php echo $home_color ?>;text-align:center;" ><a href="delete-account.php" class="btn btn-danger" >Delete Account</a></td>
				</tr>
			</table>
			<br><br>
		</div>
		<div class="right" >
			<h1 style="text-align:center;" >Overall Distribution<h1>
			<canvas id="pieChart" width="500" height="500" style="text-align:center;" />
		</div>
	</div>
	<script>
		PHP = new Object();
		PHP.Home = <?php echo $_SESSION['home'] ?>;
		PHP.Balance_net = "<?php echo $net_balance ?>";
		PHP.Balance_cash = "<?php echo $cash_balance ?>";
		PHP.Balance_debt = "<?php echo $debt_balance ?>";
		PHP.Balance_receivables = "<?php echo $receivables_balance ?>";
		PHP.Color_home = "<?php echo $home_color ?>";
	</script>
	<script src="js/home.js"></script>
</body>
<?php
	$_SESSION['home'] = "false";
?>
</html>