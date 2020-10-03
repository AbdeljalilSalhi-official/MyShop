<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="style/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="style/header.css"/>
		<link rel="shortcut icon" href="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<script>
			function onloadBody(){
				var element, name, arr, id;
				id = location.pathname.substring(location.pathname.lastIndexOf("/") + 1).split('.')[0];
				if (id == ""){
					id = "index";
				}
				element = document.getElementById(id);
				name = "active";
				arr = element.className.split(" ");
				if (arr.indexOf(name) == -1) {
					element.className += " " + name;
				}
			}
		</script>
	</head>
	<header>
		<nav class="navbar navbar-expand fixed-top navbar-dark bg-success">
			<a class="navbar-brand" href="index.php">
				<img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top">
				MyShop</a>
			<div>
				<ul class="navbar-nav">
					<li class="nav-item" id="index">
						<a class="nav-link btn-success" href="index.php">Home</a>
					</li>
					<li class="nav-item" id="shop">
						<a class="nav-link btn-success" href="shop.php">Shop</a>
					</li>
					<li class="nav-item" id="cart">
						<a class="nav-link btn-success" href="cart.php">Cart</a>
					</li>
					<?php if(!isset($_SESSION['user_id'])){ ?>
					<li class="nav-item" id="register">
						<a class="nav-link btn-success" href="register.php">Register</a>
					</li>
					<li class="nav-item" id="login">
						<a class="nav-link btn-success" href="login.php">Login</a>
					</li>
					<?php }else{ ?>
					<li class="nav-item" id="myaccount">
						<a class="nav-link btn-success" href="myaccount.php">My account</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
	</header>
</html>