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
	<script src="../assets/js/jitsi_v27.js"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="../assets/css/room.mobile.v2.css" />
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="../assets/css/room.tablet.v3.css" />
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="../assets/css/room.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
        <style type="text/css">
            #map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
                height:400px;
            }
        </style>
		<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
	<meta name="viewport" content="width=device-width" />

		<script>
			$(function(){
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "subscription/check", nickname: "<?php print $_SESSION['nickname']?>", room_id: "<?php print $_SESSION['room_id']?>"}
				})
				.done(function( msg ) {
					var check = JSON.parse(msg);
					if(check.success == 'true'){
						const urlParams = new URLSearchParams(window.location.search);
						$('#joinMsg').text('<?php print $lang['JOINING']?>');
						BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>","<?php echo $_SESSION['room_country']?>","<?php echo $_SESSION['room_logo']?>");
						StartMeeting('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>");
						
						$("#btnWikipedia").on('click', function () {
							window.open("<?php echo $_SESSION['room_wikipedia']?>", '_blank'); 
						});
						
						$("#btnWebsite").on('click', function () {
							window.open("<?php echo $_SESSION['room_website']?>", '_blank'); 
						});
	
						} else {
							$('#joinMsg').html("Error joining the room. <a href='../join'>Click here</a> to rejoin correctly.");
						}	
						
						initMap("<?php echo $_SESSION['room_country']?>");
				});
			});
			
			$(window).on("beforeunload", function() { 
				$.ajax({
				  type: "POST",
				  url: "../../server/service/api/API.php",
				  data: { method: "left" }
				})
			});
			
			// Fonction d'initialisation de la carte
            function initMap(room_country) {
				if(room_country!=null && room_country!=''){
					$.ajax({
					  type: "GET",
					  url: "../../server/service/api/API.php",
					  data: { method: "country", room_country:room_country, room_id:"<?php echo $_SESSION['room_id']?>"}
					})
					.done(function( msg ) {
						console.info( msg );
						var items = JSON.parse(msg);
							$.each(items, function(i, item) {
								var room_map = L.map('map').setView([item.latitude, item.longitude], 11);
								L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
									minZoom: 1,
									maxZoom: 20
								}).addTo(room_map);
								
								var marker = L.marker([item.latitude, item.longitude]).addTo(room_map);
							});
					});
				} else $("#map").hide();
            }
        </script>
</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 

  <div class="room">
	<?php if(isset($_SESSION['room_logo'])) echo '<img src="'.$_SESSION['room_logo'].'" style = "max-height:100px"></img>'?>
	<?php if(isset($_SESSION['room_title'])) echo '<h3>'.$_SESSION['room_title'].'</h3>'?>
	<?php if(isset($_SESSION['room_place'])) echo '<h4>'.$_SESSION['room_place'].'</h4><hr/>'; else if(isset($_SESSION['room_title'])) echo '<hr/>'?>
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
		<?php if(isset($_SESSION['room_country'])){
				echo "<br>";
				echo "<h3>".$lang['CIVIC_HALL_INFO']."</h3><hr>";
				if(isset($_SESSION['room_mail']) && $_SESSION['room_mail']!='') echo '<h5>'.$lang['ROOM_MAIL'].': <strong>'.$_SESSION['room_mail'].'</strong></h5>';
				if(isset($_SESSION['room_wikipedia']) && $_SESSION['room_wikipedia']!='') echo '<button id="btnWikipedia">Wikipedia</button>';
				if(isset($_SESSION['room_website']) && $_SESSION['room_website']!='') echo '<button id="btnWebsite">Website</button>';
			}
		?>
	</div>
	<h4 id='joinMsg'></h4>
  </div>
  <div class='room' id="map"/>
</body>
</html>
