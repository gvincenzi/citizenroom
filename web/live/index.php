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
	<script src="../assets/js/jitsi_v14.js"></script>
	<link rel="stylesheet" media="all and (max-width: 500px)" href="../assets/css/room.mobile.v2.css" />
	<link rel="stylesheet" media="all and (min-width: 500px) and (max-width: 1100px)" href="../assets/css/room.tablet.v2.css" />
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
					console.info( msg );
					var check = JSON.parse(msg);
					if(check.success == 'true'){
						const urlParams = new URLSearchParams(window.location.search);
						$('#joinMsg').text('<?php print $lang['JOINING']?>');
						$.ajax({
						  type: "GET",
						  url: "../../server/service/api/API.php",
						  data: { method: "rooms/get/id", room_id: "<?php print $_SESSION['room_id']?>", serial: "<?php print $_SESSION['serial']?>" }
						})
						.done(function( msg ) {
							var room = JSON.parse(msg);
							BindEvent('<?php echo $_SESSION['room_id']?>','<?php echo $_SESSION['nickname']?>','<?php echo $_SESSION['password']?>','<?php echo $_SESSION['serial']?>');
							JoinYoutubeLive(room.channel_id);
						});
					} else {
						$('#joinMsg').html("Error joining the room live. <a href='../join?type=live'>Click here</a> to rejoin correctly.");
					}
						
				});
			});
			
			function BindEvent(roomNumber,nickname,password,serial){
				$("#btnInvitation").on('click', function () {
					copyToClipboard(window.location.href.replaceAll("/live", "/invitation")+"&room_id="+roomNumber+"&password="+password+"&serial="+serial+"&room_type=live");
					alert("Invitation link copied in clipboard");
				});
				$("#btnLeave").on('click', function () {
					window.location.href = window.location.href.replaceAll("/web/live/", "/server/admin/left.php");
				});
			}
			
			function JoinYoutubeLive(channelID){
				$('#youtube-live-container').append('<iframe width="100%" height="100%" src="https://www.youtube.com/embed/live_stream?channel='+channelID+'" frameborder="0" allowfullscreen autoplay></iframe>')
				$('#joinMsg').hide();
				$('#container').show();
				$('#toolbox').show();
			}
			
			function copyToClipboard(text) {
				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val(text).select();
				document.execCommand("copy");
				$temp.remove();
			}
        </script>
</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 

  <div class="room">
    <?php if(isset($_SESSION['room_logo'])) echo '<img src="'.$_SESSION['room_logo'].'" style = "max-height:100px"></img>'?>
	<?php if(isset($_SESSION['room_title'])) echo '<h3>'.$_SESSION['room_title'].'</h3><hr/>'?>
	<div id='container' class='container' style='display:none;'>
		<div id='youtube-live-container' style='height:100%'></div>
	</div>
	<div id='toolbox' class='toolbox' style='display:none;'>
		<h3>CitizenRoom Live#<?php echo $_SESSION['room_id']?></h3>
		<?php if(isset($_SESSION['user_serial'])) echo '<h4>Partner ID #'.$_SESSION['user_serial'].'</h4>'?>
		<button id='btnInvitation'>Live : <?php print $lang['btnInvitation']?></button>
		<button id='btnLeave'><?php print $lang['btnLeave']?></button>
	</div>
	<h4 id='joinMsg'></h4>
  </div>
</body>
</html>