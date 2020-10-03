<?php
require_once('includes/cart_functions.php');
require_once('includes/footer.php');
if(isset($_GET['noUrl'])){
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Cancel</title>
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
			<div class="card border-danger mb-3" style="max-width:18rem;">
				<div class="card-header"><h5>
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bag-x text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M8 1a2.5 2.5 0 0 0-2.5 2.5V4h5v-.5A2.5 2.5 0 0 0 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5H2z"/>
					<path fill-rule="evenodd" d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708z"/>
				</svg><span class="align-middle">&nbsp;Transaction Cancelled</span></h5></div>
				<div class="card-body">
					<p>Your order has been cancelled.</p>
				</div>
				<div class="card-footer">
					<a href="index.php" class="btn btn-danger">Go back to Home</a>
				</div>
			</div>
			<div style="height:100px;"></div>
		</center>
	</body>
</html>
<?php
}else{
	header('Location: index.php');
}
?>