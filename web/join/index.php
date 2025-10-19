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
  <?php include $_SERVER['DOCUMENT_ROOT'].'/web/header.php';?> 
    <div class="container">
		<div class="container-sm">
			<div class="card card-plain">
				<form class="form" onsubmit="return validateJoinForm()" method="POST" action="../../server/service/api/API.php" autocomplete="off">
					<!-- HIDDEN PARAMETERS -->
					<input type="hidden" value="<?php print $_SESSION['action']?>" name="path" id="path">
					<input type="hidden" value="join" name="method" id="method">
					<input type="hidden" value="<?php isset($_GET['room_type']) ? print $_GET['room_type'] : print 'public'?>" name="room_type" id="room_type">
				
					<?php include $_SERVER['DOCUMENT_ROOT'].'/web/menu.php';?> 
					
					<div class="card-body">
						<div class="input-group form-group-no-border input-lg">
							<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
						</div>
						<div class="input-group form-group-no-border input-lg">
							<input id="room_id" name="room_id" type="number" class="form-control" placeholder="<?php print $lang['ROOM']?>">
						</div>
						<span style="display: <?php isset($_GET['room_type']) && $_GET['room_type']==='custom' ? print 'block' : print 'none'?>">
							<hr/>
							<div class="input-group form-group-no-border input-lg">
								<input id="room_title" name="room_title" type="text" class="form-control" placeholder="<?php print $lang['ROOM_TITLE']?>">
							</div>
							<div class="input-group form-group-no-border input-lg">
								<input id="room_logo" name="room_logo" type="url" class="form-control" placeholder="<?php print $lang['ROOM_LOGO']?>">
							</div>
							<div class="input-group form-group-no-border input-lg">
								<input id="room_custom_link" name="room_custom_link" type="url" class="form-control" placeholder="<?php print $lang['btnCustomLink']?>">
							</div>
						</span>
					</div>
					
					<div class="card-footer text-center">
						<button class="btn btn-primary btn-round btn-block" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
					</div>
					<div class="card-footer text-right">
					</div>
				</form>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>
