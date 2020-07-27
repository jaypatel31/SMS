<?php
	session_start();
	require_once('pdo.php');

	if(isset($_POST['submit'])){
		$sql = "SELECT * FROM login WHERE username = :user AND password = :pass";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':user' => $_POST['username'],
			':pass' => $_POST['password']
		));
		
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		if($rows!== false){
			$sql2 = "UPDATE login SET last_login = NOW() WHERE login_id = :id";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->execute(array(
				':id' => $rows['login_id']
			));
			$_SESSION['username'] = $rows['username'];
			header('Location: index.php');
		}
		else{
			header('Location: login.php?error=INVALID CREDENTIALS');
			return;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Simple Login Form with Blue Background</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	color: #fff;
	background: #3598dc;
}
.form-control {
	min-height: 41px;
	background: #f2f2f2;
	box-shadow: none !important;
	border: transparent;
}
.form-control:focus {
	background: #e2e2e2;
}
.form-control, .btn {        
	border-radius: 2px;
}
.login-form {
	width: 350px;
	margin: 30px auto;
	text-align: center;
}
.login-form h2 {
	margin: 10px 0 25px;
}
.login-form form {
	color: #7a7a7a;
	border-radius: 3px;
	margin-bottom: 15px;
	background: #fff;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.login-form .btn {        
	font-size: 16px;
	font-weight: bold;
	background: #3598dc;
	border: none;
	outline: none !important;
}
.login-form .btn:hover, .login-form .btn:focus {
	background: #2389cd;
}
.login-form a {
	color: #fff;
	text-decoration: underline;
}
.login-form a:hover {
	text-decoration: none;
}
.login-form form a {
	color: #7a7a7a;
	text-decoration: none;
}
.login-form form a:hover {
	text-decoration: underline;
}
</style>
</head>
<body>
<div class="login-form">
    <form method="post">
	<?php
		if(isset($_GET['error'])){
			echo "<p style='color:red'>".$_GET['error']."</p>";
		}
	?>
        <h2 class="text-center">Login</h2>   
        <div class="form-group has-error">
        	<input type="text" class="form-control" name="username" placeholder="Username" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">Sign in</button>
        </div>
    </form>
</div>
</body>
</html>