<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ADMIN - Home</title>
		<link rel="stylesheet" type="text/css" href="../style/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="style/admin.php.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<h1>&nbsp;Welcome, <?php echo $_SESSION['username']; ?>!
			<a target="_blank" href="analytics.php" class="btn btn-success">./goto_analytics</a>
			<a target="_blank" href="hash.php" class="btn btn-success">./goto_hash</a>
			<a target="_blank" href="../phpmyadmin/db_structure.php?server=1&db=myshop" class="btn bg-warning text-white">./goto_db</a>
			<a href="?logout=true" class="btn btn-danger text-white">Logout</a>
		</h1><br>&nbsp;
		<a href="?action=add" class="btn btn-primary">Add a Product</a>
		<a href="?action=editordelete" class="btn btn-primary">Edit/Delete a Product</a>
		<a href="?action=addcategory" class="btn btn-primary">Add a Category</a>
		<a href="?action=editordeletecategory" class="btn btn-primary">Edit/Delete a Category</a>
		<a href="?action=addweight" class="btn btn-primary">Add Weight</a>
	</body>
</html>
<?php
if(isset($_SESSION['username'])){
	if(isset($_GET['logout'])){
		if($_GET['logout']==true){
			unset($_SESSION['username']);
			header('Location: index.php');
		}
	}
	if(isset($_GET['action'])){
		if($_GET['action']=='add'){
			if(isset($_POST['addProduct'])){
				$stock = $_POST['stock'];
				$title = $_POST['title'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$img = $_FILES['img']['name'];
				$img_tmp = $_FILES['img']['tmp_name'];
				if(!empty($img_tmp)){
					$img_name = explode('.', $img);
					$img_ext = end($img_name);
					if(in_array(strtolower($img_ext),array('png','jpg','jpeg'))===false){
						echo '<span class="error">Incorrect extension!</span>';
					}else{
						$img_size = getimagesize($img_tmp);
						if($img_size['mime']=='image/jpeg'){
							$img_src = imagecreatefromjpeg($img_tmp);
						}else if($img_size['mime']=='image/png'){
							$img_src = imagecreatefrompng($img_tmp);
						}else{
							$img_src = false;
							echo '<span class="error">Please upload a valid image.</span>';
						}
						if($img_src!==false){
							$img_width=200;
							if($img_size[0]==$img_width){
								$img_final = $img_src;
							}else{
								$new_width[0] = $img_width;
								$new_height[1] = 200;
								$img_final = imagecreatetruecolor($new_width[0], $new_height[1]);
								imagecopyresampled($img_final,$img_src,0,0,0,0,$new_width[0],$new_height[1],$img_size[0],$img_size[1]);
							}
							imagejpeg($img_final,'imgs/'.$title.'.jpg');
						}
					}
				}else{
					echo '<span class="error">Please upload image.</span>';
				}
				if($title&&$description&&$price&&$stock){
					try{
						$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					}catch(Exception $e){
						echo '<span class="error">Error occured!</span>';
						die();
					}
					$category = $_POST['category'];
					$weight = $_POST['weight'];
					$TVA = $_POST['TVA'];
					$gettaxe=$db->query("SELECT taxe FROM weights WHERE weight='$weight'");
					$taxe = $gettaxe->fetch();
					$finalprice = $price + ($price * $TVA / 100);
					$finalprice = $finalprice + $taxe[0];
					$insert = $db->prepare("INSERT INTO products VALUES('','$title','$description','$price','$category','$weight','$taxe[0]','$TVA','$finalprice','$stock')");
					$insert->execute();
					echo '<span class="success">Product Added!</span>';
				}else{
					echo '<span class="error">Please complete all fields.</span>';
				}
			}
?>
<center>
	<form action="" method="POST" class="addForm border rounded" enctype="multipart/form-data">
		<h3>Add a Product</h3>
		<input type="text" name="title" placeholder="Title" class="form-control"/><br>
		<textarea name="description" placeholder="Description" class="form-control"></textarea><br>
		<input type="number" name="price" placeholder="Price" class="form-control"/>
		<h5>Category:</h5>
		<select name="category" class="form-control">
<?php
$select=$db->query("SELECT * FROM category");
while($s=$select->fetch(PDO::FETCH_OBJ)){
?>
<option><?php echo $s->name; ?></option>
<?php
}
?>
		</select>
		<h5>Weight:</h5>
		<select name="weight" class="form-control">
<?php
$select=$db->query("SELECT * FROM weights");
while($s=$select->fetch(PDO::FETCH_OBJ)){
?>
<option value="<?php echo $s->weight; ?>"><?php echo $s->weight . ' ($'.$s->taxe.')' ?></option>
<?php
}
?>
		</select><br>
		<input type="number" name="TVA" placeholder="TVA%" class="form-control"/><br>
		<input type="number" name="stock" placeholder="Stock" class="form-control"/><br>
		<label for="img"><span class="btn btn-primary red">Upload Image</span></label>
		<input type="file" name="img" id="img" style="display:none;"/><br>
		<input type="submit" name="addProduct" value="Add" class="btn btn-primary bg-success border-0"/>
	</form>
</center>
<?php
		}else if($_GET['action']=='editordelete'){
			$select = $db->prepare("SELECT * FROM products");
			$select->execute();
?>
<center>
	<div class="addForm border rounded">
		<h3>Products</h3>
<?php
			while($s=$select->fetch(PDO::FETCH_OBJ)){
?>
		<p style="float:left;"><img src="imgs/<?php echo $s->title; ?>.jpg" height=100/></p><br><br><br>
		<p><?php echo $s->title; ?>&nbsp;&nbsp;
		<a href="?action=edit&amp;id=<?php echo $s->id; ?>"><span class="btn btn-primary bg-success border-0">Edit</span></a>&nbsp;&nbsp;
		<a href="?action=delete&amp;id=<?php echo $s->id; ?>"><span class="btn btn-primary bg-danger border-0">X</span></a></p>
<?php
			}
?>
	</div>
</center>
<?php
		}else if($_GET['action']=='edit'){
			$id = $_GET['id'];
			$select = $db->prepare("SELECT * FROM products WHERE id=$id");
			$select->execute();
			$data = $select->fetch(PDO::FETCH_OBJ);
?>
<center>
	<form action="" method="POST" class="addForm border rounded">
		<h3>Edit a Product</h3>
		<input type="text" name="title" placeholder="Title" value="<?php echo $data->title ?>" class="form-control"/><br>
		<textarea name="description" placeholder="Description" class="form-control"><?php echo $data->description ?></textarea><br>
		<input type="number" name="price" placeholder="Price" value="<?php echo $data->price ?>" class="form-control"/><br>
		<input type="number" name="stock" placeholder="Stock" value="<?php echo $data->stock ?>" class="form-control"/><br>
		<input type="submit" name="editProduct" value="Edit" class="btn btn-primary bg-success border-0"/>
	</form>
</center>
<?php
			if(isset($_POST['editProduct'])){
				$stock = $_POST['stock'];
				$title = $_POST['title'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$getweight = $db->query("SELECT weight FROM products WHERE id=$id");
				$weight = $getweight->fetch();
				$weight = $weight[0];
				$gettaxe = $db->query("SELECT taxe FROM weights WHERE weight='$weight'");
				$taxe = $gettaxe->fetch();
				$taxe = $taxe[0];
				$getTVA = $db->query("SELECT TVA FROM products WHERE id=$id");
				$TVA = $getTVA->fetch();
				$TVA = $TVA[0];
				$finalprice = $price + ($price * $TVA / 100);
				$finalprice = $finalprice + $taxe;
				$update = $db->prepare("UPDATE products SET title='$title',description='$description',price='$price',taxe='$taxe',finalprice='$finalprice',stock='$stock' WHERE id=$id");
				$update->execute();
				header('Location: admin.php?action=editordelete');
			}
		}else if($_GET['action']=='delete'){
			$id = $_GET['id'];
			$delete = $db->prepare("DELETE FROM products WHERE id=$id");
			$delete->execute();
			header('Location: admin.php?action=editordelete');
		}else if($_GET['action']=='addcategory'){
			if(isset($_POST['addCategory'])){
				$name = $_POST['name'];
				if($name){
					$insert = $db->prepare("INSERT INTO category VALUES('','$name')");
					$insert->execute();
					echo '<span class="success">Category Added!</span>';
				}else{
					echo '<span class="error">Please complete all fields.</span>';
				}
			}
?>
<center>
	<form action="" method="POST" class="addForm border rounded">
		<h3>Add a Category</h3>
		<input type="text" name="name" placeholder="Category Name" class="form-control"/><br>
		<input type="submit" name="addCategory" value="Add" class="btn btn-primary bg-success border-0"/>
	</form>
</center>
<?php
		}else if($_GET['action']=='editordeletecategory'){
			$select = $db->prepare("SELECT * FROM category");
			$select->execute();
?>
<center>
	<div class="addForm border rounded">
		<h3>Categories</h3>
<?php
			while($s=$select->fetch(PDO::FETCH_OBJ)){
?>
		<?php echo $s->name; ?>&nbsp;&nbsp;
		<a href="?action=editcategory&amp;id=<?php echo $s->id; ?>"><span class="btn btn-primary bg-success border-0">Edit</span></a>&nbsp;&nbsp;
		<a href="?action=deletecategory&amp;id=<?php echo $s->id; ?>"><span class="btn btn-primary bg-danger border-0">X</span></a><br>
<?php
			}
?>
	</div>
</center>
<?php
		}else if($_GET['action']=='editcategory'){
			$id = $_GET['id'];
			$select = $db->prepare("SELECT * FROM category WHERE id=$id");
			$select->execute();
			$data = $select->fetch(PDO::FETCH_OBJ);
?>
<center>
	<form action="" method="POST" class="addForm border rounded">
		<h3>Edit a Category</h3>
		<input type="text" name="name" placeholder="Category Name" value="<?php echo $data->name ?>" class="form-control"/><br>
		<input type="submit" name="editCategory" value="Edit" class="btn btn-primary bg-success border-0"/>
	</form>
</center>
<?php
			if(isset($_POST['editCategory'])){
				$name = $_POST['name'];
				$select = $db->query("SELECT name FROM category WHERE id='$id'");
				$result = $select->fetch(PDO::FETCH_OBJ);
				$update = $db->prepare("UPDATE category SET name='$name' WHERE id=$id");
				$update->execute();
				$update = $db->query("UPDATE products SET category='$name' WHERE category='$result->name'");
				header('Location: admin.php?action=editordeletecategory');
			}
		}else if($_GET['action']=='deletecategory'){
			$id = $_GET['id'];
			$delete = $db->prepare("DELETE FROM category WHERE id=$id");
			$delete->execute();
			header('Location: admin.php?action=editordeletecategory');
		}else if($_GET['action']=='addweight'){
			if(isset($_POST['addWeight'])){
				$weight = $_POST['weight'];
				$taxe = $_POST['taxe'];
				if($weight&&$taxe){
					$insert = $db->prepare("INSERT INTO weights VALUES('','$weight','$taxe')");
					$insert->execute();
					echo '<span class="success">Weight Added!</span>';
				}else{
					echo '<span class="error">Please complete all fields.</span>';
				}
			}
?>
<center>
	<form action="" method="POST" class="addForm border rounded">
		<h3>Weight Taxes</h3>
		<input type="text" name="weight" placeholder="Weight" class="form-control"/><br>
		<input type="number" name="taxe" placeholder="Taxe" class="form-control"/><br>
		<input type="submit" name="addWeight" value="Add" class="btn btn-primary bg-success border-0"/>
	</form>
</center>
<?php
		}else{
			echo '<span class="error">Error occured!</span>';
		}
	}
}else{
	header('Location: ../index.php');
}
?>