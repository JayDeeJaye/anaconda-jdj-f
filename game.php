<?php
	session_start();
?>
<html>
	<head>
		<title>Battleship!</title>
		<link rel="stylesheet" type="text/css" href="css/warzone.css">
	</head>
	<body>
		<button onclick="window.location.assign('handlers/logout.php')">Logout</button>
		<h1 align="center">Welcome to the War Zone!!!</h1>
		<div style="width: 1200px; height: 400px; margin: auto;">
			<img style="margin-top: 10px; margin-bottom: 10px" src="images/water.png" width="1200px" height="400px">
			<img style="margin-top: 10px; margin-bottom: 10px" src="images/water.png" width="1200px" height="400px">
		</div>
		
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>