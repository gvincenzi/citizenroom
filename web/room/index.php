<?php
include_once '../actionInSession.php';
?>
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="InMediArt">
	<script src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
    <script src="https://meet.jit.si/external_api.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.js"></script>
	<script src="../assets/js/general_v1.js"></script>
	<script src="../assets/js/jitsi_v2.js"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="../assets/css/room.mobile.css" />
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="../assets/css/room.tablet.css" />
	<link rel="stylesheet" media="all and (min-width: 1100px)" href="../assets/css/room.css" />
	<meta name="viewport" content="width=device-width" />

		<script>
            $(function(){
                const urlParams = new URLSearchParams(window.location.search);
                $('#joinMsg').text('<?php print $lang['JOINING']?>');
				BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>','<?php echo $_SESSION['password']?>','<?php echo $_SESSION['serial']?>');
				StartMeeting('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>','<?php echo $_SESSION['password']?>','<?php echo $_SESSION['serial']?>');
           });
        </script>
</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 

  <div class="room">
	<div id='container' class='container' style='display:none;'>
		<div id='jitsi-meet-conf-container' style='height:100%'></div>
	</div>
	<div id='toolbox' class='toolbox' style='display:none;'>
		<h3>CitizenRoom #<?php echo $_SESSION['room_id']?></h3>
		<?php if(isset($_SESSION['serial'])) echo '<h4>Partner ID #'.$_SESSION['serial'].'</h4>'?>
		<button id='btnCustomMic'>Turn on mic</button>
		<button id='btnCustomCamera'>Turn on camera</button>
		<button id='btnChat'>Show chat</button>
		<button id='btnCustomTileView'>Roommates view</button>
		<button id='btnScreenShareCustom'>Start sharing your screen</button>
		<button id='btnInvitation'>Send invitation link</button>
		<button id='btnLeave'>Leave the room</button>
	</div>
	<h4 id='joinMsg'></h4>
  </div>
</body>
</html>