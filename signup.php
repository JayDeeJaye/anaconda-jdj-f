<?php
	session_start();
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
				<p>New User Signup</p>
				<span style="color:red;">
					<?php 
						if (empty($_SESSION['infotext'])) {
							echo '<p>&nbsp;</p>';
						} else {
							echo '<p> '.$_SESSION['infotext'].' </p>';
						}
					?>
				</span>
			</div>
			<form action="handlers/register.php" method="post">
				<div class="input-group">
					<label class="input-label">New Username: </label><div class="input-control"><input type="text" name="username"></div>
				</div>
				<div class="input-group">
					<label class="input-label">New Password: </label><div class="input-control"><input type="text" name="password"></div>
				</div>
				<div class="input-group">
					<label class="input-label">Confirm Password: </label><div class="input-control"><input type="text" name="passwordAgain"></div>
				</div>
				<div class="input-group">
					<span class="input-label"></span>
					<button type="submit" value="register">Register</button>
				</div>
			</form>
		</div>
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>
