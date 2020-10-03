<?php
require_once('includes/header.php');
require_once('includes/sidebar.php');
require_once('includes/cart_functions.php');
require_once('includes/footer.php');
$error = 'F';
$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));
if($action!==null){
	if(!in_array($action, array('add','delete','refresh'))){
		$error = 'T';
		$l = (isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
		$q = (isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
		$p = (isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));
		$l = preg_replace('#\v#', '', $l);
		$p = floatval($p);
		if(is_array($q)){
			$articleAmount = array();
			$i = 0;
			foreach($q as $context){
				$articleAmount[$i++] = intval($context);
			}
		}else{
			$q = intval($q);
		}
	}
}
if($error == 'F'){
	switch($action){
		case 'add':
		$l = $_GET['l'];
		$q = $_GET['q'];
		$p = $_GET['p'];
		addArticle($l,$q,$p);
		break;
		case 'delete':
		$l = $_GET['l'];
		deleteArticle($l);
		break;
		case 'refresh':
		for($i = 0; $i < count($articleAmount); $i++){
			editArticleAmount($_SESSION['cart']['productLabel'][$i], round($articleAmount[$i]));
		}
		break;
		default:
		break;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Cart</title>
	</head>
	<body onload=onloadBody()>
		<form action="" method=POST>
			<table style="width:65%">
				<tr>
					<td colspan=4><h2>&nbsp;Your Cart</h2></td>
				</tr>
				<tr>
					<th style="width:25%;text-align:center">Product Label</td>
					<th style="width:25%;text-align:center">Amount</td>
					<th style="width:25%;text-align:center">Unit Price</td>
					<th style="width:25%;text-align:center">Action</td>
				</tr>
<?php
if(isset($_GET['deletecart']) && $_GET['deletecart'] == true){
	deleteCart();
}
if(createCart()){
	$productCount = count($_SESSION['cart']['productLabel']);
	if($productCount <= 0){
?>
<tr>
	<td colspan=4 style="text-align:center"><br><h4>Empty Cart.</h4></td>
</tr>
<?php
	}else{
		$Total = totalPrice();
		$TotalTVA = totalTVA();
		for($i = 0; $i < $productCount; $i++){
?>
<tr>
	<td style="text-align:center"><?php echo $_SESSION['cart']['productLabel'][$i]; ?></td>
	<td><input type="number" name="amount" value=<?php echo $_SESSION['cart']['productAmount'][$i]; ?> class="form-control"/></td>
	<td style="text-align:center"><?php echo $_SESSION['cart']['productPrice'][$i]; ?></td>
	<!--<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo implode(',', $_SESSION['cart']['productTVA']).'%'; ?></td>-->
	<td style="padding-left:2px">
		<a href="cart.php?action=delete&amp;l=<?php echo $_SESSION['cart']['productLabel'][$i]; ?>" class="btn btn-danger">DELETE</a>
	</td>
</tr>
		<?php } ?>
<tr height=50></tr>
<tr>
	<td colspan=2 style="padding-left:20px">
		<p><b>Total:</b> $<?php echo $Total; ?></p>
		<!--<p>Total + TVA: $<?php echo $TotalTVA; ?></p>-->
	</td>
</tr>
<tr>
	<td colspan=3 style="padding-left:20px">
		<input type="submit" name="refreshButton" value="Refresh" class="btn btn-success"/>
		<input type="hidden" name="action" value="Refresh"/>
		<a href="?deletecart=true" class="text-danger">Delete Cart</a>
	</td>
	<td>
		<?php if(isset($_SESSION['user_id'])){ ?>
		<a href="checkout.php?outUrl=1" class="btn btn-primary">Checkout</a>
		<?php }else{ ?>
		<span class="text-danger">You have to be logged in to checkout! <a href="login.php">Login now!</a></span>
		<?php } ?>
	</td>
</tr>
<tr height=100></tr>

<?php
	}
}
?>
			</table>
		</form>
		<br><br>
	</body>
</html>