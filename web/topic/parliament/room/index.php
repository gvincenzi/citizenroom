<?php
// Inialize session
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/web/actionInSession.php';
include $_SERVER['DOCUMENT_ROOT'].'/web/topic/bootstrap.php';
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
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="/web/assets/css/topic/parliament.<?php print $_SESSION['room_additional_data']['country'] ?? 'france'?>.css?v=<?php print time()?>" rel="stylesheet"/>
	
		<script>

			$(document).ready(function() {
				$("#primary-navigation").hide();
				topicBackground("parliament","<?php print $_SESSION['room_additional_data']['country'] ?? 'france'?>");
	   		});	

			$(function(){
                    const urlParams = new URLSearchParams(window.location.search);
					$('#joinMsg').text('<?php print $lang['JOINING']?>');
					BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>","<?php echo $_SESSION['room_logo']?>","<?php echo $_SESSION['room_custom_link']?>");
					StartMeeting('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>',"<?php echo $_SESSION['room_title']?>","<?php echo $_SESSION['room_type']?>");
			});
			
			$(window).on("beforeunload", function() { 
				$.ajax({
				  type: "POST",
				  url: "/server/service/api/TopicAPI.php",
				  data: { method: "left" }
				})
			});
        </script>
</head>

<body style="background-color: #f5f5f5">   
  <?php include $_SERVER['DOCUMENT_ROOT'].'/web/room/base_room.php';?> 

  <div id='identity_card' class='identity_card'>
	<?php echo '<img src="'.$_SESSION['room_additional_data']['photo'].'" class = "room-logo"></img>'?>
	<h4><?php echo '<a href=\''.$_SESSION['room_custom_link'].'\' target="_blank">'.$_SESSION['room_title'].'</a>' ?></h4>
	<h5><?php echo $_SESSION['room_additional_data']['h5']?></h5>
	<hr class="hr-flag"/>
	<h6><?php echo $_SESSION['room_additional_data']['h6']?></h6>
  </div>
</body>
</html>
