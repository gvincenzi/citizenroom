<?php
include_once '../actionInSession.php';
?>
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="InMediArt">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
    <script src="https://citizenroom.ddns.net/libs/external_api.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.js"></script>
	<script src="../assets/js/general_v1.js"></script>
	<script src="../assets/js/jitsi_v33.js"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="../assets/css/room.mobile.v2.css" />
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="../assets/css/room.tablet.v3.css" />
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="../assets/css/room.v3.css" />
	<meta name="viewport" content="width=device-width" />

		<script>
			$(function(){
                    const urlParams = new URLSearchParams(window.location.search);
					$('#joinMsg').text('<?php print $lang['JOINING']?>');
					BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>","<?php echo $_SESSION['room_country']?>","<?php echo $_SESSION['room_logo']?>");
					StartMeeting('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>");
			});
			
			$(window).on("beforeunload", function() { 
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "left" }
				})
			});
        </script>
</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 

  <div class="room">
	<?php if(isset($_SESSION['room_logo'])) echo '<img src="'.$_SESSION['room_logo'].'" style = "max-height:100px"></img>'?>
	<?php if(isset($_SESSION['room_title'])) echo '<h3>'.$_SESSION['room_title'].'</h3>'?>
	<div id='container' class='container' style='display:none;'>
		<div id='jitsi-meet-conf-container' style='height:100%'></div>
	</div>
	<div id='toolbox' class='toolbox' style='display:none;'>
		<h3>CitizenRoom #<?php echo $_SESSION['room_id']?></h3>
		<hr>
		<button id='btnRaiseHandOn'><?php print $lang['btnRaiseHandOn']?></button>
		<button id='btnRaiseHandOff' style="display: none;"><?php print $lang['btnRaiseHandOff']?></button>
		<button id='btnCustomMicOn'><?php print $lang['btnCustomMicOn']?></button>
		<button id='btnCustomMicOff' style="display: none;"><?php print $lang['btnCustomMicOff']?></button>
		<button id='btnCustomCameraOn'><?php print $lang['btnCustomCameraOn']?></button>
		<button id='btnCustomCameraOff' style="display: none;"><?php print $lang['btnCustomCameraOff']?></button>
		<button id='btnChatOn'><?php print $lang['btnChatOn']?></button>
		<button id='btnChatOff' style="display: none;"><?php print $lang['btnChatOff']?></button>
		<button id='btnCustomTileView'><?php print $lang['btnCustomTileView']?></button>
		<button id='btnScreenShareCustomOn'><?php print $lang['btnScreenShareCustomOn']?></button>
		<button id='btnScreenShareCustomOff' style="display: none;"><?php print $lang['btnScreenShareCustomOff']?></button>
		<button id='btnMuteEveryone'><?php print $lang['btnMuteEveryone']?></button>
		<button id='btnWhiteboard'><?php print $lang['btnWhiteboard']?></button>
		<button id='btnInvitation'><?php print $lang['btnInvitation']?></button>
		<button id='btnLobbyOn'><?php print $lang['btnLobbyOn']?></button>
		<button id='btnLobbyOff' style="display: none;"><?php print $lang['btnLobbyOff']?></button>
		<button id='btnLeave'><?php print $lang['btnLeave']?></button>
	</div>
	<h4 id='joinMsg'></h4>
  </div>
</body>
</html>
