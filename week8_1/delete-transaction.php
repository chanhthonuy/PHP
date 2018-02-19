<!doctype HTML>
<?php include_once './functions/logged-in.php' ?>
<html>
<head>
	<title>Delete - <?php echo $_SESSION['name'] ?></title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<script src="js/money.js"></script>
	<script src="js/jquery.js"></script>
</head>
<body>
    <?php
        include './functions/dbconnect.php';
        include_once './functions/functions.php';
    
        $db = dbconnect();
        
        $id = filter_input(INPUT_GET, 'id');
        $uname = $_SESSION['uname'];
        $account_number = $_SESSION['account_number'];
		
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
            $stmt = $db->prepare("DELETE FROM transactions WHERE uname = :uname AND account_number = :account_number AND id = :id");

            $binds = array(
                ":id" => $id,
                ":uname" => $uname,
                ":account_number" => $account_number
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
	<h1 style="background-color:#dc3545;text-align:center;"><a id="link" style="color:#fff;text-decoration:none;" >Delete Transaction</a><br><span style="color:#fff;" ><?php echo $_SESSION['name'] ?></span></h1>
	<div style="margin-left:8px;margin-right:8px;" >
		<a href="profile.php?account=<?php echo $_SESSION['account_number'] ?>" class="btn btn-info tableFont" style="float:left;" > ◄ Profile</a>
		<br><br>
		<center>
		<table border="1" cellpadding="4" class="tableFont" style="border:#000;" >
			<thead>
				<tr style="background-color:<?php echo $_SESSION['bk_color'] ?>;color:<?php echo $_SESSION['text_color'] ?>;">
					<th style="text-align:center;width:120px;" ><?php echo $_SESSION['name'] ?></th>
					<th style="text-align:center;" ><?php echo $deposit_name ?></th>
					<th style="text-align:center;" ><?php echo $withdrawal_name ?></th>
					<th style="text-align:center;" >Transfer</th>
					<th style="text-align:center;" >Date</th>
				</tr>
			</thead>
			<tbody>
				<form action="#" method="POST" >
				<tr style="background-color:#efefef;" >
					<td></td>
					<td><input type="textbox" id="ipt1" class="field-profile" style="border:0;outline:none;color:<?php if($balance<-0.001) echo $pos; else echo $neg; ?>;" readonly /></td>
					<input type="hidden" id="num1" value="<?php echo $deposit ?>" />
					<td><input type="textbox" id="ipt2" class="field-profile" style="border:0;outline:none;color:<?php if($balance<-0.001) echo $neg; else echo $pos; ?>;" readonly /></td>
					<input type="hidden" id="num2" value="<?php echo $withdrawal ?>" />
					<td><input type="textbox" id="ipt3" class="field-profile" style="border:0;outline:none;color:<?php if($balance<-0.001) echo $pos; else echo $neg; ?>;" readonly /></td>
					<input type="hidden" id="num3" value="<?php echo $transfer ?>" />
					<td style="text-align:center;" ><input type="textbox" id="timein" class="field-profile" style="text-align:center;width:220px;border:0;outline:none;" readonly ></td>
					<input type="hidden" id="date" value="<?php echo $time_when ?>" />
				</tr>
				<tr style="background-color:#efefef;" >
					<td style="text-align:center;" ><input type="submit" class="btn btn-danger" value="Delete" /></td>
					<td style="text-align:center;" ><input type="radio" name="add" id="chk_deposit" style="width:20px;height:20px;" disabled /> <?php echo $deposit_name ?></td>
					<td style="text-align:center;" ><input type="radio" name="add" id="chk_withdrawal" style="width:20px;height:20px;" disabled /> <?php echo $withdrawal_name ?></td>
					<td style="text-align:center;" ><input type="radio" name="add" id="chk_transfer" style="width:20px;height:20px;" disabled /> Transfer</td>
					<td style="text-align:center;" ><input type="checkbox" name="date" id="chk_today" style="width:20px;height:20px;" disabled /> Today</td>
				</tr>
				</form>
			</tbody>
		</table>
		</center>
	</div>
	<script>
		// On Load. ##
		$("#ipt1").prop("disabled", true);
		$("#ipt2").prop("disabled", true);
		$("#ipt3").prop("disabled", true);
		if ($("#num1").val() != '') {
			$("#ipt1").val(moneyFormat($("#num1").val()));
			$("#ipt1").prop("disabled", false);
			$("#chk_deposit").prop("checked", true);
		}
		if ($("#num2").val() != '') {
			$("#ipt2").val(moneyFormat($("#num2").val()));
			$("#ipt2").prop("disabled", false);
			$("#chk_withdrawal").prop("checked", true);
		}
		if ($("#num3").val() != '') {
			$("#ipt3").val(moneyFormat($("#num3").val()));
			$("#ipt3").prop("disabled", false);
			$("#chk_transfer").prop("checked", true);
		}
		$(function() {
			var v = new Date($("#date").val());
			var t = addZero(v.getMonth()+1)+"-"+addZero(v.getDate())+"-"+v.getFullYear()+" "+hours(v.getHours())+":"+addZero(v.getMinutes())+":"+addZero(v.getSeconds())+" "+ampm(v.getHours());
			$("#timein").val(t);
		});
			
		function hours(a) {
			if (a == 0) a = 12;
			if (a > 12) a = a - 12;
			if (a < 10) a = "0" + a;
			return a;
		}
		function addZero(a) {
			if (a < 10) a = "0" + a;
			return a;
		}
		function ampm(a) {
			if (a < 12) return "am"; else return "pm";
		}
	</script>
</body>
</html>