<?php
function createCart(){
	$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart'] = array();
		$_SESSION['cart']['productLabel'] = array();
		$_SESSION['cart']['productAmount'] = array();
		$_SESSION['cart']['productPrice'] = array();
		$_SESSION['cart']['locked'] = false;
		$select = $db->query("SELECT TVA FROM products");
		$data = $select->fetch(PDO::FETCH_OBJ);
		$_SESSION['cart']['productTVA'] = $data->TVA;
	}
	return true;
}
function addArticle($productLabel,$productAmount,$productPrice){
	if(createCart() && !isLocked()){
		$productPosition = array_search($productLabel,$_SESSION['cart']['productLabel']);
		if($productPosition !== false){
			$_SESSION['cart']['productAmount'][$productPosition] += $productAmount;
		}else{
			array_push($_SESSION['cart']['productLabel'], $productLabel);
			array_push($_SESSION['cart']['productAmount'], $productAmount);
			array_push($_SESSION['cart']['productPrice'], $productPrice);
		}
	}else{
		echo '<span class="error">Something went wrong...</span>';
	}
}
function editArticleAmount($productLabel,$productAmount){
	if(createCart() && !isLocked()){
		if($productAmount>0){
			$productPosition = array_search($productLabel, $_SESSION['cart']['productLabel']);
			if($productPosition!==false){
				$_SESSION['cart']['productAmount'][$productPosition] += $productAmount;
			}
		}else{
			deleteArticle($productLabel);
		}
	}else{
		echo '<span class="error">Something went wrong...</span>';
	}
}
function deleteArticle($productLabel){
	if(createCart() && !isLocked()){
		$tmp = array();
		$tmp['productLabel'] = array();
		$tmp['productAmount'] = array();
		$tmp['productPrice'] = array();
		$tmp['locked'] = $_SESSION['cart']['locked'];
		$tmp['productTVA'] = array();
		for($i = 0; $i<count($_SESSION['cart']['productLabel']); $i++){
			if($_SESSION['cart']['productLabel'][$i] !== $productLabel){
				array_push($tmp['productLabel'], $_SESSION['cart']['productLabel'][$i]);
				array_push($tmp['productAmount'], $_SESSION['cart']['productAmount'][$i]);
				array_push($tmp['productPrice'], $_SESSION['cart']['productPrice'][$i]);
			}
		}
		$_SESSION['cart'] = $tmp;
		unset($tmp);
	}else{
		echo '<span class="error">Something went wrong...</span>';
	}
}
function totalPrice(){
	$total = 0;
	for($i = 0; $i<count($_SESSION['cart']['productLabel']); $i++){
		$total += $_SESSION['cart']['productAmount'][$i] * $_SESSION['cart']['productPrice'][$i];
	}
	return $total;
}
function totalTVA(){
	$total = 0;
	for($i = 0; $i<count($_SESSION['cart']['productLabel']); $i++){
		$total += $_SESSION['cart']['productAmount'][$i] * $_SESSION['cart']['productPrice'][$i];
	}
	$percent = $total * intval($_SESSION['cart']['productTVA']);
	$percent = $percent / 100;
	return $total + $percent;
}
function deleteCart(){
	if(isset($_SESSION['cart'])){
		unset($_SESSION['cart']);
	}
}
function isLocked(){
	if(isset($_SESSION['cart']) && $_SESSION['cart']['locked']){
		return true;
	}else{
		return false;
	}
}
function countArticle(){
	if(isset($_SESSION['cart'])){
		return count($_SESSION['cart']['productLabel']);
	}else{
		return 0;
	}
}
?>