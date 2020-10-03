<?php
session_start();
require_once('includes/cart_functions.php');
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
if(isset($_SESSION['checkout'])){
	if(isset($_GET['yesUrl'])){
		$I_SALES = 0;
		for($i = 0; $i < count($_SESSION['cart']['productLabel']); $i++){
			$S_PRODUCT = $_SESSION['cart']['productLabel'][$i];
			$S_AMOUNT = $_SESSION['cart']['productAmount'][$i];
			$I_SALES += $S_AMOUNT;
			$S_SELECT = $db->query("SELECT * FROM products WHERE title='$S_PRODUCT'");
			while($s=$S_SELECT->fetch(PDO::FETCH_OBJ)){
				$S_STOCK = intval($s->stock) - $S_AMOUNT;
			}
			$S_UPDATE = $db->prepare("UPDATE products SET stock='$S_STOCK' WHERE title='$S_PRODUCT'");
			$S_UPDATE->execute();
		}
		$D_NAME =  $_COOKIE['C_NAME'];
		$USER_ID = $_SESSION['user_id'];
		$D_STREET = $_COOKIE['C_STREET'];
		$D_CITY = $_COOKIE['C_CITY'];
		$D_STATE = $_COOKIE['C_STATE'];
		$D_POSTALCODE = $_COOKIE['C_POSTALCODE'];
		$D_COUNTRYCODE = $_COOKIE['C_COUNTRYCODE'];
		$D_DATE = $_COOKIE['C_DATETIME'];
		$D_PRODUCTS = $_SESSION['ALLPRODUCTS'];
		$D_TRANSACTIONID = $_COOKIE['C_TRANSACTIONID'];
		$D_AMOUNT = $_COOKIE['C_AMOUNT'];
		$D_CURRENCYCODE = $_COOKIE['C_CURRENCYCODE'];
		$D_USEREMAIL = $_COOKIE['C_USEREMAIL'];
		$D_TOTALTVA = $_SESSION['TOTALFINAL'];
		$insert = $db->prepare("INSERT INTO transactions VALUES('','$USER_ID','$D_NAME','$D_STREET','$D_CITY','$D_STATE','$D_POSTALCODE','$D_COUNTRYCODE','$D_DATE','$D_PRODUCTS','$D_TRANSACTIONID','$D_AMOUNT','$D_CURRENCYCODE','$D_USEREMAIL','$D_TOTALTVA')");
		$insert->execute();
		$_SESSION['TRANSACTION'] = $D_TRANSACTIONID;
		$I_SELECT = $db->query("SELECT * FROM analytics WHERE title='revenue'");
		while($s=$I_SELECT->fetch(PDO::FETCH_OBJ)){
			$I_COUNT = floatval($s->value);
			$I_COUNT += floatval($D_AMOUNT);
			$db->query("UPDATE analytics SET value=$I_COUNT WHERE title='revenue'");
		}
		unset($_SESSION['checkout']);
		unset($_SESSION['ALLPRODUCTS']);
		unset($_SESSION['TOTALFINAL']);
		setcookie('C_NAME', '', time() - 3600);
		setcookie('C_STREET', '', time() - 3600);
		setcookie('C_CITY', '', time() - 3600);
		setcookie('C_STATE', '', time() - 3600);
		setcookie('C_COUNTRYCODE', '', time() - 3600);
		setcookie('C_POSTALCODE', '', time() - 3600);
		setcookie('C_DATETIME', '', time() - 3600);
		setcookie('C_TRANSACTIONID', '', time() - 3600);
		setcookie('C_AMOUNT', '', time() - 3600);
		setcookie('C_CURRENCYCODE', '', time() - 3600);
		setcookie('C_USEREMAIL', '', time() - 3600);
		deleteCart();
		$I_SELECT = $db->query("SELECT * FROM analytics WHERE title='sales'");
		while($s=$I_SELECT->fetch(PDO::FETCH_OBJ)){
			$I_COUNT = intval($s->value);
			$I_COUNT += $I_SALES;
			$db->query("UPDATE analytics SET value=$I_COUNT WHERE title='sales'");
		}
		header('Location: success.php?inUrl=1');
	}else{
		header('Location: index.php');
	}
}else{
	header('Location: index.php');
}
?>