<!doctype HTML>
<html>
<head>
	<title>Error</title>
</head>
<body style="background-color:#000;color:#fff;" >
	<?php
		$msg = filter_input(INPUT_GET, 'msg');
		$items = filter_input(INPUT_GET, 'items');
		if ($msg == '') {
			$msg = 'Unknown Error';
		}
		if ($items == '') {
			$items = 'No items to show';
		}
	?>
	<center>
		<h1><b style="color:#ff0000;" > Error:</b> Something went wrong!</h1>
		<h2><b style="color:#ff0000;" > Message:</b> <?php echo $msg ?></h2>
		<br><br><br><br>
		<h2><b style="color:#ff0000;" > Items:</b> <?php echo $items ?></h2>
	<center>
</body>
</html>
