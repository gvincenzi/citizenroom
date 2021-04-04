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
    <script src="https://meet.jit.si/external_api.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.js"></script>
	<script src="../assets/js/general_v1.js"></script>
	<script src="../assets/js/jitsi_v12.js"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="../assets/css/room.mobile.css" />
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="../assets/css/room.tablet.css" />
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="../assets/css/room.css" />
	<meta name="viewport" content="width=device-width" />

		<script>
			$(function(){
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "subscription/check", nickname: "<?php print $_SESSION['nickname']?>", room_id: "<?php print $_SESSION['room_id']?>", serial: "<?php print $_SESSION['serial']?>" }
				})
				.done(function( msg ) {
					var check = JSON.parse(msg);
					if(check.success == 'true'){
						const urlParams = new URLSearchParams(window.location.search);
						$('#joinMsg').text('<?php print $lang['JOINING']?>');
						BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>','<?php echo $_SESSION['serial']?>','<?php echo $_SESSION['user_stream_key']?>');
						StartMeeting('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>','<?php echo $_SESSION['room_password']?>','<?php echo $_SESSION['serial']?>',<?php echo $_SESSION['withPassword']?>);
						
						} else {
							$('#joinMsg').html("Error joining the room. <a href='../join'>Click here</a> to rejoin correctly.");
						}	
				});
			});
			
			$(window).on("beforeunload", function() { 
				$.ajax({
				  type: "GET",
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
	<?php if(isset($_SESSION['room_title'])) echo '<h3>'.$_SESSION['room_title'].'</h3><hr/>'?>
	<div id='container' class='container' style='display:none;'>
		<div id='jitsi-meet-conf-container' style='height:100%'></div>
	</div>
	<div id='toolbox' class='toolbox' style='display:none;'>
		<h3>CitizenRoom #<?php echo $_SESSION['room_id']?></h3>
		<?php if(isset($_SESSION['serial'])) echo '<h4>Partner ID #'.$_SESSION['serial'].'</h4>'?>
		<hr>
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
		<button id='btnInvitation'><?php print $lang['btnInvitation']?></button>
		<button id='btnLeave'><?php print $lang['btnLeave']?></button>
		<?php if(isset($_SESSION['user'])){
				echo "<hr>";
				echo "<button id='btnLobbyOn'>".$lang['btnLobbyOn']."</button>";
				echo "<button id='btnLobbyOff' style=\"display: none;\">".$lang['btnLobbyOff']."</button>";
				if(isset($_SESSION['user']) && $_SESSION['user_stream_key']!=''){
					echo "<button id='btnStreamOn'>".$lang['btnStreamOn']."</button>";
					echo "<button id='btnStreamOff' style=\"display: none;\">".$lang['btnStreamOff']."</button>";
					echo "<button id='btnLiveInvitation'>Live : ".$lang['btnInvitation']."</button>";
				}
			}
		?>
	</div>
	<h4 id='joinMsg'></h4>
  </div>
</body>
</html>