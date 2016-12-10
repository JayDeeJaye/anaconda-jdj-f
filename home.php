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
				var newInvitation = new Object();
				newInvitation.inviter = me;
				newInvitation.invited = name;

				$.ajax({
			        method: "POST",
			        url: "apis/Invitations.php/",
			        data: JSON.stringify(newInvitation)
			    })
			    .done(function( data ) {
					
			    })
			    .fail(showAjaxError);
			}

			function makePlayerButton(name,label) {
				return '<tr>' +
	     		   '<td>' + name + '</td>' +
	     		   "<td><button id=\"p_"+name+"\" class=\"btn_invite\">"+label+"</button></td>" +
	     		   '</tr>'
				}

			$(document).ready(function() {

				$.getJSON("apis/OnlinePlayers.php",
		    	    function(data) {
		    	    	$('#tabOnlinePlayers tr').slice(1).remove();
						var players = new Object();
	    	        	players = JSON.parse(JSON.stringify(data));
		    	        for(var i in players) {
							var p = players[i];
			    	        if (p.name == me) {
				    	        continue;
			    	        }
							var html;
			    	        switch(p.status) {
				    	        case "INVITING":
					    	        continue;
					    	        break;
				    	        case "AVAILABLE":
				    	        	html = makePlayerButton(p.name,"Invite to Play");
				    	        	break;
				    	        case "INVITED":
					    	        if (p.invitedBy == me) {
					    	        	html = makePlayerButton(p.name,"Waiting...");
					    	        } else {
						    	        continue;
					    	        }
			    	        }     
    	        		   $("#tabOnlinePlayers").append(html);
		    	        }
		    	    })
		    	    .fail(showAjaxError);
	    	});

			// Invitation button handler
			$("#tabOnlinePlayers").on("click", "button.btn_invite", function () {
 				var p = this.id.split("_")[1];
 				invitePlayer(p);
 				this.innerHTML="Waiting...";
 				$(".btn_invite").each( function (i) {
     				$(this).attr("disabled",true);
 				});
//				alert("Click!");
			});

		</script>
	</body>
</html>
<?php 
unset($_SESSION['infotext']);
?>