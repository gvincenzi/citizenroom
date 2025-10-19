<?php
include $_SERVER['DOCUMENT_ROOT'].'/web/topic/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/server/service/lang.php';
include $_SERVER['DOCUMENT_ROOT'].'/server/service/langs/'. prefered_language($available_languages) .'.php';

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

			topicBackground("parliament","<?php print $_REQUEST['country'] ?? 'europe'?>");
			
            topicInit();
	    });	
		
		function validateJoinForm(){
			if($(nickname).val()=='' || $(room_id).val()==''){
				$(loginAlert).removeClass('alert-warning').addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_MANDATORY_ERROR'] ?>');
				return false;
			}
			return true;
		}	

        function topicInit(){	
			$('select').selectpicker();	
			$("#room_id").empty();
			$("#room_id").selectpicker("refresh");
			$.ajax({
			  type: "GET",
			  url: "/server/service/api/TopicAPI.php",
			  data: { method: "init", room_type: "custom", room_topic_name: "parliament", room_topic_domain: "<?php print $_REQUEST['country'] ?? 'europe'?>"}
			})
			.done(function( msg ) {
				topicComboboxInit("parliament","<?php print $_REQUEST['country'] ?? 'europe'?>",msg);
			});
		}

    </script>
  </head>

  <body>   
	<?php include $_SERVER['DOCUMENT_ROOT'].'/web/header.php';?> 
    <div class="container">
		<div class="col-md-5 ml-auto mr-auto">
			<div class="card card-plain">
				<form class="form" onsubmit="return validateJoinForm()" method="POST" action="../../../../server/service/api/TopicAPI.php" autocomplete="off">
					<!-- HIDDEN PARAMETERS -->
					<input type="hidden" value="<?php print $_SESSION['action']?>" name="path" id="path">
					<input type="hidden" value="join" name="method" id="method">
					<input type="hidden" value="custom" name="room_type" id="room_type">
					<input type="hidden" value="parliament" name="room_topic_name" id="room_topic_name">
					<input type="hidden" value="<?php print $_REQUEST['country'] ?? 'europe'?>" name="room_topic_domain" id="room_topic_domain">
				
					<div class="card-header text-center">
						<div class="logo" id="title"><a href="/web/join">CitizenRoom</a></div>
						<div id="primary-navigation-menu">
							<nav>
								<ul class="nav justify-content-center">
									<nav classname="nav-item">
										<ul>
											<li class="nav-link"><a href="/web/join" class="link menu-link"><?php print $lang['JOIN']?></a></li>
											<li class="nav-link"><a href="/web/what" class="link menu-link"><?php print $lang['ABOUT']?></a></li>
											<li class="nav-link"><a href="/web/privacy" class="link menu-link">Privacy (italian language)</a></li>
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
						<select data-width="100%" id="room_id" name="room_id" type="number" class="selectpicker" data-live-search="true" data-none-selected-text="<?php print $lang['WAIT']?>"></select>
						</div>
					</div>

					<div class="card-footer text-center">
						<button class="btn btn-primary btn-round btn-block" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
					</div>
				</form>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>