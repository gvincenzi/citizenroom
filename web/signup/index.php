<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/'. prefered_language($available_languages) .'.php';

// Inialize session
session_start();
?>
<html lang="en">
<head>
    <meta charset="utf8">
    <title><?php print $lang['PAGE_TITLE']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CitizenRoom">
    <script src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
		
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/header.css" rel="stylesheet">
	<script src="../assets/js/general_v1.js"></script>
    
    <script type="text/javascript">   
		function validateForm(){
			if($( "input:checked" ).length<1){
				$(signupAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['CONDITIONS'] ?>');
				$(privacy).parent().css('color', 'red');
				return false;
			}
			
			if($(name).val()=='' || $(surname).val()==''){
				$(signupAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['MANDATORY_ERROR'] ?>');
				return false;
			}

			if($(mail).val()=='' || validateEmail($(mail).val()) == false){
				$(signupAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['FORM_ERROR_MAIL'] ?>');
				return false;
			}
			
			return true;
		}		
    </script>   
  </head>

  <body>   
  <?php include '../header.php';?> 
    <div class="container">
      <form onsubmit="return validateForm()" class="form-signup" method="POST" action="../../server/service/api/API.php">
      	<div style="text-align: center;">
      	<img width="350px" src="../assets/img/logo_black.png"/>
      	<h3><?php print $lang['SIGNUP']?></h3>
      	</div>
      	<hr>
		<div id='signupAlert'></div>
        

        <!-- HIDDEN PARAMETERS -->
        <input type="hidden" value="join" name="path" id="path">
        <input type="hidden" value="users/add" name="method" id="method">
        
        <div class="form-group">
        	<input id="surname" name="surname" type="text" class="form-control" placeholder="<?php print $lang['SURNAME']?>">
        	<input id="name" name="name" type="text" class="form-control" placeholder="<?php print $lang['NAME']?>">
	        <input id="mail" name="mail" type="text" class="form-control" placeholder="<?php print $lang['MAIL']?>">
        </div>
        <div class="checkbox">
			<label>
				<input type="checkbox" id="privacy"> <?php print $lang['CONDITIONS_PRIVACY']?></input> <br>
			</label>
		</div>
		<button class="btn btn-primary" type="submit" style="width: 100%"><?php print $lang['CONFIRM']?></button>
      </form>      
    </div> <!-- /container -->
</body>
</html>
