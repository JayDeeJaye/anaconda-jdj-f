<?php
session_start();

if (empty($_SESSION['userName'])) {
	header("Location: index.php");
	exit();
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
				<h1>Welcome, <?php echo $_SESSION['userName'] ?> </h1>
 			</div>
		</div>
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>