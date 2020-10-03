<?php
require_once('includes/header.php');
require_once('includes/footer.php');

if(!isset($_SESSION['user_id'])){
	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		if($email&&$password){
			$select = $db->query("SELECT * FROM users WHERE email='$email'");
			if($select->fetchColumn()){
				$select = $db->query("SELECT * FROM users WHERE email='$email'");
				$data = $select->fetch(PDO::FETCH_OBJ);
				if(password_verify($password, $data->password)){
					$select = $db->query("SELECT * FROM users WHERE email='$email'");
					$result = $select->fetch(PDO::FETCH_OBJ);
					$_SESSION['user_id'] = $result->id;
					$_SESSION['user_email'] = $result->email;
					$_SESSION['user_username'] = $result->username;
					$_SESSION['user_password'] = $result->password;
					header('Location: myaccount.php');
				}else{
					echo '<center><h5 style="color:red;">Invalid password.</h5></center>';
				}
			}else{
				echo '<center><h5 style="color:red;">Invalid credentials.</h5></center>';
			}
		}else{
			echo '<center><h5 style="color:red;">Please complete all fields.</h5></center>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Login</title>
		<link type="text/css" rel="stylesheet" href="style/style.css"/>
	</head>
	<body onload=onloadBody()>
		<center>
			<form action="" method=POST class="myForm border rounded">
				<h1>Login</h1>
				<input type="email" name="email" placeholder="Email" class="form-control"/><br>
				<input type="password" name="password" placeholder="Password" class="form-control"/><br>
				<input type="submit" name="submit" value="Login" class="btn btn-success"/>
			</form>
			<a href="register.php">No account yet? Register now!</a>
		</center>
	</body>
</html>
<?php
}else{
	header('Location: myaccount.php');
}
?>