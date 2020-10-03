<?php
session_start();
require_once('includes/cart_functions.php');
require_once('includes/footer.php');
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
if(isset($_GET['outUrl'])){
	$_SESSION['checkout'] = 1;
	$TOTALFINAL = 0;
	$ALLPRODUCTS = '';
	for($i = 0; $i < count($_SESSION['cart']['productLabel']); $i++){
		$ALLPRODUCTS = $ALLPRODUCTS . '/ ' . $_SESSION['cart']['productLabel'][$i] . '[*' . $_SESSION['cart']['productAmount'][$i] . '] ';
	}
	$_SESSION['ALLPRODUCTS'] = $ALLPRODUCTS;
	for($i = 0; $i < count($_SESSION['cart']['productLabel']); $i++){
		if($_SESSION['cart']['productAmount'][$i] == 1){
			$titleFOR = $_SESSION['cart']['productLabel'][$i];
			$amountFOR = $_SESSION['cart']['productAmount'][$i];
			$select = $db->query("SELECT finalprice FROM products WHERE title='$titleFOR'");
			$data = $select->fetch();
			$TOTALFINAL += $data[0];
		}else{
			$titleFOR = $_SESSION['cart']['productLabel'][$i];
			$amountFOR = $_SESSION['cart']['productAmount'][$i];
			$select = $db->query("SELECT finalprice FROM products WHERE title='$titleFOR'");
			$data = $select->fetch();
			$TOTALFINAL += $data[$i] * $amountFOR;
		}
	}
	$TOTALSHIPPING = $TOTALFINAL - totalPrice();
	$_SESSION['TOTALFINAL'] = $TOTALFINAL;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Checkout</title>
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
			<div class="card border-primary mb-3" style="max-width:18rem;z-index:0">
				<div class="card-header">
					<h3 style="text-align:left">Total</h3>
					<h4 class="text-right">$<?php echo $TOTALFINAL; ?></h4>
				</div>
				<div class="card-body text-primary">
					<table style="width:100%">
						<tr>
							<td style="width:50%"><span style="font-weight:500">Subtotal</span></td>
							<td style="width:50%;text-align:right">$<?php echo totalPrice(); ?></td>
						</tr>
						<tr>
							<td style="width:50%"><span style="font-weight:500">Shipping + TVA</span></td>
							<td style="width:50%;text-align:right">$<?php echo $TOTALSHIPPING; ?></td>
						</tr>
					</table>
					<hr>
					<h5 class="card-title text-dark">Pay with PayPal</h5>
					<div id="paypal-button-container"></div>
				</div>
			</div>
			<div style="height:100px;"></div>
		</center>
		<script>
			paypal.Buttons({
				createOrder: function(data, actions) {
					return actions.order.create({
						purchase_units: [{
							amount: {
								value: '<?php echo $TOTALFINAL; ?>'
							}
						}]
					});
				},
				onApprove: function(data, actions) {
					return actions.order.capture().then(function(details) {
						C_STREET = details.purchase_units[0].shipping.address.address_line_1;
						C_CITY = details.purchase_units[0].shipping.address.admin_area_1;
						C_STATE = details.purchase_units[0].shipping.address.admin_area_2;
						C_COUNTRYCODE = details.purchase_units[0].shipping.address.country_code;
						C_POSTALCODE = details.purchase_units[0].shipping.address.postal_code;
						C_FULLNAME = details.purchase_units[0].shipping.name.full_name;
						C_TRANSACTIONID = details.purchase_units[0].payments.captures[0].id;
						C_DATETIME = details.purchase_units[0].payments.captures[0].update_time;
						C_AMOUNT = details.purchase_units[0].payments.captures[0].amount.value;
						C_CURRENCYCODE = details.purchase_units[0].payments.captures[0].amount.currency_code;
						C_USEREMAIL = details.purchase_units[0].payee.email_address;
						document.cookie = "C_NAME=" + C_FULLNAME;
						document.cookie = "C_STREET=" + C_STREET;
						document.cookie = "C_CITY=" + C_CITY;
						document.cookie = "C_STATE=" + C_STATE;
						document.cookie = "C_POSTALCODE=" + C_POSTALCODE;
						document.cookie = "C_COUNTRYCODE=" + C_COUNTRYCODE;
						document.cookie = "C_DATETIME=" + C_DATETIME;
						document.cookie = "C_TRANSACTIONID=" + C_TRANSACTIONID;
						document.cookie = "C_AMOUNT=" + C_AMOUNT;
						document.cookie = "C_CURRENCYCODE=" + C_CURRENCYCODE;
						document.cookie = "C_USEREMAIL=" + C_USEREMAIL;
						window.location.href = "process.php?yesUrl=1";
					});
				},
				onCancel: function (data) {
					window.location.href = "cancel.php?noUrl=1";
				}
			}).render('#paypal-button-container');
		</script>
	</body>
</html>
<?php
}else{
	header('Location: index.php');
}
?>