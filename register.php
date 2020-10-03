<?php
require_once('includes/header.php');
require_once('includes/footer.php');

if(!isset($_SESSION['user_id'])){
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repeat = $_POST['repeat'];
		if($username&&$email&&$password&&$repeat){
			$select = $db->query("SELECT * FROM users WHERE email='$email'");
			$data = $select->fetch(PDO::FETCH_OBJ);
			if($data->email==$email){
				echo '<center><h5 style="color:red;">Email already registered.</h5></center>';
			}else{
				if($password==$repeat){
					$timeTarget = 0.05; //50ms
					$cost = 8; //hash option [COST]
					do{
						$cost++;
						$start = microtime(true);
						password_hash($password, PASSWORD_BCRYPT, ["cost" => $cost]);
						$end = microtime(true);
					}while(($end - $start) < $timeTarget);
					$options = [
						'cost' => $cost,
					];
					$password = password_hash($password, PASSWORD_BCRYPT, $options);
					$db->query("INSERT INTO users VALUES('','$username','$email','$password')");
					echo '<center><h5 style="color:green;">Account created, you can <a href="login.php">login now</a>.</h5></center>';
				}else{
					echo '<center><h5 style="color:red;">Passwords don\'t match.</h5></center>';
				}
			}
		}else{
			echo '<center><h5 style="color:red;">Please complete all fields.</h5></center>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyShop - Register</title>
		<link type="text/css" rel="stylesheet" href="style/style.css"/>
	</head>
	<body onload=onloadBody()>
		<center>
			<form action="" method=POST class="myForm border rounded">
				<h1>Register</h1>
				<input type="text" name="username" placeholder="Username" class="form-control"/><br>
				<input type="email" name="email" placeholder="Email" class="form-control"/><br>
				<input type="password" name="password" placeholder="Password" class="form-control"/><br>
				<input type="password" name="repeat" placeholder="Repeat Password" class="form-control"/><br>
				<input type="submit" name="submit" value="Register" class="btn btn-success"/>
			</form>
			<a href="login.php">Already have an account? Login now!</a>
		</center>
	</body>
</html>
<?php
}else{
	header('Location: myaccount.php');
}
?>