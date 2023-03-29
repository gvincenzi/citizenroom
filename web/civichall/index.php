<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/'. prefered_language($available_languages) .'.php';

// Inialize session
session_start();
if(!isset($_SESSION['action'])){
	$_SESSION['action']='room';
}
if (isset($_SESSION['nickname']) && isset($_SESSION['room_id'])) {
	unset($_SESSION['room_id']);
	unset($_SESSION['nickname']);
	unset($_SESSION['room_type']);
	unset($_SESSION['room_title']);
	unset($_SESSION['room_logo']);
	unset($_SESSION['room_country']);
	unset($_SESSION['room_place']);
	unset($_SESSION['room_wikipedia']);
	unset($_SESSION['room_website']);
}else{
	if(isset($_SESSION["join.error"])){
		// If th user change the language after a bad login it must reload the right string
		$_SESSION["join.error"] = $lang['JOIN_ERROR'];
	}
}

?>
<html lang="en">
<head>
    <meta charset="utf8">
    <title><?php print $lang['PAGE_TITLE']?></title>
    <meta name="author" content="InMediArt">
    <script src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
		
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
		
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/header.v2.css" rel="stylesheet">
    
    <script type="text/javascript">  
		$(document).ready(function() {
			$('select').selectpicker();	
			$("#room_country").on("changed.bs.select", 
				function(e, clickedIndex, newValue, oldValue) {
					//console.log(this.value, clickedIndex, newValue, oldValue);
					countryInit($('#room_country').val());
				});
		    countryInit($('#room_country').val());
	    });		
		function validateJoinForm(){
			if($(nickname).val()=='' || $('.selectpicker').val()==''){
				$(loginAlert).removeClass('alert-warning').addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_MANDATORY_ERROR'] ?>');
				return false;
			}
			return true;
		}
		
		function countryInit(room_country){	
			$("#room_id").empty();
			$("#room_id").selectpicker("refresh");
			$.ajax({
			  type: "GET",
			  url: "../../server/service/api/API.php",
			  data: { method: "country", room_country: room_country}
			})
			.done(function( msg ) {
				//console.info( msg );
				var municipalities = JSON.parse(msg);
					$.each(municipalities, function(i, item) {
						//console.info(name + ' ' + room_id);
						$('#room_id').append('<option value="'+item.room_id+'" data-tokens="'+item.name+'">'+item.name+' ('+item.shortcode+')</option>');
					});
					
					//Two times to have a complete refresh
					$('.selectpicker').selectpicker("refresh");
					$('.selectpicker').selectpicker("refresh");
					
			});
		}
    </script>   
  </head>

  <body>   
	<?php include '../header.php';?> 
    <div class="container">
      <form onsubmit="return validateJoinForm()" class="form-signup" method="POST" action="../../server/service/api/API.php" autocomplete="off">
      	<div style="text-align: center;">
      	<img width="350px" src="../assets/img/logo_black.png"/>
		<h3><?php print $lang['CIVIC_HALL']?></h3>
		<label class="form-check-label" for="room_country"><?php print $lang['CIVIC_HALL_COUNTRY_SELECT']?></label>
		<select data-width="100%" id="room_country" name="room_country" class="selectpicker">
			<option value="italy" selected>Italia</option>
			<option value="france">France</option>
		</select>
      	<div id='callbackMessage'></div>
		<div id='loginAlert'></div>
      	</div>
      	<hr>
      	<?php
            if(isset($_SESSION["login.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["login.error"].'</div>';
            }
        ?>
		
        <!-- HIDDEN PARAMETERS -->
        <input type="hidden" value="<?php print $_SESSION['action']?>" name="path" id="path">
        <input type="hidden" value="join" name="method" id="method">
        <input type="hidden" value="civic_hall" name="room_type" id="room_type">
        
        <div class="form-group">
		<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
		<select data-width="100%" id="room_id" name="room_id" type="number" class="selectpicker" data-live-search="true" data-none-selected-text="<?php print $lang['WAIT']?>"></select>
		</div>
		
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
		<hr>
		<p class="jitsiApp" style="text-align-last: center;">
		<a href="https://apps.apple.com/us/app/jitsi-meet/id1165103905" target="_blank"><img src="https://web-cdn.jitsi.net/meetjitsi_5852.2585/images/app-store-badge.png" /></a>
		<a href="https://play.google.com/store/apps/details?id=org.jitsi.meet&hl=en&gl=US" target="_blank"><img src="https://web-cdn.jitsi.net/meetjitsi_5852.2585/images/google-play-badge.png" /></a>
		</p>
      </form>      
    </div> <!-- /container --> 
</body>
</html>
