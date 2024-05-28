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
    <meta name="author" content="InMediArt">
    
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
					<input type="hidden" value="public" name="room_type" id="room_type">
				
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
					</div>
					<div class="card-body">
						<div class="input-group form-group-no-border input-lg">
							<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
						</div>
						<div class="input-group form-group-no-border input-lg">
							<input id="room_id" name="room_id" type="number" class="form-control" placeholder="<?php print $lang['ROOM']?>">
						</div>
					</div>
					
					<div class="card-footer text-center">
						<button class="btn btn-primary btn-round btn-block" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
					</div>
					<div class="card-footer text-right">
						<h6><a href="../custom?room_type=custom" class="link footer-link"><?php print $lang['CUSTOM_ROOM']?></a></h6>
					</div>
				</form>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>
