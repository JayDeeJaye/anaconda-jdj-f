<?php
	session_start();
	if (!empty($_SESSION['userName'])) {
		header('Location: home.php');
	}
?>
<html>
	<head>
		<title>Battleship!</title>
		<link rel="stylesheet" type="text/css" href="css/warzone.css">
	</head>
	<body>
		<h1 align="center">Welcome to the War Zone!!!</h1>
		
		<div style="overflow:auto; border: 1px solid green; padding:2%; width:500px; margin: auto;">
			<div class="form-heading" align="center">
				<span class="errormsg">
					<?php 
						if (empty($_SESSION['infotext'])) {
							echo '<p>&nbsp;</p>';
						} else {
							echo '<p> '.$_SESSION['infotext'].' </p>';
						}
					?>
				</span>
				<p>Login to join a game session</p>
			</div>
			<form action="handlers/login.php" method="post">
				<div class="input-group">
					<label class="input-label">Username: </label><div class="input-control"><input type="text" name="username"></div>
				</div>
				<div class="input-group">
					<label class="input-label">Password: </label><div class="input-control"><input type="password" name="password"></div>
				</div>
				<div class="input-group">
					<span class="input-label"></span>
					<button type="submit" value="login">Login</button>
				</div>
			</form>
		</div>
		<div style="overflow:auto; border: 1px solid red; padding: 1% 2%; width:500px; margin-left: auto; margin-right: auto; margin-top: 2em;" align="center">
			<form action="signup.php" method="post" style="margin: 0px;">
				<button type="submit">New User Signup</button>
			</form>
		</div>
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>