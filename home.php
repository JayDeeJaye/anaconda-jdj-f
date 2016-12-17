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
				<span class="infomsg">
					<?php 
						if (empty($_SESSION['infotext'])) {
							echo '<p>Let\'s start something</p>';
						} else {
							echo '<p> '.$_SESSION['infotext'].' </p>';
						}
					?>
				</span>
 			</div>
 			<table class="onlinePlayers" id="tabOnlinePlayers">
 			<tr>
				<th colspan="2">Available Players:</th>
 			</tr>
 			</table>
		</div>
		<div method="post" style="width: 70%; margin: auto;">
			<button style="display: block; margin: 15px auto;" onclick="logout()">Logout</button>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript">
			// current username
			var me = "<?php echo $_SESSION['userName'] ?>";
		</script>
		<script src="js/home.js">
		</script>
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>