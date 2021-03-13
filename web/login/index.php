<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/'. prefered_language($available_languages) .'.php';
include_once '../actionInSession.php';
// Inialize session
session_start();

if(isset($_SESSION['user'])){
	header('Location: ../dashboard/?type=business');
} else if(isset($_SESSION["login.error"])){
	// If th user change the language after a bad login it must reload the right string
	$_SESSION["login.error"] = $lang['LOGIN_ERROR'];
}
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
    
    <script type="text/javascript">   
	    $(document).ready(function() {
		    var callback = location.search.split('callback=')[1];
		    if(callback!=null && callback!=''){
			    if(callback=='PASSWORD_RESET_OK'){
				    $(callbackMessage).addClass('alert').addClass('alert-success').text('<?php print $lang['PASSWORD_RESET_OK'] ?>');
			    }else{
			    	$(callbackMessage).addClass('alert').addClass('alert-danger').text('<?php print $lang['PASSWORD_RESET_ERROR'] ?>');
			    }
		    }
	    });
    
		function validateLoginForm(){
			if($(mail).val()=='' || validateEmail($(mail).val()) == false){
				$(loginAlert).addClass('alert').addClass('alert-danger').text('<?php print $lang['FORM_ERROR_MAIL'] ?>');
				return false;
			}
			
			return true;
		}		
    </script>   
  </head>

  <body>   
  <?php include '../header.php';?> 
    <div class="container">
      <form onsubmit="return validateLoginForm()" class="form-signup" method="POST" action="../../server/admin/loginproc.php">
      	<div style="text-align: center;">
      	<img width="350px" src="../assets/img/logo_black.png"/>
      	<h3><?php print $lang['LOGIN']?></h3>
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
        
        <div class="form-group">
	        <input id="mail" name="mail" type="text" class="form-control" placeholder="<?php print $lang['MAIL']?>">
	        <input id="password" name="password" type="password" class="form-control" placeholder="<?php print $lang['PASSWORD']?>">
        </div>
        <div align="right"><a href="#" onclick="window.open('../resetpassword','_self')" style="color:darkgray"><small><?php print $lang['PASSWORD_RESET_BUTTON']?></small></a></div>
		<br>
		<button class="btn btn-primary" type="submit" style="width: 100%"><?php print $lang['CONFIRM']?></button>
      </form>      
    </div> <!-- /container -->
</body>
</html>
