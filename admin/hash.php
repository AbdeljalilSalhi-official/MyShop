<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_SESSION['username'])){
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ADMIN - Hash</title>
		<link type="text/css" rel="stylesheet" href="../style/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="style/style.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			.success{
				color:white;
				background-color:#339933;
				position:absolute;
				top:0;
				left:0;
				width:100vw;
				padding:10px 10px;
			}
		</style>
	</head>
	<body>
		<center>
			<h1>ADMIN - Hash</h1>
			<form method="POST" class="loginForm border rounded">
				<label for="password"><h4>Password to hash</h4></label>
				<input type="text" name="password" class="form-control"/><br>
				<input type="submit" name="submit" value="Hash" class="btn btn-success"/>
			</form><br>
			<input id="pswdHash" class="border rounded" value="
<?php
	if(isset($_POST['submit'])){
		$password = $_POST['password'];
		$timeTarget = 0.05; //50ms
		$cost = 8; //hash option [COST]
		do{
			$cost++;
			$start = microtime(true);
			password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
			$end = microtime(true);
		}while(($end - $start) < $timeTarget);
		$options = [
			'cost' => $cost,
		];
		$password = password_hash($password, PASSWORD_BCRYPT, $options);
		echo $password;
	}
?>
			"/>
			<button class="btn btn-success" onclick="copyHash()">Copy to clipboard</button>
			<script>
				function copyHash(){
					var hash = document.getElementById("pswdHash");
					hash.select();
					hash.setSelectionRange(0, 99999);
					document.execCommand("copy");
					alert("Copied to clipboard!");
				}
			</script>
		</center>
<?php
	if(isset($_POST['submit'])){
		echo '<span class="success">Password Hashed!</span>';
	}
?>
	</body>
</html>
<?php
}else{
	header('Location: ../index.php');
}