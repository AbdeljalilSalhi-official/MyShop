<?php
session_start();
require_once('includes/footer.php');
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
if(isset($_GET['inUrl'])){
	$TRANSACTION = $_SESSION['TRANSACTION'];
	$select = $db->query("SELECT * FROM transactions WHERE transaction_id='$TRANSACTION'");
	while($data=$select->fetch(PDO::FETCH_OBJ)){
		$name = $data->name;
		$street = $data->street;
		$city = $data->city;
		$state = $data->state;
		$postalcode = $data->postalcode;
		$countrycode = $data->countrycode;
		$transaction_id = $data->transaction_id;
		$amount = $data->amount;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Success</title>
		<link type="text/css" rel="stylesheet" href="style/bootstrap.min.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	</head>
	<body>
		<center>
			<span class="navbar-brand" style="margin-top:5%">
				<img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="80" height="80" class="d-inline-block align-top" draggable=false>
				<h1 class="d-inline-block display-4">MyShop</h1>
			</span>
			<br><br>
			<div class="card border-success mb-3" style="max-width:18rem;">
				<div class="card-header"><h5>
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bag-check text-success" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M8 1a2.5 2.5 0 0 0-2.5 2.5V4h5v-.5A2.5 2.5 0 0 0 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5H2z"></path>
					<path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
				</svg><span class="align-middle">&nbsp;Transaction Successful</span></h5></div>
				<div class="card-body">
					<h6 style="text-align:left">Transaction ID</h6>
					<p style="text-align:left"><?php echo $transaction_id; ?></p>
					<h6 style="text-align:left">Shipping address</h6>
					<p style="text-align:left"><?php echo $street . ', ' . $city . ', ' . $state . ' ' . $postalcode; ?></p>
					<h6 style="text-align:left">Shipped to</h6>
					<p style="text-align:left"><?php echo $name; ?></p>
					<span class="text-success">Duration: 3-5 working days</span>
				</div>
				<div class="card-footer">
					<a href="index.php" class="btn btn-success">Go back to Home</a>
				</div>
			</div>
			<div style="height:100px;"></div>
		</center>
	</body>
</html>
<?php
	}
}else{
	header('Location: index.php');
}
?>