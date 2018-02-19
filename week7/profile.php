<!doctype HTML>
<?php
    include_once './functions/logged-in.php';
?>
<html>
<head>
	<title>Profile - <?php echo filter_input(INPUT_GET, 'profile') ?></title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
	<link rel="stylesheet" href="css/jquery.datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<script src="js/money.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.datetimepicker.full.js"></script>
</head>
<body>
	<script>
		var graph_data = new Array();
		i = 0;
	</script>
	<?php
	    include_once './functions/dbconnect.php';
	    include_once './functions/functions.php';
		
	    $db = dbconnect();
		
		$uname = $_SESSION['uname'];
		$account_number = (int)filter_input(INPUT_GET, 'account');
		$profile = filter_input(INPUT_GET, 'profile');
	    
	    $stmt = $db->prepare("SELECT * FROM tabs WHERE uname = :uname AND account_number = :account_number");
	    
		$binds = array(
			":uname" => $uname,
			":account_number" => $account_number
		);
	    
		$result = array();
		if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$balance = 0;
			$pos = "#000";
			$neg = "#bb0000";
			$deposit_name = "Deposit";
			$withdrawal_name = "Withdrawal";
			if ($result['type'] == 1) {	// Debt Account. ##
				$pos = "#bb0000";
				$neg = "#000";
				$deposit_name = "Purchase";
				$withdrawal_name = "Payment";
			}
			
			$stmt = $db->prepare("SELECT * FROM transactions WHERE uname = :uname AND account_number = :account_number ORDER BY time_when");
			
			$binds = array(
				":uname" => $uname,
				":account_number" => $account_number
			);
			
			$trans_results = array();
			if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				$trans_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		} else {
			header('Location: home.php');
		}
		
		if (isPostRequest()) {
			$uname = $_SESSION['uname'];
            $account_number = (int)filter_input(INPUT_GET, 'account');
			$deposit = "null";
			$withdrawal = "null";
			$transfer = "null";
			$time_when = filter_input(INPUT_POST, 'n_date');
			if (filter_input(INPUT_POST, 'n_deposit')) {
				$deposit = filter_input(INPUT_POST, 'n_deposit');
			}
			if (filter_input(INPUT_POST, 'n_withdrawal')) {
				$withdrawal = filter_input(INPUT_POST, 'n_withdrawal');
			}
			if (filter_input(INPUT_POST, 'n_transfer')) {
				$transfer = filter_input(INPUT_POST, 'n_transfer');
			}
			
			$sql = "INSERT INTO transactions (uname, account_number, deposit, withdrawal, transfer, time_when) VALUES (:uname, :account_number, ".$deposit.", ".$withdrawal.", ".$transfer.", :time_when)";
			$stmt = $db->prepare($sql);
			
            $binds = array(
                ":uname" => $uname,
                ":account_number" => $account_number,
				":time_when" => $time_when
            );
			
            // Grab data from the database. ##
            $result = array();
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
				header('Location: '.$_SERVER[REQUEST_URI]);
            }
        }
	?>
	<h1 style="background-color:<?php echo $result['bk_color'] ?>;text-align:center;"><a id="link" style="color:<?php echo $result['text_color'] ?>;text-decoration:none;" ><?php echo $profile ?></a><br><b><text id="balance" style="font-size:24px;color:<?php echo $result['money_color'] ?>;" ></text></b></h1>
	<div style="margin-left:8px;margin-right:8px;" >
		<a href="home.php" class="btn btn-success" style="float:left;" > ◄ Home</a>
		<br><br>
		<div><canvas id="lineGraph" width="29" height="12" /></div>
		<br>
		<center>
			<table border="1" cellpadding="4" style="border:#000;" >
				<thead>
					<tr style="background-color:<?php echo $result['bk_color'] ?>;color:<?php echo $result['text_color'] ?>" >
						<th style="text-align:center;width:120px;" >Balance</th>
						<th style="text-align:center;" ><?php echo $deposit_name ?>s</th>
						<th style="text-align:center;" ><?php echo $withdrawal_name ?>s</th>
						<th style="text-align:center;" >Transfers</th>
						<th style="text-align:center;" >Date</th>
						<th style="text-align:center;" >Year</th>
						<th style="text-align:center;" >Edit</th>
						<th style="text-align:center;" >Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($trans_results as $row): ?>
						<tr style="background-color:#efefef;" >
							<?php $balance += ($row['deposit'] + $row['withdrawal'] + $row['transfer']); ?>
							<script>
								graph_data[i] = <?php echo $balance ?>;
								graph_data[i] = Math.round(100*graph_data[i])/100;
								i++;
							</script>
							<td style="text-align:right;color:<?php if($balance<-0.001) echo $neg; else echo $pos; ?>;" ><script>document.write(moneyFormat('<?php echo $balance ?>'))</script></td>
							<td style="text-align:right;color:<?php echo $pos ?>;" ><script>document.write(moneyFormat('<?php echo $row['deposit'] ?>'))</script></td>
							<td style="text-align:right;color:<?php echo $neg ?>;" ><script>document.write(moneyFormat('<?php echo $row['withdrawal'] ?>'))</script></td>
							<td style="text-align:right;color:<?php if($row['transfer']<-0.001) echo $neg; else echo $pos; ?>"; ><script>document.write(moneyFormat('<?php echo $row['transfer'] ?>'))</script></td>
							<td style="text-align:center;" ><?php echo date_format(date_create($row['time_when']), 'm-d-Y h:i:s a') ?> </td>
							<td style="text-align:center;" >1</td>
                                                        <td style="text-align:center;" ><a href="updateTransaction.php?id=<?php echo $row['id']?>">Edit</a></td>
                                                        <td style="text-align:center;" ><a href="delete-profile.php" >Delete</a></td>
						</tr>
					<?php endforeach; ?>
					<form method="post" action="#" > <!-- Start Form -->
						<tr style="background-color:#fff2cc;" >
							<td style="background-color:#efefef;text-align:right;color:<?php if($balance<-0.001) echo $neg; else echo $pos; ?>;" ><text id="new_balance" ></text></td>
							<td><input type="textbox" id="ipt1" class="field-profile" style="border:0;outline:none;" required />
							<input type="hidden" id="num1" name="n_deposit" /></td>
							<td><input type="textbox" id="ipt2" class="field-profile" style="border:0;outline:none;" required disabled />
							<input type="hidden" id="num2" name="n_withdrawal" /></td>
							<td><input type="textbox" id="ipt3" class="field-profile" style="border:0;outline:none;" required disabled />
							<input type="hidden" id="num3" name="n_transfer" /></td>
							<td style="text-align:center;" ><input type="textbox" id="timein" class="field-profile" style="text-align:center;width:220px;border:0;outline:none;" required >
							<input type="hidden" id="date" name="n_date" /></td>
							<td style="background-color:#efefef;text-align:center;" >0</td>
							<td style="background-color:#efefef;text-align:center;" ></td>
							<td style="background-color:#efefef;text-align:center;" ></td>
						</tr>
						<tr style="background-color:#efefef;" >
							<td style="text-align:center;" ><input type="submit" id="add" class="btn btn-default" value="Add" disabled /></td>
							<td style="text-align:center;" ><input type="radio" name="add" id="chk_deposit" style="width:20px;height:20px;" checked /> <?php echo $deposit_name ?></td>
							<td style="text-align:center;" ><input type="radio" name="add" id="chk_withdrawal" style="width:20px;height:20px;" /> <?php echo $withdrawal_name ?></td>
							<td style="text-align:center;" ><input type="radio" name="add" id="chk_transfer" style="width:20px;height:20px;" /> Transfer</td>
							<td style="text-align:center;" ><input type="checkbox" name="date" id="chk_today" style="width:20px;height:20px;" /> Today</td>
							<td style="text-align:center;" ></td>
							<td style="text-align:center;" ></td>
							<td style="text-align:center;" ></td>
						</tr>
					</form> <!-- End Form -->
				</tbody>
			</table>
		</center>
		<br><br>
		<table border="1" cellpadding="4" style="border:#000;" >
			<tr>
				<th style="background-color:#434343;color:#fff;text-align:center;" >Settings</th>
			</tr>
			<tr>
				<td style="background-color:#434343;text-align:center;" ><a href="delete-profile.php?account=<?php echo $account_number ?>" class="btn btn-danger" >Delete Profile</a></td>
			</tr>
		</table>
	</div>
	<br><br><br><br>
	<script>
		// FROM 'money.js': Define Text Fields and Value Holders. ##
		styleDollar("ipt1", "num1", "+", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
		styleDollar("ipt2", "num2", "-", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
		styleDollar("ipt3", "num3", "", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
		
		// FROM 'profile.js': Profile Object PHP Values. ##
		PHP = new Object();
		PHP.Link = "<?php echo $result['link'] ?>";
		PHP.Balance = "<?php echo $balance ?>";
		PHP.Pos = "<?php echo $pos ?>";
		PHP.Neg = "<?php echo $neg ?>";
		PHP.Profile = "<?php echo $profile ?>";
		PHP.Color_bk = "<?php echo $result['bk_color'] ?>";
	</script>
	<script src="js/profile.js"></script>
</body>
</html>
