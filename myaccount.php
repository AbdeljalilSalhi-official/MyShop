<?php
require_once('includes/header.php');
require_once('includes/footer.php');

if(isset($_SESSION['user_id'])){
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - My Account</title>
	</head>
	<body onload=onloadBody()>
		<center style="margin-top:5%;">
			<img src="https://image.flaticon.com/icons/png/512/20/20079.png" height=150/>
			<h3><?php echo $_SESSION['user_username']; ?></h3>
			<h6><?php echo $_SESSION['user_email']; ?></h6>
			<br><br>
			<a href="logout.php" class="btn btn-danger">Logout</a>
		</center>
		<br><br>
		<div style="margin-left:10px;">
			<h2>My transactions</h2>
<?php
$user_id = $_SESSION['user_id'];
$select = $db->query("SELECT * FROM transactions WHERE user_id='$user_id'");
while($s=$select->fetch(PDO::FETCH_OBJ)){
?>
			<h6>Name: <?php echo $s->name; ?></h6>
			<h6>Street: <?php echo $s->street; ?></h6>
			<h6>State: <?php echo $s->state; ?></h6>
			<h6>City: <?php echo $s->city; ?></h6>
			<h6>Postal Code: <?php echo $s->postalcode; ?></h6>
			<h6>Country Code: <?php echo $s->countrycode; ?></h6>
			<h6>Currency Code: <?php echo $s->currency_code; ?></h6>
			<h6>Date: <?php echo $s->date; ?></h6>
			<h6>Transaction ID: <?php echo $s->transaction_id; ?></h6>
			<h6>Products: <?php echo $s->products; ?></h6>
			<h6>Total Paid: $<?php echo $s->totalTVA; ?></h6>
			<hr width="50%" align="left">
<?php
}
?>
		</div>
		<br><br><br>
	</body>
</html>
<?php
}
?>