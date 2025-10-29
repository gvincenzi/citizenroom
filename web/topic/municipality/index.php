<?php
include '../bootstrap.php';
include_once '../../../server/service/lang.php';
include '../../../server/service/langs/'. prefered_language($available_languages) .'.php';

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
	unset($_SESSION['room_topic_name']);
	unset($_SESSION['room_topic_domain']);	
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

			topicBackground("municipality","<?php print $_REQUEST['country'] ?? 'france'?>");
			topicInit("<?php print $_REQUEST['country'] ?? 'france'?>");
	    });	
		
		function validateJoinForm(){
			if($(nickname).val()=='' || $(room_id).val()==''){
				$(loginAlert).removeClass('alert-warning').addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_MANDATORY_ERROR'] ?>');
				return false;
			}
			return true;
		}	

        function topicInit(topicDomain){	
			let lastQuery = "";
			let timer = null;

			// Quando l'utente digita nel box di ricerca della selectpicker
			$('.selectpicker').parent().find('.bs-searchbox input').on('input', function() {
				let query = $(this).val();

				// Solo se almeno 3 lettere e query diversa dall'ultima richiesta
				if(query.length >= 3 && query !== lastQuery){
					lastQuery = query;
					clearTimeout(timer);

					// Debounce per evitare troppe chiamate
					timer = setTimeout(function() {
						if(topicDomain==="france"){
							$.ajax({
								url: 'https://geo.api.gouv.fr/communes',
								data: {
									nom: query,
									fields: 'departement',
									limit: 5
								},
								success: function(data) {
									// Svuota la select
									$('#room_id').empty();

									// Popola con i risultati
									data.forEach(function(item){
										$('#room_id').append(
											$('<option>', {
												value: item.code,
												text: item.nom + (item.departement ? ' (' + item.departement.code + ')' : '')
											})
										);
									});

									// Aggiorna la selectpicker
									$('#room_id').selectpicker('refresh');
								}
							});
						} else if(topicDomain==="italy"){
							$.ajax({
								url: 'https://axqvoqvbfjpaamphztgd.functions.supabase.co/comuni',
								data: {
									nome: query,
									limit: 5
								},
								success: function(data) {
									// Svuota la select
									$('#room_id').empty();

									// Popola con i risultati
									data.forEach(function(item){
										$('#room_id').append(
											$('<option>', {
												value: item.codice,
												text: item.nome + (item.provincia ? ' (' + item.provincia.sigla + ')' : '')
											})
										);
									});

									// Aggiorna la selectpicker
									$('#room_id').selectpicker('refresh');
								}
							});
						}
						
					}, 300); // 300ms debounce
				}
			});
		}

    </script>
  </head>

  <body>   
	<?php include '../../../web/header.php';?> 
    <div class="container container-join">
		<div class="container-sm">
			<div class="card card-plain">
				<form class="form" onsubmit="return validateJoinForm()" method="POST" action="../../../../server/service/api/TopicAPI.php" autocomplete="off">
					<!-- HIDDEN PARAMETERS -->
					<input type="hidden" value="<?php print $_SESSION['action']?>" name="path" id="path">
					<input type="hidden" value="join" name="method" id="method">
					<input type="hidden" value="topic" name="room_type" id="room_type">
					<input type="hidden" value="municipality" name="room_topic_name" id="room_topic_name">
					<input type="hidden" value="<?php print $_REQUEST['country'] ?? 'france'?>" name="room_topic_domain" id="room_topic_domain">
				
					<?php include '../../../web/menu.php';?>
					
					<div class="card-body">
						<div class="input-group form-group-no-border input-lg">
							<input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>">
						</div>
						<div class="input-group form-group-no-border input-lg">
						<select data-width="100%" id="room_id" name="room_id" type="number" class="selectpicker" data-live-search="true" data-none-selected-text="<?php print $lang['TOPIC_ROOM_MUNICIPALITY_FILTER']?>"></select>
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