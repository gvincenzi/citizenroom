<?php include $_SERVER['DOCUMENT_ROOT'].'/web/header.php';?> 

  <div class="room">
	<?php if(isset($_SESSION['room_title'])) echo '<div class="room-title">'.$_SESSION['room_title'].'</div>'?>
	<div id='container' class='container' style='display:none;'>
		<div id='jitsi-meet-conf-container' style='height:100%'></div>
	</div>
	<div id='toolbox' class='toolbox' style='display:none;'>
	    <?php if(isset($_SESSION['room_logo'])) echo '<img src="'.$_SESSION['room_logo'].'" class = "room-logo"></img>'?>
		<h6>CitizenRoom #<?php echo $_SESSION['room_id']?></h6>
		<button id='btnCustomLink' <?php if(!isset($_SESSION['room_custom_link']) || $_SESSION['room_custom_link']==="") echo 'style="display: none;"'?>><?php print $lang['btnCustomLink']?></button>
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
		<button id='btnLobbyOn' style="display: none;"><?php print $lang['btnLobbyOn']?></button>
		<button id='btnLobbyOff' style="display: none;"><?php print $lang['btnLobbyOff']?></button>
		<button id='btnLeave' style="display: none;"><?php print $lang['btnLeave']?></button>
	</div>
	<h6 id='joinMsg' style="color: #fff"></h6>
  </div>