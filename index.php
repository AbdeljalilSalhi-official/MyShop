<?php
require_once('includes/header.php');
if(!isset($_SESSION['I_COUNT'])){
	$_SESSION['I_COUNT'] = 1;
	$I_SELECT = $db->query("SELECT * FROM analytics WHERE title='visits'");
	while($s=$I_SELECT->fetch(PDO::FETCH_OBJ)){
		$I_COUNT = intval($s->value);
		$I_COUNT++;
		$db->query("UPDATE analytics SET value=$I_COUNT WHERE title='visits'");
	}
}
require_once('includes/footer.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Home</title>
	</head>
	<body onload=onloadBody()>
		<center>
			<span class="navbar-brand" style="margin-top:10%">
				<img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="100" height="100" class="d-inline-block" draggable=false>
				<h1 class="d-inline-block display-2 align-middle">MyShop</h1>
			</span>
			<br><br>
			<p>Sample by Abdeljalil Salhi</p>
		</center>
	</body>
</html>