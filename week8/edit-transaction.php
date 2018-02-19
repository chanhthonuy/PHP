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
	<h1 style="background-color:#06f;text-align:center;"><a id="link" style="color:#fff;text-decoration:none;" >Update Transaction</a><br><span style="color:#fff;" ><?php echo $_SESSION['name'] ?></span></h1>
	<div style="margin-left:8px;margin-right:8px;" >
		<a href="profile.php?account=<?php echo $_SESSION['account_number'] ?>" class="btn btn-info tableFont" style="float:left;" > ◄ Profile</a>
		<br><br>
		<center>
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
				<form action="#" method="POST" >
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
				</form>
			</tbody>
		</table>
		</center>
	</div>
	<script>
		// FROM 'money.js': Define Text Fields and Value Holders. ##
		styleDollar("ipt1", "num1", "+", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
		styleDollar("ipt2", "num2", "-", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
		styleDollar("ipt3", "num3", "", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
		
		// On Load. ##
		$("#timein").datetimepicker({
			format: "m-d-Y H:00:00"
		});
		
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
			
		$("#timein").blur(function() {
			var v = new Date(this.value);
			//v.setHours(v.getHours(), v.getMinutes(), 0);
			var d = $("#date");
			var t = addZero(v.getMonth()+1)+"-"+addZero(v.getDate())+"-"+v.getFullYear()+" "+hours(v.getHours())+":"+addZero(v.getMinutes())+":"+addZero(v.getSeconds())+" "+ampm(v.getHours());
			var n = v.getFullYear()+"-"+(v.getMonth()+1)+"-"+v.getDate()+" "+v.getHours()+":"+v.getMinutes()+":"+v.getSeconds();
			if (n.includes("NaN")) {
				d.val(null);
				this.value = null;
			} else {
				d.val(n);
				this.value = t;
			}
			valAdd();
		});
		$("#chk_today").change(function() {
			var a = this.checked;
			var f = $("#timein");
			var d = $("#date");
			var t = new Date();
			var n = "";
			if (a) {
				n = t.getFullYear()+"-"+(t.getMonth()+1)+"-"+t.getDate()+" "+t.getHours()+":"+t.getMinutes()+":"+t.getSeconds();
				t = addZero(t.getMonth()+1)+"-"+addZero(t.getDate())+"-"+t.getFullYear()+" "+hours(t.getHours())+":"+addZero(t.getMinutes())+":"+addZero(t.getSeconds())+" "+ampm(t.getHours());
				d.val(n);
				f.val(t);
				f.prop("disabled", true);
			} else {
				f.val("");
				d.val(null);
				f.prop("disabled", false);
			}
			valAdd();
		});
		
		$("#chk_deposit, #chk_withdrawal, #chk_transfer").change(function() {
			if (this.id == "chk_deposit") {
				a = $("#ipt1");
				b = $("#ipt2");
				c = $("#ipt3");
				x = $("#num2");
				y = $("#num3");
			} else if (this.id == "chk_withdrawal") {
				a = $("#ipt2");
				b = $("#ipt1");
				c = $("#ipt3");
				x = $("#num1");
				y = $("#num3");
			} else if (this.id == "chk_transfer") {
				a = $("#ipt3");
				b = $("#ipt1");
				c = $("#ipt2");
				x = $("#num1");
				y = $("#num2");
			}
			a.prop("disabled", false);
			b.prop("disabled", true);
			c.prop("disabled", true);
			b.val(null);
			c.val(null);
			b.attr('placeholder','');
			c.attr('placeholder','');
			x.val("");
			y.val("");
			valAdd();
		});
		function valAdd() {
			var n1 = $("#num1").val();
			var n2 = $("#num2").val();
			var n3 = $("#num3").val();
			var d = $("#date").val();
			var b = $("#sub_btn");
			var ready = false;
			if (d != "") {
				if (n1 + n2 + n3 != 0) {
					ready = true;
				}
			}
			if (ready) {
				b.prop("disabled", false);
				b.attr('class', 'btn btn-primary');
			} else {
				b.prop("disabled", true);
				b.attr('class', 'btn btn-default');
			}
		}
		
		$("#ipt1, #ipt2, #ipt3").blur(function() {
			valAdd();
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
		
		valAdd();
	</script>
</body>
</html>