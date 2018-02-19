<!doctype HTML>
<?php
//include_once './functions/mail.php';

include_once './functions/logged-in.php';

include_once './functions/dbconnect.php';
include_once './functions/functions.php';

$db = dbconnect();

$uname = $_SESSION['uname'];
$account_number = (int) filter_input(INPUT_GET, 'account');

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
if ($result['type'] == 1) { // Debt Account. ##
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

        <script src="js/money.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/jquery.datetimepicker.full.js"></script>
    </head>
    <body>
        <script>
            var graph_data = [];
            i = 0;
        </script>
        <?php
        if (isPostRequest()) {
        $uname = $_SESSION['uname'];
        $account_number = (int) filter_input(INPUT_GET, 'account');
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
        <h1 style="font-family:Verdana;background-color:<?php echo $result['bk_color'] ?>;text-align:center;"><b><a id="link" style="color:<?php echo $result['text_color'] ?>;text-decoration:none;" ><?php echo $profile ?></a></b><br><span id="balance" class="tableFont" style="font-size:24px;color:<?php echo $result['money_color'] ?>;" >Loading...</span></h1>
        <div style="margin-left:8px;margin-right:8px;" >
            <a href="home.php" class="btn btn-info tableFont" style="float:left;" > ◄ Home</a>
            <div><canvas id="lineGraph" width="29" height="12" /></div>
            <br>
            <center>
                <form method="post" action="#" > <!-- Start Form -->
                    <table border="1" cellpadding="4" class="tableFont" >
                        <thead>
                            <tr style="background-color:<?php echo $result['bk_color'] ?>;color:<?php echo $result['text_color'] ?>;" >
                                <th style="border-color:#000;text-align:center;width:120px;" >Balance</th>
                                <th style="border-color:#000;text-align:center;" ><?php echo $deposit_name ?>s</th>
                                <th style="border-color:#000;text-align:center;" ><?php echo $withdrawal_name ?>s</th>
                                <th style="border-color:#000;text-align:center;" >Transfers</th>
                                <th style="border-color:#000;text-align:center;" >Date</th>
                                <th style="border-color:#000;text-align:center;" >Year</th>
                                <th style="border-color:#000;text-align:center;" >Edit</th>
                                <th style="border-color:#000;text-align:center;" >Delete</th>
                            </tr>
                        </thead>
                        <tbody style = "height:200px; overflow-y:auto; width: 100%;">
                            <?php foreach ($trans_results as $row): ?>
                            <tr style="background-color:#efefef; " >
                                <?php $balance += ($row['deposit'] + $row['withdrawal'] + $row['transfer']); ?>
                        <script>
                            graph_data[i] = <?php echo $balance ?>;
                            graph_data[i] = Math.round(100 * graph_data[i]) / 100;
                            i++;
                        </script>
                        <td style="border-color:#000;text-align:right;color:<?php if($balance<-0.001) echo $neg;
                                else echo $pos; ?>;" ><script>document.write(moneyFormat('<?php echo $balance ?>'))</script></td>
                        <td style="border-color:#000;text-align:right;color:<?php echo $pos ?>;" ><script>document.write(moneyFormat('<?php echo $row['deposit'] ?>'))</script></td>
                        <td style="border-color:#000;text-align:right;color:<?php echo $neg ?>;" ><script>document.write(moneyFormat('<?php echo $row['withdrawal'] ?>'))</script></td>
                        <td style="border-color:#000;text-align:right;color:<?php if($row['transfer']<-0.001) echo $neg;
                                else echo $pos; ?>"; ><script>document.write(moneyFormat('<?php echo $row['transfer'] ?>'))</script></td>
                        <td style="border-color:#000;text-align:center;" ><?php echo date_format(date_create($row['time_when']), 'm-d-Y h:i:s a') ?> </td>
                        <td style="border-color:#000;text-align:center;" >1</td>
                        <td style="border-color:#000;text-align:center;" ><a href="edit-transaction.php?id=<?php echo $row['id'] ?>" style="height:20px;color:#06f;" >Edit</a></td>
                        <td style="border-color:#000;text-align:center;" ><a href="delete-transaction.php?id=<?php echo $row['id'] ?>" style="height:20px;color:#dc3545;" >Delete</a></td>
                        </tr>
<?php endforeach; ?>
                        <tr style="background-color:#fff2cc;" >
                            <td style="border-color:#000;background-color:#efefef;text-align:right;color:<?php if($balance<-0.001) echo $neg;
else echo $pos; ?>;" ><span id="new_balance" ></span></td>
                            <td style="border-color:#000;" ><input type="textbox" id="ipt1" class="field-profile" style="border:0;outline:none;" disabled /></td>
                        <input type="hidden" id="num1" name="n_deposit" />
                        <td style="border-color:#000;" ><input type="textbox" id="ipt2" class="field-profile" style="border:0;outline:none;" disabled /></td>
                        <input type="hidden" id="num2" name="n_withdrawal" />
                        <td style="border-color:#000;" ><input type="textbox" id="ipt3" class="field-profile" style="border:0;outline:none;" disabled /></td>
                        <input type="hidden" id="num3" name="n_transfer" />
                        <td style="border-color:#000;text-align:center;" ><input type="datetime" id="timein" class="field-profile" autocomplete="off" style="text-align:center;width:220px;border:0;outline:none;" /></td>
                        <input type="hidden" id="date" name="n_date" />
                        <td style="border-color:#000;background-color:#efefef;text-align:center;" >0</td>
                        <td style="border-color:#000;background-color:#efefef;text-align:center;" ></td>
                        <td style="border-color:#000;background-color:#efefef;text-align:center;" ></td>
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
                        </tr>
                        </tbody>
                    </table>
                </form> <!-- End Form -->
            </center>
            <br><br>
            <table border="1" cellpadding="4" class="tableFont" style="border:#000;" >
                <tr>
                    <th style="border-color:#000;background-color:#434343;color:#fff;text-align:center;" >Settings</th>
                </tr>
                <tr>
                    <td style="border-color:#000;background-color:#434343;text-align:center;" ><a href="edit-profile.php?account=<?php echo $account_number ?>" class="btn btn-primary" >Update Profile</a></td>
                </tr>
                <tr>
                    <td style="border-color:#000;background-color:#434343;text-align:center;" ><a href="delete-profile.php?account=<?php echo $account_number ?>" class="btn btn-danger" >Delete Profile</a></td>
                    <!--td style="background-color:#434343;text-align:center;" ><a href="error.php?msg=<?php echo $msg ?>&items=<?php print_r($result) ?>" class="btn btn-danger" >ERR</a></td-->
                </tr>
            </table>
            <br><br>
        </div>
        <script>
            // FROM 'money.js': Define Text Fields and Value Holders. ##
            styleDollar("ipt1", "num1", "+", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
            styleDollar("ipt2", "num2", "-", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);
            styleDollar("ipt3", "num3", "", "<?php echo $pos ?>", "<?php echo $neg ?>", "$0.00", true);

            function type(a) {
                var r = "Unknown";
                if (a == 0) {
                    r = "Cash";
                } else if (a == 1) {
                    r = "Debt";
                } else if (a == 2) {
                    r = "Receivables";
                }
                return "Type: " + r;
            }

            // FROM 'profile.js': Profile Object PHP Values. ##
            PHP = {};
            PHP.Link = "<?php echo $result['link'] ?>";
            PHP.Balance = "<?php echo $balance ?>";
            PHP.Pos = "<?php echo $pos ?>";
            PHP.Neg = "<?php echo $neg ?>";
            PHP.Type = type(<?php echo $result['type'] ?>);
            PHP.Color_graph = "<?php echo $graph_color ?>";
        </script>
        <script src="js/profile.js"></script>
    </body>
</html>
