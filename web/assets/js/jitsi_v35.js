var apiObj = null;
function BindEvent(roomNumber,nickname,roomTitle,roomType,room_country,roomLogo){
	$("#btnRaiseHandOn").on('click', function () {
        apiObj.executeCommand('toggleRaiseHand');
		$("#btnRaiseHandOn").hide();
		$("#btnRaiseHandOff").show();
    });
	$("#btnRaiseHandOff").on('click', function () {
        apiObj.executeCommand('toggleRaiseHand');
		$("#btnRaiseHandOn").show();
		$("#btnRaiseHandOff").hide();
    });
    $("#btnCustomMicOn").on('click', function () {
        apiObj.executeCommand('toggleAudio');
    });
	$("#btnCustomMicOff").on('click', function () {
        apiObj.executeCommand('toggleAudio');
    });
	$("#btnMuteEveryone").on('click', function () {
        apiObj.executeCommand('muteEveryone');
    });
    $("#btnCustomCameraOn").on('click', function () {
        apiObj.executeCommand('toggleVideo');
    });
	$("#btnCustomCameraOff").on('click', function () {
        apiObj.executeCommand('toggleVideo');
    });
    $("#btnCustomTileView").on('click', function () {
        apiObj.executeCommand('toggleTileView');
    });
    $("#btnScreenShareCustomOn").on('click', function () {
        apiObj.executeCommand('toggleShareScreen');
    });
	$("#btnScreenShareCustomOff").on('click', function () {
        apiObj.executeCommand('toggleShareScreen');
    });
	$("#btnChatOn").on('click', function () {
        apiObj.executeCommand('toggleChat');
		$("#btnChatOn").css('color', 'white').hide();
		$("#btnChatOff").css('color', 'white').show();
    });
	$("#btnChatOff").on('click', function () {
        apiObj.executeCommand('toggleChat');
		$("#btnChatOn").css('color', 'white').show();
		$("#btnChatOff").css('color', 'white').hide();
	});
	$("#btnPasswordOff").on('click', function () {
		if (event.role === "moderator") {
			apiObj.executeCommand('password','');
		}
		$("#btnPasswordOff").css('color', 'white').hide();
	});
	$("#btnInvitation").on('click', function () {
		if(roomType != null && roomType == "custom") {
			copyToClipboard(encodeURI(window.location.href.replaceAll("/room/", "/invitation/") + "?room_id=" + roomNumber + "&room_title=" + roomTitle + "&room_logo=" + roomLogo + "&room_type=" + roomType));
		} else if(roomType != null && roomType == "themed"){
				copyToClipboard(encodeURI(window.location.href.replaceAll("/room/", "/invitation/")+"?room_id="+roomNumber+"&room_type="+roomType));
		} else if(roomType != null && roomType == "public"){
			copyToClipboard(encodeURI(window.location.href.replaceAll("/room/", "/invitation/")+"?room_id="+roomNumber+"&room_type="+roomType));
		}
		alert("Invitation link copied in clipboard");
    });
	$("#btnLobbyOn").on('click', function () {
        apiObj.executeCommand('toggleLobby',true);
		$("#btnLobbyOn").hide();
		$("#btnLobbyOff").show();
    });
	$("#btnLobbyOff").on('click', function () {
        apiObj.executeCommand('toggleLobby', false);
		$("#btnLobbyOn").show();
		$("#btnLobbyOff").hide();
    });
	$("#btnWhiteboard").on('click', function () {
		if(roomTitle != null && roomTitle != ""){
			window.open("https://wbo.ophir.dev/boards/"+roomTitle+"_"+roomNumber+"_"+roomType, '_blank');
		} else {
			window.open("https://wbo.ophir.dev/boards/CitizenRoom_"+roomNumber+"_"+roomType);
		}
	});
	$("#btnLeave").on('click', function () {
        	window.location.href = window.location.href.replaceAll("/web/room/", "/server/admin/left.php");
    	});
}

function copyToClipboard(text) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val(text).select();
	document.execCommand("copy");
	$temp.remove();
}

function StartMeeting(roomNumber,nickname,roomTitle,roomType){
    const domain = 'citizenroom.ddns.net';
	if(roomTitle == null || roomTitle == ""){
		roomTitle = 'CitizenRoom';
	}
    var roomName = roomTitle + "_" + roomNumber + "_" + roomType;

    const options = {
        roomName: roomName.replace("'", "_"),
        width: '100%',
        height: '100%',
        parentNode: document.querySelector('#jitsi-meet-conf-container'),
        DEFAULT_REMOTE_DISPLAY_NAME: 'New User',
        userInfo: {
            displayName: nickname
        },
        interfaceConfigOverwrite: {
            TOOLBAR_BUTTONS: ['sharedvideo','fullscreen','chat','microphone','camera','hangup','tileview','videobackgroundblur','raisehand']
        },
        onload: function () {
            $('#joinMsg').hide();
            $('#container').show();
            $('#toolbox').show();
        }
    };
    apiObj = new JitsiMeetExternalAPI(domain, options);
	apiObj.executeCommand('subject', roomTitle + "_" + roomNumber);
    apiObj.addEventListeners({
        audioMuteStatusChanged: function (data) {
            if(data.muted){
                $("#btnCustomMicOn").show();
				$("#btnCustomMicOff").hide();
            } else {
                $("#btnCustomMicOn").hide();
				$("#btnCustomMicOff").show();
			}
        },
        videoMuteStatusChanged: function (data) {
            if(data.muted){
				$("#btnCustomCameraOn").show();
				$("#btnCustomCameraOff").hide();
            } else {
                $("#btnCustomCameraOn").hide();
				$("#btnCustomCameraOff").show();
			}
        },
        tileViewChanged: function (data) {
            
        },
		chatUpdated: function (data) {
			if(data.unreadCount > 0){
                $("#btnChatOn").css('color', 'red');
				$("#btnChatOff").css('color', 'red');
				if(data.unreadCount == 1)
				notifyMe('New message received');
			}
				
        },
		incomingMessage: function (data) {
			
		},
        screenSharingStatusChanged: function (data) {
            if(data.on){
				$("#btnScreenShareCustomOn").hide();
				$("#btnScreenShareCustomOff").show();
            } else {
                $("#btnScreenShareCustomOn").show();
				$("#btnScreenShareCustomOff").hide();
			}
        },
        participantJoined: function(data){
			notifyMe(data.displayName + ' joined the room');
			// TODO ALL MODERATORS ? apiObj.executeCommand('grantModerator', data.id);
        },
        participantLeft: function(data){
        },
		readyToClose: function(data){
			$('#jitsi-meet-conf-container').empty();
			$('#toolbox').hide();
			$('#container').hide();
			$('#joinMsg').show().text('You left the conference');

			$.ajax({
			  type: "POST",
			  url: "../../server/service/api/API.php",
			  data: { method: "left" }
			}).done(function( msg ) {
				var left = JSON.parse(msg);
				window.location.href = window.location.href.replaceAll("/web/room/", "/web/join/");
			});
        },
		raiseHandUpdated: function(data){
		},
		participantRoleChanged: function(data){
			if(roomType=="themed" && data.role === "moderator"){
				$("#btnPasswordOff").css('color', 'white').show();
			}
        }
    });
}

	function notifyMe(text) {
		var img = "https://citizenroom.altervista.org/web/assets/img/icon.jpg";
		
	  // Let's check if the browser supports notifications
	  if (!("Notification" in window)) {
		alert("This browser does not support desktop notification");
	  }

	  // Let's check whether notification permissions have already been granted
	  else if (Notification.permission === "granted") {
		// If it's okay let's create a notification
		// var notification = new Notification(text);
		var notification = new Notification('CitizenRoom', {
		  body: text,
		  icon: img
		});
	  }

	  // Otherwise, we need to ask the user for permission
	  else if (Notification.permission !== "denied") {
		Notification.requestPermission().then(function (permission) {
		  // If the user accepts, let's create a notification
		  if (permission === "granted") {
			var notification = new Notification("CitizenRoom", {
			  body: text,
			  icon: img
			});
		  }
		});
	  }

	  // At last, if the user has denied notifications, and you
	  // want to be respectful there is no need to bother them any more.
	}
