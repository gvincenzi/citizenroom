<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/'. prefered_language($available_languages) .'.php';

// Inialize session
session_start();
if(!isset($_SESSION['action'])){
	$_SESSION['action']='room';
}
if (isset($_SESSION['nickname']) && isset($_SESSION['room_id'])) {
	header('Location: ../'.$_SESSION['action']);
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
			    if(callback=='ROOM_JOIN_ERROR'){
				    $(callbackMessage).addClass('alert').addClass('alert-danger').text('<?php print $lang['JOIN_ERROR'] ?>');
			    }
		    }
	    });	
		function validateJoinForm(){
			return true;
		}		
    </script>   
  </head>

  <body>   
  <?php include '../header.php';?> 
    <div class="container">
      <form onsubmit="return validateJoinForm()" class="form-signup" method="POST" action="../../server/service/api/API.php" autocomplete="off">
      	<div style="text-align: center;">
      	<img width="350px" src="../assets/img/logo_black.png"/>
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
        <input type="hidden" value="join" name="method" id="method">
        
        <div class="form-group">
			<?php 
				if(isset($_GET['type']) && $_GET['type']=='business'){
					echo "<input id='serial' name='serial' type='text' class='form-control' placeholder='Partner ID' readonly onClick='this.readOnly=false' onFocus='this.readOnly=false'>";
				}
			?>
	        <input id="nickname" name="nickname" type="text" class="form-control" placeholder="<?php print $lang['NICKNAME']?>" readonly onClick='this.readOnly=false' onFocus='this.readOnly=false'>
			<input id="room_id" name="room_id" type="number" class="form-control" placeholder="<?php print $lang['ROOM']?>" readonly onClick='this.readOnly=false' onFocus='this.readOnly=false'>
			<?php 
				if(isset($_GET['type']) && $_GET['type']=='business'){
					echo "<input id='password' name='password' type='password' class='form-control' placeholder='".$lang['ROOM_PASSWORD']."' readonly onClick='this.readOnly=false' onFocus='this.readOnly=false'>";
				}
			?>
        </div>
		<?php 
			if(isset($_GET['type']) && $_GET['type']=='business'){
				echo "<div align='right'><a href='#' onclick=\"window.open('../login?type=business','_self')\" style='color:darkgray'><small>".$lang['LOGIN']."</small></a></div>";
			}
		?>
		<br>
		<button class="btn btn-success" type="submit" style="width: 100%"><?php print $lang['JOIN']?></button>
      </form>      
    </div> <!-- /container -->
	
	<?php include '../footer.php';?> 
</body>
</html>
