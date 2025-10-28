<?php
// Inialize session
session_start();
include '../../actionInSession.php';
include '../../bootstrap.php';
?>
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="InMediArt">
    <script src="https://citizenroom.ddns.net/libs/external_api.min.js"></script>
	<script src="/web/assets/js/jitsi.js?v=<?php print time()?>"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="/web/assets/css/room.mobile.css?v=<?php print time()?>" rel="stylesheet"/>
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="/web/assets/css/room.tablet.css?v=<?php print time()?>" rel="stylesheet"/>
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="/web/assets/css/room.css?v=<?php print time()?>" rel="stylesheet"/>
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="/web/assets/css/topic/municipality.<?php print $_SESSION['room_additional_data']['country'] ?? 'france'?>.css?v=<?php print time()?>" rel="stylesheet"/>
	
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	
		<script>

			$(document).ready(function() {
				$("#primary-navigation").hide();
				topicBackground("municipality","<?php print $_SESSION['room_additional_data']['country'] ?? 'france'?>");
				initMap();
	   		});	

			$(function(){
                    const urlParams = new URLSearchParams(window.location.search);
					$('#joinMsg').text('<?php print $lang['JOINING']?>');
					BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>","<?php echo $_SESSION['room_logo']?>","<?php echo $_SESSION['room_custom_link']?>","<?php echo $_SESSION['room_topic_name']?>","<?php echo $_SESSION['room_topic_domain']?>");
					StartMeeting('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>");
			});
			
			$(window).on("beforeunload", function() { 
				$.ajax({
				  type: "POST",
				  url: "/server/service/api/TopicAPI.php",
				  data: { method: "left" }
				})
			});

			function initMap(){
				// Coordonnées du point à afficher
				const lat = <?php echo $_SESSION['room_additional_data']['lat']?>; // latitude
				const lng = <?php echo $_SESSION['room_additional_data']['lng']?>;  // longitude

				// Initialisation de la carte
				const map = L.map('info_card').setView([lat, lng], 13);

				// Ajout de la couche OpenStreetMap
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; OpenStreetMap contributors'
				}).addTo(map);

				// Ajout d'un marqueur aux coordonnées
				L.marker([lat, lng]).addTo(map)
				.openPopup();
			}
        </script>
</head>

<body style="background-color: #f5f5f5">   
	<?php include '../../../header.php';?>   
 	<?php include '../../../room/base_room.php';?> 

  <div id='identity_card' class='identity_card'>
	<?php echo '<img src="'.$_SESSION['room_additional_data']['photo'].'" class = "room-logo"></img>'?>
	<h4><?php echo '<a href=\''.$_SESSION['room_custom_link'].'\' target="_blank">'.$_SESSION['room_title'].'</a>' ?></h4>
	<h5><?php echo $_SESSION['room_additional_data']['h5']?></h5>
	<h6><?php echo $_SESSION['room_additional_data']['h6']?></h6>
	<hr class="hr-flag"/>
	<div id='info_card' class='info_card'></div>
  </div>

  
</body>
</html>
