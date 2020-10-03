<?php
require_once('includes/header.php');
require_once('includes/sidebar.php');
require_once('includes/footer.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Shop</title>
	</head>
	<body onload=onloadBody()>
<?php
if(isset($_GET['category'])){
	$category = $_GET['category'];
	$select = $db->prepare("SELECT * FROM products WHERE category='$category'");
	$select->execute();
?>
<br>
<div class="card-columns" style="width:70%;margin-left:1%">
<?php
	while($s=$select->fetch(PDO::FETCH_OBJ)){
		$length = 75;
		$description = $s->description;
		$newdescription = substr($description,0,$length)."...";
?>
		<div class="card" style="width: 16rem;">
			<img class="card-img-top" src="admin/imgs/<?php echo $s->title; ?>.jpg" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title"><?php echo $s->title; ?></h5>
				<h6 class="card-subtitle mb-2 text-muted"><?php echo $s->category; ?></h6>
				<p class="card-text"><?php echo $newdescription; ?></p>
				<h4 class="card-text text-right text-success">$<?php echo $s->price; ?></h4>
			</div>
			<div class="card-footer">
				<a href="?show=<?php echo $s->id; ?>" class="card-link text-success">Show</a>
<?php
if($s->stock==0){
	echo '<i class="card-link text-danger">Sold out</i>';
}else{
	echo '<a href="cart.php?action=add&amp;l=' . $s->title . '&amp;q=1&amp;p=' . $s->price . '" class="card-link text-success">Add to Cart</a>';
}
?>
			</div>
		</div>
<?php
	}
?>
</div>
<br><br><br>
<?php
}else if(isset($_GET['show'])){
	$product = $_GET['show'];
	$select = $db->prepare("SELECT * FROM products WHERE id=$product");
	$select->execute();
	$s = $select->fetch(PDO::FETCH_OBJ);
	$description = $s->description;
	$newdescription = wordwrap($description,50,"<br>",true);
?>
<div style="margin:3% 7%">
<img src="admin/imgs/<?php echo $s->title; ?>.jpg" class="rounded"/>
<h1><?php echo $s->title; ?></h1>
<h6 class="text-muted"><?php echo $s->category; ?></h6>
<h5><?php echo $newdescription; ?></h5>
<h4 class="text-success">$<?php echo $s->price; ?></h4>
<h6 class="text-muted"><i>
<?php
	if($s->stock==0){
		echo 'sold out';
	}else{
		echo $s->stock . ' in stock';
	}
?></i></h6>
<?php
if($s->stock==0){
	echo '<a href="" class="btn btn-success disabled">Add to Cart</a>';
}else{
	echo '<a href="cart.php?action=add&amp;l=' . $s->title . '&amp;q=1&amp;p=' . $s->price . '" class="btn btn-success">Add to Cart</a>';
}
?>
</div>
<br><br>
<?php
}else{
	$select = $db->query("SELECT * FROM category");
?>
<br>
<h1>&nbsp;Categories</h1>
<br>&nbsp;&nbsp;
<?php
	while($s=$select->fetch(PDO::FETCH_OBJ)){
?>
<a href="?category=<?php echo $s->name; ?>" class="btn btn-primary bg-success border-0"><h3><?php echo $s->name; ?></h3></a>	
<?php
	}
}
?>
	</body>
</html>