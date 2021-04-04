var apiObj = null;
var newPassword = null;
function BindEvent(roomNumber,nickname,serial,stream_key){
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
    });
	$("#btnChatOff").on('click', function () {
        apiObj.executeCommand('toggleChat');
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
		if(serial != null && serial != ""){
			copyToClipboard(window.location.href.replaceAll("/room/", "/invitation/")+"&room_id="+roomNumber+"&serial="+serial);
		}  else {
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
	$("#btnLiveInvitation").on('click', function () {
		copyToClipboard(window.location.href.replaceAll("/room", "/invitation")+"&room_id="+roomNumber+"&password="+password+"&serial="+serial+"&room_type=live");
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

function StartMeeting(roomNumber,nickname,password,serial,withPassword){
    const domain = 'meet.jit.si';
	
    var roomName;
	if(serial != null && serial != ""){
		roomName = 'CitizenRoom' + roomNumber + "_" + serial;
	} else {
		roomName = 'CitizenRoom' + roomNumber;
	}
    // console.info("roomName:"+roomName);
    const options = {
        roomName: roomName,
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
            TOOLBAR_BUTTONS: ['sharedvideo','fullscreen','chat','microphone','camera']
        },
        onload: function () {
            $('#joinMsg').hide();
            $('#container').show();
            $('#toolbox').show();
        }
    };
    apiObj = new JitsiMeetExternalAPI(domain, options);
	
    apiObj.addEventListeners({
		// set new password for channel
		participantRoleChanged: function(event) {
			if (event.role === "moderator" && withPassword === 1) {
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "rooms/wait", wait: true, room_id: roomNumber, serial: serial }
				}).done(function( msg ) {
							newPassword = CryptoJS.MD5(nickname+roomNumber+serial+password).toString();
							//console.info("participantRoleChanged : " + newPassword + " < " + nickname+roomNumber+serial+password);
							
							// Mining new block in BE
							$.ajax({
							  type: "POST",
							  url: "../../server/service/api/API.php",
							  data: { method: "rooms/hash", nickname: nickname, room_id: roomNumber, serial: serial, previous_hash: password }
							}).done(function( msg ) {
								apiObj.executeCommand('password', newPassword);
							});
					})
				
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
            if(data.isOpen){
				$("#btnChatOn").css('color', 'white').hide();
				$("#btnChatOff").css('color', 'white').show();
            } else {
                $("#btnChatOn").css('color', 'white').show();
				$("#btnChatOff").css('color', 'white').hide();
			}
			
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
        }
    });

    apiObj.executeCommand('subject', 'CitizenRoom Conference');
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

