<!doctype HTML>
<?php
    session_start();
?>
<html>
<head>
	<title>Success</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous" />
	
</head>
<body>
    <br><br><br><br><br>
    <?php
        //* 
        include './functions/dbconnect.php';
        include_once './functions/functions.php';
    
        
        $db = dbconnect();
        
        $id = filter_input(INPUT_GET, 'id');
        //$uname = '';
        //$account_number = '';
        $deposit = '';
        $withdrawal = '';
        $transfer = '';
        $time_when = '';

        if (isPostRequest()) {
            $account_number = $_SESSION['account_number'];
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
                ":uname" => $_SESSION['uname'],
                ":account_number" => $account_number,
                ":deposit" => $deposit,
                ":withdrawal" => $withdrawal,
                ":transfer" => $transfer,
                ":time_when" => $time_when
            );
            
            echo "1: ".$id."<br>"; 
            echo "2: ".$_SESSION['uname']."<br>"; 
            echo "3: ".$account_number."<br>"; 
            echo "4: ".$deposit."<br>"; 
            echo "5: ".$withdrawal."<br>"; 
            echo "6: ".$transfer."<br>"; 
            echo "7: ".$time_when."<br>"; 
            //die("here"); 
            
            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                //2017-11-28 21:50:50
                
                header('Location: home.php');
            } else {
                header('Location: error.php');
            }
        }

        $stmt = $db->prepare("SELECT * FROM transactions WHERE id = :id");

        $binds = array(
            ":id" => $id
        );

        $result = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $uname = $result['uname'];
            $_SESSION['account_number'] = $result['account_number'];
            
            $deposit = $result['deposit'];
            $withdrawal = $result['withdrawal'];
            $transfer = $result['transfer'];
            $time_when = $result['time_when'];
        } else {
            header('Location: error.php');
        }
        
        ?>
<center>
    <table border="1" cellpadding="4" style="border:#000;" >
        <thead>
            <tr>
                <th></th>
                <th>Deposit</th>
                <th>Withdrawal</th>
                <th>Transfer</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <form action="#" method="POST" >
            <tr style="background-color:#efefef;" >
                <td></td>
                <td><input type="textbox" id="ipt1" value="<?php echo $deposit ?>" class="field-profile" style="border:0;outline:none;" required />
                <input type="text" id="num1" value="<?php echo $deposit ?>" name="n_deposit" /></td>
                <td><input type="textbox" id="ipt2" class="field-profile" style="border:0;outline:none;" required disabled />
                <input type="text" id="num2" name="n_withdrawal" /></td>
                <td><input type="textbox" id="ipt3" class="field-profile" style="border:0;outline:none;" required disabled />
                <input type="text" id="num3" name="n_transfer" /></td>
                <td style="text-align:center;" ><input type="textbox" id="timein" class="field-profile" style="text-align:center;width:220px;border:0;outline:none;" required >
                <input type="text" id="date" name="n_date" /></td>
            </tr>
            <tr style="background-color:#efefef;" >
                <td style="text-align:center;" ><input type="submit" id="add" class="btn btn-success" value="Add" /></td>
                <td style="text-align:center;" ><input type="radio" name="add" id="chk_deposit" style="width:20px;height:20px;" checked /> Deposit</td>
                <td style="text-align:center;" ><input type="radio" name="add" id="chk_withdrawal" style="width:20px;height:20px;" /> Withdrawal</td>
                <td style="text-align:center;" ><input type="radio" name="add" id="chk_transfer" style="width:20px;height:20px;" /> Transfer</td>
                <td style="text-align:center;" ><input type="checkbox" name="date" id="chk_today" style="width:20px;height:20px;" /> Today</td>
            </tr>
            </form>
        </tbody>
    </table>
    </center>
</body>
</html>