<?php
include '../bootstrap.php';
include_once '../../server/service/lang.php';
include '../../server/service/langs/'. prefered_language($available_languages) .'.php';

if(!isset($_SESSION['action'])){
	$_SESSION['action']='room';
}
if (isset($_SESSION['nickname']) && isset($_SESSION['room_id'])) {
	unset($_SESSION['room_id']);
	unset($_SESSION['nickname']);
	unset($_SESSION['room_type']);
	unset($_SESSION['room_title']);
	unset($_SESSION['room_logo']);
	unset($_SESSION['room_custom_link']);
	unset($_SESSION['room_additional_data']);
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
	<meta property="og:description" content="<?php if(isset($_GET['room_title'])) print $lang['INVITATION'].$_GET['room_id'].' '.$_GET['room_title']; else print $lang['INVITATION'].$_GET['room_id']?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="https://citizenroom.altervista.org/web/assets/img/icon.jpg" />
    <meta name="author" content="InMediArt">
    
    <script type="text/javascript">
		function validateJoinForm(){
			if($(nickname).val()=='' || $(room_id).val()==''){
				$(loginAlert).removeClass('alert-warning').addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_MANDATORY_ERROR'] ?>');
				return false;
			}
			return true;
		}	
    </script>   
  </head>

  <body>   
  <?php include '../header.php';?> 
    <div class="container">
		<div class="col-md-5 ml-auto mr-auto">
			<div class="card card-plain">
				<form class="form" onsubmit="return validateJoinForm()" method="POST" action="../../server/service/api/API.php" autocomplete="off">
					<!-- HIDDEN PARAMETERS -->
					<input type="hidden" value="<?php print $_SESSION['action']?>" name="path" id="path">
					<input type="hidden" value="join" name="method" id="method">
					<input type="hidden" value="<?php if(isset($_GET['room_title'])) print $_GET['room_title']?>" name="room_title" id="room_title">
					<input type="hidden" value="<?php if(isset($_GET['room_logo'])) print $_GET['room_logo']?>" name="room_logo" id="room_logo">
					<input type="hidden" value="<?php if(isset($_GET['room_custom_link'])) print $_GET['room_custom_link']?>" name="room_custom_link" id="room_custom_link">
					<input type="hidden" value="<?php if(isset($_GET['room_type'])) print $_GET['room_type']?>" name="room_type" id="room_type">
					<input type="hidden" value="<?php if(isset($_GET['room_id'])) print $_GET['room_id']?>" name="room_id" id="room_id">
				
					<div class="card-header text-center">
						<div class="logo" id="title"><a href="../join">CitizenRoom</a></div>
						<div id="primary-navigation-menu">
							<nav>
								<ul class="nav justify-content-center">
									<nav classname="nav-item">
										<ul>
											<li class="nav-link"><a href="../join" class="link menu-link"><?php print $lang['JOIN']?></a></li>
											<li class="nav-link"><a href="../what" class="link menu-link"><?php print $lang['ABOUT']?></a></li>
											<li class="nav-link"><a href="../privacy" class="link menu-link">Privacy (italian language)</a></li>
										</ul>
									</nav>
								</ul>
							</nav>
						</div>
						<div id='callbackMessage'></div>
						<div id='loginAlert'></div>
						<?php
							if(isset($_SESSION["login.error"])){
								print '<div class="alert alert-danger">'.$_SESSION["login.error"].'</div>';
							}
						?>
					</div>
					<div class="card-body invitation">
						<h6>
						<?php 
						if(isset($_GET['room_type']) && $_GET['room_type'] == 'custom'){
							print $lang['INVITATION'].$lang['CUSTOM_ROOM'].' <strong>'.$_GET['room_id'].'</strong><br><strong>'.$_GET['room_title'].'</strong>';
						} else if(isset($_GET['room_type']) && $_GET['room_type'] == 'public'){
							print $lang['INVITATION'].$lang['ROOM_CHECK_ROOM'].' <strong>'.$_GET['room_id'].'</strong>';
						}
						?>
						</h6>
						<div class="input-group form-group-no-border input-lg">
							<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
						</div>
					</div>
					
					<div class="card-footer text-center">
						<button class="btn btn-primary btn-round btn-block" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
					</div>
					<div class="card-footer text-right">
						<h6><a href="../join" class="link footer-link">Home</a></h6>
					</div>
				</form>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>
