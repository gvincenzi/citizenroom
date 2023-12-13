<?php
include '../bootstrap.php';
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
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/header.v4.css" rel="stylesheet">
    
    <script type="text/javascript">
		function validateJoinForm(){
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
					<input type="hidden" value="<?php if(isset($_GET['room_type'])) print $_GET['room_type']?>" name="room_type" id="room_type">
					<input type="hidden" value="<?php if(isset($_GET['room_id'])) print $_GET['room_id']?>" name="room_id" id="room_id">
				
					<div class="card-header text-center">
						<div class="logo" id="title">CitizenRoom</div>
						<div id="primary-navigation-menu">
							<nav>
								<ul class="nav justify-content-center">
									<nav classname="nav-item">
										<ul>
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
						<h3>
						<?php 
						if(isset($_GET['room_type']) && $_GET['room_type'] == 'custom'){
							print $lang['INVITATION'].$lang['CUSTOM_ROOM'].'<br><strong>'.$_GET['room_id'].'</strong><br><strong>'.$_GET['room_title'].'</strong>';
						} else if(isset($_GET['room_type']) && $_GET['room_type'] == 'public'){
							print $lang['INVITATION'].$lang['ROOM_CHECK_ROOM'].'<br><strong>'.$_GET['room_id'].'</strong>';
						}
						?>
						</h3>
					</div>
					<div class="card-body">
						<div class="input-group form-group-no-border input-lg">
							<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
						</div>
					</div>
					
					<div class="card-footer text-center">
						<button class="btn btn-primary btn-round btn-block" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
					</div>
					<div class="card-footer text-right">
						<h6><a href="../what" class="link footer-link"><?php print $lang['ABOUT']?></a></h6>
						<h6><a href="../custom?room_type=custom" class="link footer-link"><?php print $lang['CUSTOM_ROOM']?></a></h6>
					</div>
				</form>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>
