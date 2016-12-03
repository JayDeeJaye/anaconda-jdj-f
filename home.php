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
 			<table class="onlinePlayers" id="tabOnlinePlayers">
 			<tr>
				<th colspan="2">Available Players:</th>
 			</tr>
 			</table>
		</div>
		<form action="handlers/logout.php" method="post" style="width: 70%; margin: auto;">
			<button type="submit" style="display: block; margin: 15px auto;">Logout</button>
		</form>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>
			// current username
			var me = "<?php echo $_SESSION['userName'] ?>";
			
			function showAjaxError (jqxhr, textStatus, thrownError) {
			    alert((typeof jqxhr.responseJSON) === "undefined" ? jqxhr.responseText : jqxhr.responseJSON.error, true);
			}

			function invitePlayer(name) {
				alert(name+" is being invited.");
				var newInvitation = new Object();
				newInvitation.inviter = me;
				newInvitation.invited = name;

				$.ajax({
			        method: "POST",
			        url: "apis/Invitations.php/",
			        data: JSON.stringify(newInvitation)
			    })
			    .done(function( data ) {
			        alert("Invitation has been stored!")
			    })
			    .fail(showAjaxError);
			}

			$(document).ready(function() {
			    $.getJSON("apis/AvailablePlayers.php",
		    	    function(data) {
		    	    	$('#tabOnlinePlayers tr').slice(1).remove();
						players = new Object();
	    	        	players = JSON.parse(JSON.stringify(data));
		    	        for(var i = 0; i < players.length; i++) {
			    	        if (players[i].userName == '<?php echo $_SESSION["userName"]; ?>') {
				    	        continue;
			    	        }
			    	        var html = '<tr>' +
			    	        		   '<td>' + players[i].userName + '</td>' +
			    	        		   "<td><button onclick=\"invitePlayer('"+players[i].userName+"')\">Invite to Play</button></td>" +
			    	        		   '</tr>';
							$("#tabOnlinePlayers").append(html);
		    	        }
		    	    })
		    	    .fail(showAjaxError);
	    	});
		</script>
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>