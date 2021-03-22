var apiObj = null;

function BindEvent(roomNumber,nickname,password,serial){
    $("#btnCustomMicOn").on('click', function () {
        apiObj.executeCommand('toggleAudio');
    });
	$("#btnCustomMicOff").on('click', function () {
        apiObj.executeCommand('toggleAudio');
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
	$("#btnInvitation").on('click', function () {
		if(serial != null && serial != ""){
			copyToClipboard(window.location.href.replaceAll("/room/", "/invitation/")+"&room_id="+roomNumber+"&password="+password+"&serial="+serial);
		}  else {
			copyToClipboard(window.location.href.replaceAll("/room/", "/invitation/")+"?room_id="+roomNumber);
		}
		alert("Invitation link copied in clipboard");
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

function StartMeeting(roomNumber,nickname,password,serial){
    const domain = 'meet.jit.si';
	
    var roomName;
	if(serial != null && serial != ""){
		roomName = 'CitizenRoom' + roomNumber + "_" + serial;
	} else {
		roomName = 'CitizenRoom' + roomNumber;
	}
    console.info("roomName:"+roomName);
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
            disableRemoteMute: true,
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
            DEFAULT_REMOTE_DISPLAY_NAME: 'New User',
            TOOLBAR_BUTTONS: ['sharedvideo','fullscreen']
        },
        onload: function () {
            //alert('loaded');
            $('#joinMsg').hide();
            $('#container').show();
            $('#toolbox').show();
        }
    };
    apiObj = new JitsiMeetExternalAPI(domain, options);
		
    apiObj.addEventListeners({
		/*participantRoleChanged: function (event) {
			console.info(event);
			if(event.role == 'moderator') {
				apiObj.executeCommand('toggleLobby', true);
			}
		},*/
		
		// set new password for channel
		participantRoleChanged: function(event) {
			if (event.role === "moderator") {
				apiObj.executeCommand('password', password);
			}
		},		
		// join a protected channel
		passwordRequired: function(event) {
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
                $("#btnChat").css('color', 'red');
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
			notifyMe(data.displayName+" joined the room")
        },
        participantLeft: function(data){
            console.log('participantLeft', data);
        }
    });

    apiObj.executeCommand('subject', 'Citizen Room Conference');
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

