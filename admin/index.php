<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=myshop', 'root', '');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_SESSION['username'])){
	header('Location: admin.php');
}else{
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if($username&&$password){
			$select = $db->query("SELECT * FROM staff WHERE username='$username'");
			if($select->fetchColumn()){
				$select = $db->query("SELECT * FROM staff WHERE username='$username'");
				$data = $select->fetch(PDO::FETCH_OBJ);
				if(password_verify($password, $data->password)){
					$_SESSION['username'] = $username;
					header('Location: admin.php');
				}else{
					echo '<span class="error">Invalid password.</span>';
				}
			}else{
				echo '<span class="error">Invalid credentials.</span>';
			}
		}else{
			echo '<span class="error">Please complete all fields.</span>';
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ADMIN - Login</title>
		<link type="text/css" rel="stylesheet" href="../style/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="style/style.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<center>
			<h1>ADMIN - Login</h1>
			<form action="?action=login" method="POST" class="loginForm border rounded">
				<label for="username"><h4>Username</h4></label>
				<input type="text" name="username" class="form-control"/><br>
				<label for="password"><h4>Password</h4></label>
				<input type="password" name="password" class="form-control"/><br>
				<input type="submit" name="submit" value="Login" class="btn bg-success text-white"/>
			</form>
		</center>
	</body>
</html>