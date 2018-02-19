<!doctype HTML>
<?php include_once './functions/logged-in.php' ?>
<html>
<head>
	<title>Edit - <?php echo $_SESSION['name'] ?></title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
	<link rel="stylesheet" href="css/jquery.datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<script src="js/money.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.datetimepicker.full.js"></script>
</head>
<body>
    <?php
        include './functions/dbconnect.php';
        include_once './functions/functions.php';
    
        $db = dbconnect();
        
        $id = filter_input(INPUT_GET, 'id');
        $uname = $_SESSION['uname'];
        $account_number = $_SESSION['account_number'];
        $deposit = '';
        $withdrawal = '';
        $transfer = '';
        $time_when = '';
		
		$pos = "#000";
		$neg = "#bb0000";
		$deposit_name = "Deposit";
		$withdrawal_name = "Withdrawal";
		if ($_SESSION['type'] == 1) {	// Debt Account. ##
			$pos = "#bb0000";
			$neg = "#000";
			$deposit_name = "Purchase";
			$withdrawal_name = "Payment";
		}

        if (isPostRequest()) {
            $deposit = filter_input(INPUT_POST, 'n_deposit');
            $withdrawal = filter_input(INPUT_POST, 'n_withdrawal');
            $transfer = filter_input(INPUT_POST, 'n_transfer');
            
            if ($deposit == '') {
                $deposit = null;
            }
            if ($withdrawal == '') {
                $withdrawal = null;
            }
            if ($transfer == '') {
                $transfer = null;
            }
            $time_when = filter_input(INPUT_POST, 'n_date');

            $stmt = $db->prepare("UPDATE transactions SET deposit = :deposit, withdrawal = :withdrawal, transfer = :transfer, time_when = :time_when WHERE uname = :uname AND account_number = :account_number AND id = :id");

            $binds = array(
                ":id" => $id,
                ":uname" => $uname,
                ":account_number" => $account_number,
                ":deposit" => $deposit,
                ":withdrawal" => $withdrawal,
                ":transfer" => $transfer,
                ":time_when" => $time_when
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				header('Location: profile.php?account='.$account_number);
            } else {
                header('Location: error.php');
            }
        } else {
			$stmt = $db->prepare("SELECT * FROM transactions WHERE uname = :uname AND account_number = :account_number AND id = :id");

			$binds = array(
				":id" => $id,
				":uname" => $uname,
				":account_number" => $account_number
			);

			$result = array();
			if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				
				$deposit = $result['deposit'];
				$withdrawal = $result['withdrawal'];
				$transfer = $result['transfer'];
				$time_when = $result['time_when'];
			} else {
				header('Location: home.php');
			}
		}
    ?>
	<h1 style="background-color:#ffc107;text-align:center;"><a id="link" style="color:#000;text-decoration:none;" >Update Transaction</a><br><span style="color:#000;" ><?php echo $_SESSION['name'] ?></span></h1>
	<div style="margin-left:8px;margin-right:8px;" >
		<a href="profile.php?account=<?php echo $_SESSION['account_number'] ?>" class="btn btn-info tableFont" style="float:left;" > ◄ Profile</a>
		<br><br>
		<center>
		<form action="#" method="POST" >
		<table border="1" cellpadding="4" class="tableFont" style="border:#000;" >
			<thead>
				<tr style="background-color:<?php echo $_SESSION['bk_color'] ?>;color:<?php echo $_SESSION['text_color'] ?>;">
					<th style="border-color:#000;text-align:center;width:120px;" ><?php echo $_SESSION['name'] ?></th>
					<th style="border-color:#000;text-align:center;" ><?php echo $deposit_name ?></th>
					<th style="border-color:#000;text-align:center;" ><?php echo $withdrawal_name ?></th>
					<th style="border-color:#000;text-align:center;" >Transfer</th>
					<th style="border-color:#000;text-align:center;" >Date</th>
				</tr>
			</thead>
			<tbody>
				<tr style="background-color:#fff2cc;" >
					<td style="background-color:#efefef;" ></td>
					<td><input type="textbox" id="ipt1" class="field-profile" style="border:0;outline:none;color:<?php if($balance<-0.001) echo $pos; else echo $neg; ?>;" /></td>
					<input type="hidden" id="num1" name="n_deposit" value="<?php echo $deposit ?>" />
					<td><input type="textbox" id="ipt2" class="field-profile" style="border:0;outline:none;color:<?php if($balance<-0.001) echo $neg; else echo $pos; ?>;" /></td>
					<input type="hidden" id="num2" name="n_withdrawal" value="<?php echo $withdrawal ?>" />
					<td><input type="textbox" id="ipt3" class="field-profile" style="border:0;outline:none;color:<?php if($balance<-0.001) echo $pos; else echo $neg; ?>;" /></td>
					<input type="hidden" id="num3" name="n_transfer" value="<?php echo $transfer ?>" />
					<td style="text-align:center;" ><input type="textbox" id="timein" class="field-profile" style="text-align:center;width:220px;border:0;outline:none;" /></td>
					<input type="hidden" id="date" name="n_date" value="<?php echo $time_when ?>" />
				</tr>
				<tr style="background-color:#efefef;" >
					<td style="text-align:center;" ><input type="submit" id="sub_btn" class="btn btn-default" value="Update" disabled /></td>
					<td style="text-align:center;" ><input type="radio" name="add" id="chk_deposit" /> <?php echo $deposit_name ?></td>
					<td style="text-align:center;" ><input type="radio" name="add" id="chk_withdrawal" /> <?php echo $withdrawal_name ?></td>
					<td style="text-align:center;" ><input type="radio" name="add" id="chk_transfer" /> Transfer</td>
					<td style="text-align:center;" ><input type="checkbox" name="date" id="chk_today" /> Today</td>
				</tr>
			</tbody>
		</table>
		</form>
		</center>
	</div>
	<script>        
		// FROM 'profile.js': Profile Object PHP Values. ##
		PHP = {};
		PHP.Pos = "<?php echo $pos ?>";
		PHP.Neg = "<?php echo $neg ?>";
	</script>
	<script src="js/edit-transaction.js"></script>
</body>
</html>