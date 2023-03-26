var apiObj = null;
var newPassword = null;
function BindEvent(roomNumber,nickname,serial,roomPassword,stream_key,roomTitle,room_country){
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
	$("#btnStreamOn").on('click', function () {
        apiObj.executeCommand('startRecording', {
			mode: 'stream',
			youtubeStreamKey: stream_key
		});
		$("#btnStreamOn").hide();
		$("#btnStreamOff").show();
    });
	$("#btnStreamOff").on('click', function () {
        apiObj.executeCommand('stopRecording', 'stream');
		$("#btnStreamOn").show();
		$("#btnStreamOff").hide();
    });
	$("#btnInvitation").on('click', function () {
		if(room_country != null && room_country != ""){
			copyToClipboard(encodeURI(window.location.href.replaceAll("/room/", "/invitation/")+"?room_id="+roomNumber+"&room_country="+room_country+"&room_title="+roomTitle));
		} else if(serial != null && serial != ""){
			copyToClipboard(encodeURI(window.location.href.replaceAll("/room/", "/invitation/")+"&room_id="+roomNumber+"&password="+roomPassword+"&serial="+serial+"&room_title="+roomTitle));
		} else {
			copyToClipboard(window.location.href.replaceAll("/room/", "/invitation/")+"?room_id="+roomNumber);
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
		if(roomTitle != null && roomTitle != "" && serial != null && serial != ""){
			window.open("https://wbo.ophir.dev/boards/"+roomTitle+"_"+roomNumber+"_"+serial, '_blank');
		} else {
			window.open("https://wbo.ophir.dev/boards/CitizenRoom_"+roomNumber);
		}
	});
	$("#btnLiveInvitation").on('click', function () {
		copyToClipboard(window.location.href.replaceAll("/room", "/invitation")+"&room_id="+roomNumber+"&password="+roomPassword+"&serial="+serial+"&room_type=live");
		alert("Invitation link for Live Streaming copied in clipboard");
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

function StartMeeting(roomNumber,nickname,password,serial,roomTitle){
    const domain = 'meet.jit.si';
	if(roomTitle == null || roomTitle == ""){
		roomTitle = 'CitizenRoom';
	}
    var roomName;
	if(serial != null && serial != ""){
		roomName = roomTitle + "_" + roomNumber + "_" + serial;
	} else {
		roomName = roomTitle + "_" + roomNumber;
	}
    // console.info("roomName:"+roomName);
    const options = {
        roomName: roomName.replace("'", "_"),
        width: '100%',
        height: '100%',
        parentNode: document.querySelector('#jitsi-meet-conf-container'),
        DEFAULT_REMOTE_DISPLAY_NAME: 'New User',
        userInfo: {
            displayName: nickname
        },
        configOverwrite:{
            doNotStoreRoom: true,
            startVideoMuted: 0,
            startWithVideoMuted: true,
            startWithAudioMuted: true,
            enableWelcomePage: false,
            prejoinPageEnabled: false,
            disableRemoteMute: false,
			defaultLanguage: 'en',
            remoteVideoMenu: {
                disableKick: false
            },
        },
        interfaceConfigOverwrite: {
			defaultLanguage: 'en',
            filmStripOnly: false,
            SHOW_JITSI_WATERMARK: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
			LANG_DETECTION: true,
            DEFAULT_REMOTE_DISPLAY_NAME: 'New Participant',
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
		// set new password for channel
		participantRoleChanged: function(event) {
			if (event.role === "moderator") {
				// Mining new block in BE
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "rooms/hash", nickname: nickname, room_id: roomNumber, serial: serial }
				}).done(function( msg ) {
					apiObj.executeCommand('password', password);
				});
			}
		},		
		// join a protected channel
		passwordRequired: function(event) {
			//console.info("passwordRequired : " + password);
			
			apiObj.executeCommand('password', password);
		},
        readyToClose: function () {
            //alert('going to close');
            $('#jitsi-meet-conf-container').empty();
            $('#toolbox').hide();
            $('#container').hide();
            $('#joinMsg').show().text('You left the conference');
        },
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
            //console.log('participantJoined', data);
			setTimeout(
			  function() 
			  {
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "rooms/ticket/validate", nickname: data.displayName, room_id: roomNumber, serial: serial }
				}).done(function( msg ) {
					var validation = JSON.parse(msg);
					console.info(validation);
					notifyMe(validation.message);
				});
			  }, 5000);
        },
        participantLeft: function(data){
            //console.log('participantLeft', data);
        },
		readyToClose: function(data){
            //console.log('readyToClose', data);
			$.ajax({
			  type: "POST",
			  url: "../../server/service/api/API.php",
			  data: { method: "left" }
			}).done(function( msg ) {
				var left = JSON.parse(msg);
				console.info(left);
				window.location.href = window.location.href.replaceAll("/web/room/", "/web/join/");
			});
        },
		raiseHandUpdated: function(data){
            //console.log('raiseHandUpdated', data);
        }
    });
}

	function notifyMe(text) {
		var img = "https://citizenroom.altervista.org/web/assets/img/icon.png";
		
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

