<?php
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
if(isset($_SESSION['username'])){
	$I_SELECT = $db->query("SELECT * FROM analytics WHERE title='visits'");
	while($s=$I_SELECT->fetch(PDO::FETCH_OBJ)){
		$VISITS = intval($s->value);
	}
	$I_SELECT = $db->query("SELECT * FROM analytics WHERE title='sales'");
	while($s=$I_SELECT->fetch(PDO::FETCH_OBJ)){
		$SALES = intval($s->value);
	}
	$I_SELECT = $db->query("SELECT * FROM analytics WHERE title='revenue'");
	while($s=$I_SELECT->fetch(PDO::FETCH_OBJ)){
		$REVENUE = intval($s->value);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ADMIN - Analytics</title>
		<link rel="stylesheet" type="text/css" href="../style/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="style/admin.php.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<center>
			<span class="navbar-brand" style="margin-top:10%">
				<img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="80" height="80" class="d-inline-block" draggable=false>
			</span>
			<br><br>
			<div class="card" style="width: 18rem;">
				<table class="table">
				  <tbody>
					<tr>
					  <th>Visits</th>
					  <td><?php echo $VISITS; ?></td>
					</tr>
					<tr>
					  <th>Sales</th>
					  <td><?php echo $SALES; ?></td>
					</tr>
					<tr>
					  <th>Revenue</th>
					  <td>$<?php echo $REVENUE; ?></td>
					</tr>
					<tr>
					  <th>Users</th>
					  <td>
<?php
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$count = $db->query("SELECT COUNT(*) FROM users");
echo $count->fetch()[0];
?>
					  </td>
					</tr>
				  </tbody>
				</table>
			</div>
		</center>
	</body>
</html>
<?php
}else{
	header('Location: ../index.php');
}
?>