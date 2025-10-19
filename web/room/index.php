<?php
// Inialize session
session_start();
include_once '../actionInSession.php';
include '../bootstrap.php';
?>
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="InMediArt">
    <script src="https://citizenroom.ddns.net/libs/external_api.min.js"></script>
	<script src="../assets/js/jitsi.js?v=<?php print time()?>"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="../assets/css/room.mobile.css?v=<?php print time()?>" rel="stylesheet"/>
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="../assets/css/room.tablet.css?v=<?php print time()?>" rel="stylesheet"/>
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="../assets/css/room.css?v=<?php print time()?>" rel="stylesheet"/>
		<script>
			$(document).ready(function() {
				$("#primary-navigation").hide();
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
				  url: "../../server/service/api/API.php",
				  data: { method: "left" }
				})
			});
        </script>
</head>

<body style="background-color: #f5f5f5"> 
	<?php include '../header.php';?>   
  	<?php include 'base_room.php';?> 
</body>
</html>
