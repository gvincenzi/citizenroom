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
	<meta property="og:title" content="<?php print $lang['PAGE_TITLE']?>" />
	<meta property="og:description" content="<?php print $lang['INVITATION'].$_GET['room_id'].' '.$_GET['room_title']?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="https://citizenroom.altervista.org/web/assets/img/icon.jpg" />
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
            if(<?php print "'".$_GET['room_type']."'"?> == 'themed'){
                    $.ajax({
                       type: "GET",
                       url: "../../server/service/api/API.php",
                       data: { method: 'themeDetails', room_id: <?php echo "'".$_GET['room_id']."'"?> }
                    })
                    .done(function( msg ) {
                        var theme = JSON.parse(msg);
                        //console.info(theme);
                        $('#title').html(theme.title);
                        $('#description').html(theme.description);
                        $('#info').html(theme.info);
                        $('#image').attr("src",theme.image);

                        $('#full-screen-background-image').attr("src", theme.bg_image);
                        $('#full-screen-background-image').css("filter","blur(8px)");
                        $('#full-screen-background-image').css("-webkit-filter","blur(8px)");
                        $('#imageLink').prop("href", theme.bg_image_link);
                        $('#authorLink').prop("href", theme.bg_image_author_link).text(theme.bg_image_author);

                        $('.form-signup').css("background-color","#FFFFFF");
                        $('.form-signup').css("opacity","0.8");
                    });
            }

	    });

		function validateJoinForm(){
			return true;
		}		
    </script>   
  </head>

  <body>   
  <?php include '../header.php';?> 
    <div class="container">
      <form onsubmit="return validateJoinForm()" class="form-signup" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: center;">
      	<img width="350px" src="../assets/img/logo_black.png"/>
      	<h3>
		<?php 
		if(isset($_GET['room_type']) && $_GET['room_type'] == 'civic_hall'){
		    print $lang['INVITATION'].$lang['CIVIC_HALL'].'<br><strong>'.$_GET['room_title'].'</strong>';
		} else if(isset($_GET['room_type']) && $_GET['room_type'] == 'custom'){
            print $lang['INVITATION'].$lang['CUSTOM_ROOM'].'<br><strong>'.$_GET['room_id'].'</strong><br><strong>'.$_GET['room_title'].'</strong>';
        } else if(isset($_GET['room_type']) && $_GET['room_type'] == 'themed'){
            print $lang['INVITATION'].$lang['THEMED_ROOM'].'<br><strong>'.$_GET['room_id'].'</strong>';
        } else if(isset($_GET['room_type']) && $_GET['room_type'] == 'public'){
		    print $lang['INVITATION'].$lang['ROOM_CHECK_ROOM'].'<br><strong>'.$_GET['room_id'].'</strong><br><strong>'.$_GET['room_title'].'</strong>';
		}
		?>
		</h3>
      	<div id='callbackMessage'></div>
      	</div>
      	<hr>
      	<?php
            if(isset($_SESSION["login.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["login.error"].'</div>';
            }
        ?>
		<div id='loginAlert'></div>
        
        <!-- HIDDEN PARAMETERS -->
        <input type="hidden" value="<?php print $_SESSION['action']?>" name="path" id="path">
        <input type="hidden" value="join" name="method" id="method">
        <input type="hidden" value="<?php print $_GET['room_title']?>" name="room_title" id="room_title">
        <input type="hidden" value="<?php print $_GET['room_logo']?>" name="room_logo" id="room_logo">
		<input type="hidden" value="<?php print $_GET['room_type']?>" name="room_type" id="room_type">
		<input type="hidden" value="<?php print $_GET['room_id']?>" name="room_id" id="room_id">
		<input type="hidden" value="<?php print $_GET['room_country']?>" name="room_country" id="room_country">
        
        <div class="form-group">
	        <input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
        </div>
		<br>
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['CONFIRM']?></button>
		
		<hr>
		<p class="jitsiApp" style="text-align-last: center;">
		<a href="https://apps.apple.com/us/app/jitsi-meet/id1165103905" target="_blank"><img src="https://web-cdn.jitsi.net/meetjitsi_5852.2585/images/app-store-badge.png" /></a>
		<a href="https://play.google.com/store/apps/details?id=org.jitsi.meet&hl=en&gl=US" target="_blank"><img src="https://web-cdn.jitsi.net/meetjitsi_5852.2585/images/google-play-badge.png" /></a>
		</p>
      </form>      
    </div> <!-- /container -->
</body>
</html>
