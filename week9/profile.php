<!doctype HTML>
<?php
    include_once './functions/logged-in.php';
	
	include_once './functions/dbconnect.php';
	include_once './functions/functions.php';
	
	$db = dbconnect();
	
	$uname = $_SESSION['uname'];
	$account_number = (int)filter_input(INPUT_GET, 'account');
	
	$_SESSION['account_number'] = $account_number;
	
	$stmt = $db->prepare("SELECT * FROM tabs WHERE uname = :uname AND account_number = :account_number");
	
	$binds = array(
		":uname" => $uname,
		":account_number" => $account_number
	);
	
	$result = array();
	if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$balance = 0;
        
		$profile = $result['name'];
        $high_bal = $result['high_balance'];
        $low_bal = $result['low_balance'];
		$_SESSION['type'] = $result['type'];
		$_SESSION['bk_color'] = $result['bk_color'];
		$_SESSION['text_color'] = $result['text_color'];
		$_SESSION['name'] = $profile;
		$graph_color = $result['bk_color'];
		if ($graph_color == "#ffffff") {
			$graph_color = $result['text_color'];
		}
		
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
?>
<html>
<head>
	<title>Profile - <?php echo $profile ?></title>
	<link rel="shortcut icon" href="imgs/fav.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
	<link rel="stylesheet" href="css/jquery.datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/profile.css"/>
	
	<script src="js/money.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.datetimepicker.full.js"></script>
         <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<script>
		var graph_data = [];
		i = 0;
	</script>
	<?php
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
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
				header('Location: '.$_SERVER[REQUEST_URI]);
            } else {
				header('Location: error.php');
			}
        }
	?>
	<h1 style="font-family:Verdana;background-color:<?php echo $result['bk_color'] ?>;text-align:center;"><b><a id="link" style="color:<?php echo $result['text_color'] ?>;text-decoration:none;" ><?php echo $profile ?></a></b><br><span id="balance" class="tableFont" style="font-size:24px;font-weight:bold;color:<?php echo $result['money_color'] ?>;" >Loading...</span></h1>
	<div style="margin-left:8px;margin-right:8px;" >
        <a href="home.php" class="btn btn-info tableFont" style="float:left;" >◄ Home</a>
        <div><canvas id="lineGraph" width="29" height="12" /></div>
        <br>
        <div style="width:1220px;margin:auto;overflow:auto;" >
            <div class="left" >
                <table border="1" cellpadding="4" class="tableFont" >
                    <tr style="background-color:<?php echo $result['bk_color'] ?>;color:<?php echo $result['text_color'] ?>;" >
                        <th style="border-color:#000;text-align:center;width:120px;" >Balance</th>
                        <th style="border-color:#000;text-align:center;width:130px;" ><?php echo $deposit_name ?>s</th>
                        <th style="border-color:#000;text-align:center;width:130px;" ><?php echo $withdrawal_name ?>s</th>
                        <th style="border-color:#000;text-align:center;width:130px;" >Transfers</th>
                        <th style="border-color:#000;text-align:center;width:230px;" >Date</th>
                        <th style="border-color:#000;text-align:center;width:60px;" >Year</th>
                        <th style="border-color:#000;text-align:center;width:70px;" >Edit</th>
                        <th style="border-color:#000;text-align:center;width:80px;" >Delete</th>
                        <th style="border-color:#000;width:17px;" ></th>
                    </tr>
                </table>
                <div style="max-height:496px;width:968px;overflow:auto;overflow-x:hidden;overflow-y:scroll;" >
                <table border="1" cellpadding="4" class="tableFont" >
                    <?php foreach ($trans_results as $row): ?>
                        <tr style="background-color:#efefef;" >
                            <?php $balance += ($row['deposit'] + $row['withdrawal'] + $row['transfer']); ?>
                            <script>
                                graph_data[i] = <?php echo $balance ?>;
                                graph_data[i] = Math.round(100*graph_data[i])/100;
                                i++;
                            </script>
                            <td style="border-color:#000;width:120px;text-align:right;color:<?php if($balance<-0.001) echo $neg; else echo $pos; ?>;" ><script>document.write(moneyFormat('<?php echo $balance ?>'))</script></td>
                            <td style="border-color:#000;width:130px;text-align:right;color:<?php echo $pos ?>;" ><script>document.write(moneyFormat('<?php echo $row['deposit'] ?>'))</script></td>
                            <td style="border-color:#000;width:130px;text-align:right;color:<?php echo $neg ?>;" ><script>document.write(moneyFormat('<?php echo $row['withdrawal'] ?>'))</script></td>
                            <td style="border-color:#000;width:130px;text-align:right;color:<?php if($row['transfer']<-0.001) echo $neg; else echo $pos; ?>"; ><script>document.write(moneyFormat('<?php echo $row['transfer'] ?>'))</script></td>
                            <td style="border-color:#000;width:230px;text-align:center;" ><?php echo date_format(date_create($row['time_when']), 'm-d-Y h:i:s a') ?> </td>
                            <td style="border-color:#000;width:60px;text-align:center;" >1</td>
                            <td style="border-color:#000;width:70px;text-align:center;" ><a href="edit-transaction.php?id=<?php echo $row['id'] ?>" class="glyphicon glyphicon-edit" ></a></td>
                            <td style="border-color:#000;width:80px;text-align:center;" ><a href="delete-transaction.php?id=<?php echo $row['id'] ?>" class="glyphicon glyphicon-trash" ></a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                </div>
            </div>
            <div class="right" >
                <table border="1" cellpadding="4" class="tableFont" style="border:#000;width:200px;" >
                    <tr>
                        <th style="border-color:#000;background-color:#434343;color:#fff;text-align:center;" >Settings</th>
                    </tr>
                    <tr>
                        <td style="border-color:#000;background-color:#434343;text-align:center;" ><a href="edit-profile.php" class="btn btn-primary" >Update Profile</a></td>
                    </tr>
                    <tr>
                        <td style="border-color:#000;background-color:#434343;text-align:center;" ><a href="delete-profile.php?account=<?php echo $account_number ?>" class="btn btn-danger" >Delete Profile</a></td>
                    </tr>
                </table>
            </div>
            <form method="post" action="#" >
            <table border="1" cellpadding="4" class="tableFont" style="border:#000;" >
                <tr style="background-color:#fff2cc;" >
                    <td style="border-color:#000;width:120px;background-color:#efefef;text-align:right;color:<?php if($balance<-0.001) echo $neg; else echo $pos; ?>;width:120px;" ><span id="new_balance" ></span></td>
                    <td style="border-color:#000;width:130px;" ><input type="textbox" id="ipt1" class="field-profile" style="border:0;outline:none;" disabled /></td>
                    <input type="hidden" id="num1" name="n_deposit" />
                    <td style="border-color:#000;width:130px;" ><input type="textbox" id="ipt2" class="field-profile" style="border:0;outline:none;" disabled /></td>
                    <input type="hidden" id="num2" name="n_withdrawal" />
                    <td style="border-color:#000;width:130px;" ><input type="textbox" id="ipt3" class="field-profile" style="border:0;outline:none;" disabled /></td>
                    <input type="hidden" id="num3" name="n_transfer" />
                    <td style="border-color:#000;text-align:center;width:230px;" ><input type="datetime" id="timein" class="field-profile" autocomplete="off" style="text-align:center;width:220px;border:0;outline:none;" /></td>
                    <input type="hidden" id="date" name="n_date" />
                    <td style="border-color:#000;background-color:#efefef;text-align:center;width:60px;" >0</td>
                    <td style="border-color:#000;background-color:#efefef;text-align:center;width:70px;" ></td>
                    <td style="border-color:#000;background-color:#efefef;text-align:center;width:80px;" ></td>
                    <td style="border-color:#000;background-color:#efefef;width:17px;" ></td>
                </tr>
                <tr style="background-color:#efefef;" >
                    <td style="border-color:#000;text-align:center;" ><input type="submit" id="sub_btn" class="btn btn-default" value="Add" disabled /></td>
                    <td style="border-color:#000;text-align:center;" ><input type="radio" name="add" id="chk_deposit" /> <?php echo $deposit_name ?></td>
                    <td style="border-color:#000;text-align:center;" ><input type="radio" name="add" id="chk_withdrawal" /> <?php echo $withdrawal_name ?></td>
                    <td style="border-color:#000;text-align:center;" ><input type="radio" name="add" id="chk_transfer" /> Transfer</td>
                    <td style="border-color:#000;text-align:center;" ><input type="checkbox" name="date" id="chk_today" /> Today</td>
                    <td style="border-color:#000;text-align:center;" ></td>
                    <td style="border-color:#000;text-align:center;" ></td>
                    <td style="border-color:#000;text-align:center;" ></td>
                    <td style="border-color:#000;width:17px;" ></td>
                </tr>
            </table>
            </form>
        </div>
	</div>
    <br><br>
	<script>        
		// FROM 'profile.js': Profile Object PHP Values. ##
		PHP = {};
		PHP.Link = "<?php echo $result['link'] ?>";
		PHP.Balance = "<?php echo $balance ?>";
        PHP.High = "<?php echo $high_bal ?>";
        PHP.Low = "<?php echo $low_bal ?>";
		PHP.Pos = "<?php echo $pos ?>";
		PHP.Neg = "<?php echo $neg ?>";
		PHP.Color_graph = "<?php echo $graph_color ?>";
	</script>
	<script src="js/profile.js"></script>
</body>
</html>
