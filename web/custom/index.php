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
	unset($_SESSION['room_mail']);

   	unset($_SESSION['room_theme_title']);
   	unset($_SESSION['room_theme_description']);
   	unset($_SESSION['room_theme_info']);
   	unset($_SESSION['room_theme_image']);
    unset($_SESSION['room_theme_bg_image']);
    unset($_SESSION['room_theme_bg_image_link']);
    unset($_SESSION['room_theme_bg_image_author']);
    unset($_SESSION['room_theme_bg_image_author_link']);
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/header.v3.css" rel="stylesheet">

    <script type="text/javascript">
		$(document).ready(function() {
		    var callback = location.search.split('callback=')[1];
		    if(callback!=null && callback!=''){
			    if(callback=='ROOM_JOIN_ERROR'){
				    $(callbackMessage).removeClass('alert-warning').addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_ERROR'] ?>');
			    }
		    }
	    });

		function validateJoinForm(){
			if($(nickname).val()=='' || $(room_id).val()==''){
				$(loginAlert).removeClass('alert-warning').addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_MANDATORY_ERROR'] ?>');
				return false;
			}
			return true;
		}

		function checkRoom(){
			if($(room_id).val()==''){
				$(loginAlert).addClass('alert').removeClass('alert-warning').addClass('alert-danger').text('<?php print $lang['JOIN_MANDATORY_ERROR'] ?>');
				return false;
			}

			$.ajax({
			  type: "GET",
			  url: "../../server/service/api/API.php",
			  data: { method: "rooms/check", room_id: $(room_id).val() }
			})
			.done(function( msg ) {
				console.info( msg );
				var subscriptions = JSON.parse(msg);

					var count = 0;
					var participants='';
					$.each(subscriptions, function(i, item) {
						count++;
						participants += item.nickname+'<br>';
					});

					if(participants != ''){
						$('#loginAlert').removeClass('alert-danger').addClass('alert-warning').html('<?php print $lang['ROOM_CHECK_ROOM'] ?>'+$(room_id).val()+' <?php print $lang['ROOM_CHECK_PARTICIPANTS'] ?> ('+count+') :<br>'+participants);
					} else {
						$('#loginAlert').removeClass('alert-danger').addClass('alert-warning').html('<?php print $lang['ROOM_CHECK_ROOM'] ?>'+$(room_id).val()+'<?php print $lang['ROOM_CHECK_ROOM_EMPTY'] ?>');
					}
			});
		}
    </script>
  </head>

  <body>
  <?php include '../header.php';?>
    <div class="container">
      <form target="_blank" onsubmit="return validateJoinForm()" class="form-signup" method="POST" action="../../server/service/api/API.php" autocomplete="off">
      	<div style="text-align: center;">
      	<img width="350px" src="../assets/img/logo_black.png"/>
      	<h4><?php print $lang['CUSTOM_ROOM_DESCRIPTION']?></h4>
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
        <input type="hidden" value="custom" name="room_type" id="room_type">

        <div class="form-group">
	        <input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
			<input id="room_id" name="room_id" type="number" class="form-control" placeholder="<?php print $lang['ROOM']?>">
			<hr>
			<input id="room_title" name="room_title" type="text" class="form-control" placeholder="<?php print $lang['ROOM_TITLE']?>">
			<input id="room_logo" name="room_logo" type="url" class="form-control" placeholder="<?php print $lang['ROOM_LOGO']?>">
        </div>
		<br>
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>

      </form>
    </div> <!-- /container -->

	<?php include '../footer.php';?>
</body>
</html>