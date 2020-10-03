<link type="text/css" rel="stylesheet" href="style/sidebar.css"/>
<div class="sidebar bg-success">
	<h4>Last Articles</h4>
<?php
$select = $db->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 0,4");
$select->execute();
while($s=$select->fetch(PDO::FETCH_OBJ)){
	$length = 30;
	$description = $s->description;
	$newdescription = substr($description,0,$length)."...";
?>
	<a href="shop.php?show=<?php echo $s->id; ?>" style="text-decoration:none;width:100%" class="btn btn-success">
		<h3 class="text-white"><?php echo $s->title; ?></h2>
		<h6 class="text-white"><?php echo $newdescription; ?></h5>
		<h5 class="text-white">$<?php echo $s->price; ?></h4>
	</a>
<?php
}
?>
	<a href="shop.php" style="text-decoration:none;width:100%" class="btn btn-success">See Categories >></a>
</div>