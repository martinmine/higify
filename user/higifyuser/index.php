<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./Static/index.css" />
		<title>Higify - Login</title>
	</head>
	<body>
		<div class="pageContainer">
			<div class="centerContainer">
				<form action="test.php" method="POST">
				<div class="pageTitle">Welcome to Higify</div>
				<div class="loginContainer">
					<div class="messageContainer"><div class="error">
						Invalid username or password
					</div></div><br/>
					<div class="criticalError">
						FATAL SYSTEM ERROR! CRITICAL CORE MELTDOWN!
					</div>
					<label for="username">Username</label><br/>
					<input class="inputfield" type="text" name="username"/><br/>
					<label for="password">Password</label><br/>
					<input class="inputfield" type="password" name="password"/><br/>
					<a href="" class="reglink">Forgotten password&raquo;<a/><br/>
					<a href="" class="reglink">Register user&raquo;</a><br>
				</div>
				<input class="loginbtn" type="submit" value="Login">
				</form>
			</div>
		</div>
	</body>


</html>