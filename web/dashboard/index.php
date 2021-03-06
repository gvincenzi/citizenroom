<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/' . prefered_language ( $available_languages ) . '.php';
include_once '../actionInSession.php';
session_start();
?>
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="CitizenRoom">
	<script src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
    
    <link href="../assets/css/form.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="../assets/js/general_v1.js"></script>

	<script type="text/javascript">   
		$(function(){
			$.ajax({
			  type: "POST",
			  url: "../../server/service/api/API.php",
			  data: { method: "rooms/get", serial: "<?php print $_SESSION['user_serial']?>" }
			})
			.done(function( msg ) {
				//console.info( msg );
				var rooms = JSON.parse(msg);
				
					$.each(rooms, function(i, item) {
						var $tr = $('<tr>');
						
						if(item.logo!='' && item.logo!=null){
							$tr.append(
							$('<td>').text(item.room_id),
							$('<td>').text(item.title.replace('\\','')),
							$('<td>').html('<img src="'+item.logo+'" style="height:35px"></img>'));
						} else {
							$tr.append(
							$('<td>').text(item.room_id),
							$('<td>').text(item.title.replace('\\','')),
							$('<td>').text('---'));
						}
						
						$tr.append($('<td>').html(
							"<button class='btn btn-success' title=\"<?php print $lang['ROOM_INVITATION']?>\" type='button' onclick=\"invitationRoom('"+item.room_id+"','"+item.serial+"','"+item.password+"','"+item.title+"')\"><span class=\"glyphicon glyphicon-send\" aria-hidden=\"true\"></span></button> " +
							"<button title='<?php print $lang['DELETE_ROOM']?>' class='btn btn-danger' type='button' onclick=\"deleteRoom('"+item.room_id+"','"+item.serial+"')\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button> " +
							"<button class='btn btn-warning' title='<?php print $lang['UPDATE_ROOM']?>' type='button' onclick=\"fillRoomData("+item.room_id+",'"+item.title+"','"+item.logo+"',"+item.withTicket+",'"+item.password+"')\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></button> " +
							"<button class='btn btn-warning' type='button' onclick=\"checkRoom("+item.room_id+",'"+item.serial+"')\"><span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span></button> " +
							"<button class='btn btn-info' title='<?php print $lang['JOIN']?>' type='button' onclick=\"joinRoom("+item.room_id+",'"+item.serial+"','"+item.password+"','<?php print $_SESSION['user_name'].' '.$_SESSION['user_surname']?>')\"><span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span></button> "
							));
							
							if(item.password!='' && item.password!=null){
								$tr.append($('<td>').html(item.password));
							} else {
								$tr.append($('<td>').html("<span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>"));
							}
							
							if(item.withTicket){
								$tr.append($('<td>').html("<button class='btn btn-info' title='<?php print $lang['ROOM_TICKET_LIST']?>' type='button' onclick=\"ticketRoom("+item.room_id+")\"><span class=\"glyphicon glyphicon-th-list\" aria-hidden=\"true\"></span></button> "));
							} else {
								$tr.append($('<td>').html("<span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button> "));
							}
							
							$tr.appendTo('#rooms-table tbody');
					});
			});
		});
  
		function validateProfileForm(){
			if($(user_name).val()=='' || $(user_surname).val()==''){
				$(profileAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['MANDATORY_ERROR'] ?>');
				return false;
			}

			if($(user_mail).val()=='' || validateEmail($(user_mail).val()) == false){
				$(profileAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['FORM_ERROR_MAIL'] ?>');
				return false;
			}
			
			return true;
		}	

		function validateRoomForm(){
			if($(room_id).val()=='' || $(room_id).val() == null){
				$(roomAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['ROOM_MANDATORY_ERROR'] ?>');
				return false;
			}
			
			return true;
		}	

		function validateDeleteRoomForm(){
			return true;
		}
		
		function deleteRoom(room_id,serial){
			$.ajax({
			  type: "POST",
			  url: "../../server/service/api/API.php",
			  data: { method: "rooms/delete", room_id: room_id, serial: serial }
			})
			.done(function( msg ) {
				location.reload();
			});
		}
		
		function invitationRoom(room_id,serial,password,room_title){
			if(serial != null && serial != ""){
				copyToClipboard(window.location.href.replaceAll("/dashboard/", "/invitation/")+"&room_id="+room_id+"&password="+password+"&serial="+serial+"&room_title="+room_title);
			}  else {
				copyToClipboard(window.location.href.replaceAll("/dashboard/", "/invitation/")+"?room_id="+room_id);
			}
			alert("Invitation link copied in clipboard");
		}
		
		function copyToClipboard(text) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val(text).select();
			document.execCommand("copy");
			$temp.remove();
		}
		
		function fillRoomData(id,title,logo,with_ticket,password){
			$(room_id).val(id);
			$(room_title).val(title);
			$(room_logo).val(logo);
			$(room_password).val(password);
			if(with_ticket==0){
				$(room_with_ticket).attr('checked', false);
				$(room_with_ticket).prop('checked', false);
			} else {
				$(room_with_ticket).attr('checked', true);
				$(room_with_ticket).prop('checked', true);
			}
		}
		
		function joinRoom(room_id,serial,password,nickname){
			$.ajax({
			  type: "POST",
			  url: "../../server/service/api/API.php",
			  data: { method: "join", room_id: room_id, serial: serial, nickname: nickname, password: password, no_redirect:'true' }
			})
			.done(function( msg ) {
				window.open(location.href.replaceAll("/dashboard/", "/room/"), '_self');
			});
		}
		
		function checkRoom(room_id,serial){		
			$.ajax({
			  type: "GET",
			  url: "../../server/service/api/API.php",
			  data: { method: "rooms/check", room_id: room_id, serial: serial }
			})
			.done(function( msg ) {
				console.info( msg );
				var subscriptions = JSON.parse(msg);
					
					var count = 0;
					var participants='';
					$.each(subscriptions, function(i, item) {
						count++;
						participants += ' - '+item.nickname+' - ';
					});
					
					if(participants != ''){
						alert('<?php print $lang['ROOM_CHECK_ROOM'] ?>'+room_id+' <?php print $lang['ROOM_CHECK_PARTICIPANTS'] ?> ('+count+') : '+participants);
					} else {
						alert('<?php print $lang['ROOM_CHECK_ROOM'] ?>'+room_id+'<?php print $lang['ROOM_CHECK_ROOM_EMPTY'] ?>');
					}
			});
		}	
		
		function ticketRoom(room_id){
			window.open(location.href.replaceAll("/dashboard/?type=business", "/ticket/?type=business&room_id="+room_id), '_blank');
		}
    </script> 
</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 
  
  <div class="profile">
	<form onsubmit="return validateProfileForm()" class="form-profile form-check" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: left;">
      	<h3><?php print $lang['PROFILE']?></h3>
      	<div id='callbackMessage'></div>
      	</div>
      	<hr>
      	<?php
			if(isset($_SESSION["profile.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["profile.error"].'</div>';
				$_SESSION["profile.error"] = null;
            }
			
			if(isset($_SESSION["profile.message"])){
            	print '<div class="alert alert-success">'.$_SESSION["profile.message"].'</div>';
				$_SESSION["profile.message"] = null;
            }
        ?>
		<div id='profileAlert'></div>
        
        <!-- HIDDEN PARAMETERS -->
        <input type="hidden" value="<?php print $_SESSION['user']?>" name="id" id="id">
		<input type="hidden" value="users/update" name="method" id="method">
        
        <div class="form-group">
			<h4>PartnerID : <strong><?php print $_SESSION['user_serial']?></strong></h4>
			<hr>
			<input id="user_surname" name="surname" type="text" class="form-control" value="<?php print $_SESSION['user_surname']?>" placeholder="<?php print $lang['SURNAME']?>"></input>
			<input id="user_name" name="name" type="text" class="form-control" value="<?php print $_SESSION['user_name']?>" placeholder="<?php print $lang['NAME']?>"></input>
	        <input id="user_mail" name="mail" type="text" class="form-control" value="<?php print $_SESSION['user_mail']?>" placeholder="<?php print $lang['MAIL']?>"></input>
			<hr>
			<h4>Youtube</h4>
			<input id="user_stream_key" name="stream_key" type="text" class="form-control" value="<?php print $_SESSION['user_stream_key']?>" placeholder="YouTube Stream Key"></input>
			<input id="user_channel_id" name="channel_id" type="text" class="form-control" value="<?php print $_SESSION['user_channel_id']?>" placeholder="YouTube Channel ID"></input>
			
			<hr>
			<h4><?php print $lang['ROOM_NOTIF']?></h4>
			<input id="user_room_mail_notif" name="user_room_mail_notif" type="checkbox" class="form-check-input" <?php if($_SESSION['user_room_mail_notif'])print "checked" ?>></input>
			<label class="form-check-label" for="user_room_mail_notif"><?php print $lang['ROOM_NOTIF_MAIL']?></label>
			<hr>
        </div>
        <div align="right"><a href="#" onclick="window.open('../resetpassword?type=business','_self')" style="color:darkgray"><small>Reset Password</small></a></div>
		<br>
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['CONFIRM']?></button>
    </form>
	
	
	<form onsubmit="return validateRoomForm()" class="form-room" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: left;">
      	<h3><?php print $lang['NEW_ROOM']?></h3>
      	<div id='callbackMessage'></div>
      	</div>
      	<hr>
      	<?php
            if(isset($_SESSION["room.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["room.error"].'</div>';
				$_SESSION["room.error"] = null;
            }
			
			if(isset($_SESSION["room.message"])){
            	print '<div class="alert alert-success">'.$_SESSION["room.message"].'</div>';
				$_SESSION["room.message"] = null;
            }
        ?>
		<div id='roomAlert'></div>
        
        <!-- HIDDEN PARAMETERS -->
        <input type="hidden" value="<?php print $_SESSION['user_serial']?>" name="serial" id="serial">
		<input type="hidden" value="rooms/add" name="method" id="method">
        
        <div class="form-group">
			<input id="room_id" name="room_id" type="number" class="form-control" placeholder="<?php print $lang['ROOM']?>"></input>
			<input id="room_title" name="room_title" type="text" class="form-control" placeholder="<?php print $lang['ROOM_TITLE']?>"></input>
			<input id="room_password" name="room_password" type="text" class="form-control" placeholder="<?php print $lang['PASSWORD']?>"></input>
			<input id="room_logo" name="room_logo" type="text" class="form-control" placeholder="Logo URL"></input>
			<br>
			<input id="room_with_ticket" name="room_with_ticket" type="checkbox" class="form-check-input">
			  <label class="form-check-label" for="room_with_ticket">
				Ticketing
			  </label>
			</input>
        </div>
		<br>
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['CONFIRM']?></button>
      </form>

	<form onsubmit="return validateDeleteRoomForm()" class="form-list-room" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: center;">
      	<h3><?php print $lang['ROOM_LIST']?></h3>
		<?php
            if(isset($_SESSION["room.list.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["room.list.error"].'</div>';
				$_SESSION["room.list.error"] = null;
            }
			
			if(isset($_SESSION["room.list.message"])){
            	print '<div class="alert alert-success">'.$_SESSION["room.list.message"].'</div>';
				$_SESSION["room.list.message"] = null;
            }
        ?>
		<table id="rooms-table" class="table">
		  <thead>
			<tr>
			  <th scope="col"><?php print $lang['ROOM']?></th>
			  <th scope="col"><?php print $lang['ROOM_TITLE']?></th>
			  <th scope="col">Logo</th>
			  <th scope="col"></th>
			  <th scope="col"><?php print $lang['PASSWORD']?></th>
			  <th scope="col">Ticketing</th>
			</tr>
		  </thead>
		  <tbody>
		  </tbody>
		</table>
		</div>
      </form>
   </div>
</body>
</html>