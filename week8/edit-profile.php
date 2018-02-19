<!doctype HTML>
<?php include_once './functions/logged-in.php' ?>
<html>
<head>
	<title>Update Profile</title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<script src="js/jquery.js"></script>
</head>

<body>
    <?php
        include_once './functions/dbconnect.php';
        include_once './functions/functions.php';
        
        $db = dbconnect();
        
        $account_number = filter_input(INPUT_GET, 'account');
        
        $name = '';
		$type = '';
        $high = '';
		$low = '';
		$bk_color = '';
		$text_color = '';
		$money_color = '';
		$link = '';

        if (isPostRequest()) {
			$name = filter_input(INPUT_POST, 'n_name');
                        $type = filter_input(INPUT_POST, 'n_type');
			$high = filter_input(INPUT_POST, 'n_high');
			$low = filter_input(INPUT_POST, 'n_low');
			$bk_color = filter_input(INPUT_POST, 'n_bk');
			$text_color = filter_input(INPUT_POST, 'n_text');
			$money_color = filter_input(INPUT_POST, 'n_money');
			$link = filter_input(INPUT_POST, 'n_link');
            
			$stmt = $db->prepare("UPDATE tabs SET name = :name, link = :link, type = :type, high_balance = :high_balance, low_balance = :low_balance, bk_color = :bk_color, text_color = :text_color, money_color = :money_color WHERE uname = :uname AND account_number = :account_number");
			
			$binds = array(
                                ":account_number" => $account_number,
				":uname" => $_SESSION['uname'],
				":name" => $name,
				":type" => $type,
				":high_balance" => $high,
				":low_balance" => $low,
				":bk_color" => $bk_color,
				":text_color" => $text_color,
				":money_color" => $money_color,
				":link" => $link
			);
                       
			
			// Grab data from the database. ##
			$result = array();
			if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				header('Location: profile.php?account='.$account_number);
			} else {
				$err = "Update was unsuccessful!";
			}
        }
        $stmt = $db->prepare("SELECT * FROM tabs where account_number = :account_number");

        $binds = array(
            ":account_number" => $account_number
                
        );

        $result = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $uname = $result['uname'];
            $name = $result['name'];
            $type = $result['type'];
            $low_balance = $result['low_balance'];
            $high_balance = $result['high_balance'];
            $bk_color = $result['bk_color'];
            $text_color = $result['text_color'];
            $money_color = $result['money_color'];
            $link = $result['link'];


           
        } else {
            header('Location: home.php');
            
        }
        
        
    ?>
    <br><br><br><br>
	<div id="content-create">
		<form method="post" action="#">
			<h1 class="title" style="text-align:center;" > Update Profile</h1>

                        <input type="text" class="field" name="n_name" placeholder="Name" value="<?php echo $name ?>" autocomplete="off" style="text-align:center;" required autofocus /><br>
			<input type="text" class="field" name="n_link" placeholder="Link to Sign in" value="<?php echo $link ?>" autocomplete="off" style="text-align:center;" /><br><br>
			<select class="field" name="n_type" style="text-align:center;" >
				<option value="0" >Cash</option>
				<option value="1" >Debt</option>
				<option value="2" >Receivable</option>
			</select><br><br>
			<input type="color" id="bk" class="field" name="n_bk" value="<?php echo $bk_color ?>" style="width:30px;" /> Background Color<br><br>
			<input type="color" id="text" class="field" name="n_text" value="<?php echo $text_color ?>" style="width:30px;" /> Text Color<br><br>
			<input type="color" id="money" class="field" name="n_money" value="<?php echo $money_color ?>" style="width:30px;" /> Money Color<br><br>
			<center>
			<table class="color_display" border="1" cellpadding="4" >
				<tr>
					<td id="s_name" >Sample</td>
					<td id="s_money" >$123,456.78</td>
				</tr>
			</table>
			<input type="button" value="Test" onclick="updateSample()" />
			</center>
			<br>
			<input type="text" id="ipt1" class="field" placeholder="High Balance" autocomplete="off" value="<?php echo $high_balance ?>" style="text-align:center;" required /><br>
			<input type="hidden" id="num1" name="n_high" required >
			<input type="text" id="ipt2" class="field" placeholder="Low Balance" autocomplete="off" value="<?php echo $low_balance ?>" style="text-align:center;" required /><br>
			<input type="hidden" id="num2" name="n_low" required >
			<br>
			<input type="text" class="error" value="<?php echo $err ?>" readonly /><br>
			<br>
			<input id="buttonSubmit" class="sbtn" type="submit" value="Update" />
		</form>
		<a href="home.php" style="float:right;" > ◄ Home</a>
	</div>
</body>

<script src="js/money.js"></script>
<script type="text/javascript">
	styleDollar("ipt1", "num1", "", "#000", "#bb0000", "$0.00", true);
	styleDollar("ipt2", "num2", "", "#000", "#bb0000", "$0.00", true);
	updateSample();
	
	function updateSample() {
		var bk = $("#bk").val();
		var text = $("#text").val();
		var money = $("#money").val();
		var style = "background-color:"+bk+";color:"+text+";";
		document.getElementById("s_name").style = style;
		style = "background-color:"+bk+";color:"+money+";";
		document.getElementById("s_money").style = style;
	}
</script>
</html>