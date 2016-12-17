/**
 * 
 */

// Global state variables
var gameState = "IDLE";
// Use timeouts to control server interaction instead of intervals
var invitationTimerId;
var responseTimerId;
var playersTimerId;
var timerInterval = 500;

function showAjaxError (jqxhr, textStatus, thrownError) {
    alert((typeof jqxhr.responseJSON) === "undefined" ? jqxhr.statusText : jqxhr.responseJSON.error, true);
}

// When it's time to go to the game, clear the players list timer
function goToGame() {
	clearTimeout(playersTimerId);
	window.location.assign("game.php");
}

function invitePlayer(name) {
	var newInvitation = new Object();
	newInvitation.fromPlayer = me;
	newInvitation.toPlayer = name;

	$.ajax({
        method: "POST",
        url: "apis/Invitations.php/",
        data: JSON.stringify(newInvitation)
    })
    .success(function( data ) {
    	// cancel any outstanding invitation watchers
    	// and start the response watcher
    	clearTimeout(invitationTimerId);
    	responseTimerId = setTimeout(checkForResponse,timerInterval);
    })
    .fail(showAjaxError);
}

function makePlayerButton(name,label) {
	return '<tr>' +
	   '<td>' + name + '</td>' +
	   "<td><button id=\"p_"+name+"\" class=\"btn_invite\">"+label+"</button></td>" +
	   '</tr>'
	}

function disableInviteButtons() {
	$(".btn_invite").each( function (i) {
		$(this).attr("disabled",true);
	});
}

function acceptInvitation(invitation) {
	invitation.status = "accepted";
	$.ajax({
        type: "PUT",
        url: "apis/Invitations.php/"+invitation.fromPlayer,
        data: JSON.stringify(invitation),
        success: function(response_data,status,jqxhr) {
            	goToGame();
        	},
        error: function(jqxhr, status, error) {
           alert("Uh-oh! "+error);                
        },
        dataType: "json"
    });
}

function rejectInvitation(invitation) {
	invitation.status = "rejected";
	$.ajax({
        type: "PUT",
        url: "apis/Invitations.php/"+invitation.fromPlayer,
        data: JSON.stringify(invitation),
        success: function(response_data,status,jqxhr) {
	        	invitationTimerId = setTimeout(checkForInvitation,timerInterval);
        	},
        error: function(jqxhr, status, error) {
           alert("Uh-oh! "+error);                
        },
        dataType: "json"
    });
}

function clearInvitation(invitation) {
	$.ajax({
		type: "DELETE",
		url: "apis/Invitations.php/"+invitation.fromPlayer,
		success: function(data,status,jqxhr) {
			// no worries
		},
		error: function(jqxhr, status, error) {
           alert("Uh-oh! "+error);
		}
	})
}

function setGameOn(invitation) {
	invitation.status = "gameon";
	$.ajax({
        type: "PUT",
        url: "apis/Invitations.php/"+invitation.fromPlayer,
        data: JSON.stringify(invitation),
        success: function(response_data,status,jqxhr) {
	        	goToGame();
        	},
        error: function(jqxhr, status, error) {
           alert("Uh-oh! "+error);                
        },
        dataType: "json"
    });
}

function checkForResponse() {
	$.getJSON("apis/Invitations.php/"+me,
	    function(data) {
			var invitation = JSON.parse(JSON.stringify(data));
			if (invitation.fromPlayer === me) {
	    		if (invitation.status === "accepted") {
	    			setGameOn(invitation);
	    		} else if (invitation.status === "rejected") {
	    			alert(invitation.toPlayer+" turned you down.");
	    			clearInvitation(invitation);
	    			gameState = "IDLE";
	    			showOnlinePlayers();
	    			invitationTimerId = setTimeout(checkForInvitation,timerInterval);
	    		} else if (invitation.status === "pending"){
	    			// Keep watching
	    			responseTimerId = setTimeout(checkForResponse,timerInterval);
	    		}
			}
	});
}

function checkForInvitation() {
	$.getJSON("apis/Invitations.php/"+me,
	    function(data) {
			var invitation = JSON.parse(JSON.stringify(data));
			if (invitation.toPlayer === me) {
	    		if (invitation.status === "pending") {
					if (confirm(invitation.fromPlayer+" invited you to a game. Accept?")) {
	    	    		acceptInvitation(invitation);
		    		} else {
	    	    		rejectInvitation(invitation);
		    		}
	    		}
			}
		}
	)
	.fail(function (jqxhr, textStatus, thrownError) {
		// Not found just means there are no invitations. Keep watching.
    	if (jqxhr.status == "404") {
        	invitationTimerId = setTimeout(checkForInvitation,timerInterval);
    	} else {
    		showAjaxError(jqxhr, textStatus, thrownError);
    	}
    });
}

function showOnlinePlayers() {
	// Show the available players
	$.getJSON("apis/OnlinePlayers.php",
	    function(data) {
	    	$('#tabOnlinePlayers tr').slice(1).remove();
			var players = JSON.parse(JSON.stringify(data));
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
		    	        	gameState = 'WAITING';
		    	        } else {
			    	        continue;
		    	        }
    	        }     
    		   $("#tabOnlinePlayers").append(html);
	        }

	        if (gameState == "WAITING") {
	        	disableInviteButtons();
	        }
	    })
	    .fail(showAjaxError)
	    // Call this function again in 200ms
		.complete(function () {
	    	playersTimerId = setTimeout(showOnlinePlayers,timerInterval);
	    })
}

$(document).ready(function() {
	// See who's logged in
	showOnlinePlayers();
	// If we're reconnecting to an existing session, and
	// we're waiting for a response, start the watcher
	if (gameState == "WAITING") {
		responseTimerId = setTimeout(checkForResponse,timerInterval);
	} else {
		checkForInvitation();
	}
});

// Invitation button handler
$("#tabOnlinePlayers").on("click", "button.btn_invite", function () {
	var p = this.id.split("_")[1];
	invitePlayer(p);
	this.innerHTML="Waiting...";
	disableInviteButtons();
});

// Stop all the timers and go to the logout handler
function logout() {
	clearTimeout(invitationTimerId);
	clearTimeout(responseTimerId);
	clearTimeout(playersTimerId);
	window.location.assign("handlers/logout.php");
}

