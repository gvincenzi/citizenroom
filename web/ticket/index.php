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
			  data: { method: "rooms/ticket/get", serial: "<?php print $_SESSION['user_serial']?>", room_id: "<?php print $_REQUEST['room_id']?>" }
			})
			.done(function( msg ) {
				var tickets = JSON.parse(msg);
					$.each(tickets, function(i, item) {
						var $tr = $('<tr>');
						$tr.append(
							$('<td>').text(item.nickname)
						);
						
						if(item.used == 0){
							$tr.append($('<td>').html(
								"<button title='<?php print $lang['DELETE_ROOM']?>' class='btn btn-danger' type='button' onclick=\"deleteTicket('"+item.room_id+"','"+item.serial+"','"+item.nickname+"')\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button> "
								));
						} else {
							$tr.append($('<td>').html("<span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>"));
						}
						
						$tr.appendTo('#tickets-table tbody');
					});
			});
		});
		
		
		function validateTicketForm(){
			$(nickame).css('border-color', 'white');
			if($(nickame).val()=='' || $(nickame).val() == null){
				$(nickame).css('border-color', 'red');
				return false;
			}
			
			return true;
		}	

		function validateDeleteTicketForm(){
			return true;
		}
		
		function deleteTicket(room_id,serial,nickname){
			$.ajax({
			  type: "POST",
			  url: "../../server/service/api/API.php",
			  data: { method: "rooms/ticket/delete", room_id: room_id, serial: serial, nickname: nickname }
			})
			.done(function( msg ) {
				location.reload();
			});
		}
    </script> 
</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 
   <div class="container">
  <form onsubmit="return validateTicketForm()" class="form-ticket" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: left;">
		<h2><?php print 'CitizenRooom #'.$_GET['room_id']?></h2>
      	<h3><?php print $lang['NEW_TICKET']?></h3>
      	<div id='callbackMessage'></div>
      	</div>
      	<hr>
      	<?php
            if(isset($_SESSION["ticket.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["ticket.error"].'</div>';
				$_SESSION["ticket.error"] = null;
            }
			
			if(isset($_SESSION["ticket.message"])){
            	print '<div class="alert alert-success">'.$_SESSION["ticket.message"].'</div>';
				$_SESSION["ticket.message"] = null;
            }
        ?>
		<div id='ticketAlert'></div>
        
        <!-- HIDDEN PARAMETERS -->
        <input type="hidden" value="<?php print $_SESSION['user_serial']?>" name="serial" id="serial">
		<input type="hidden" value="<?php print $_GET['room_id']?>" name="room_id" id="room_id">
		<input type="hidden" value="rooms/ticket/add" name="method" id="method">
        
        <div class="form-group">
			<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>"></input>
        </div>
		<br>
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['CONFIRM']?></button>
      </form>
	  
	<form onsubmit="return validateDeleteTicketForm()" class="form-list-ticket" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: center;">
      	<h3><?php print $lang['ROOM_TICKET_LIST']?></h3>
		<?php
            if(isset($_SESSION["ticket.list.error"])){
            	print '<div class="alert alert-danger">'.$_SESSION["ticket.list.error"].'</div>';
				$_SESSION["ticket.list.error"] = null;
            }
			
			if(isset($_SESSION["ticket.list.message"])){
            	print '<div class="alert alert-success">'.$_SESSION["ticket.list.message"].'</div>';
				$_SESSION["ticket.list.message"] = null;
            }
        ?>
		<table id="tickets-table" class="table">
		  <thead>
			<tr>
			  <th scope="col"><?php print $lang['NICKNAME']?></th>
			  <th scope="col"></th>
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