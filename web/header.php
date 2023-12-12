<script type="text/javascript">
  	$(document).ready(function() {
		randomBackground();
	});
</script>
<header>
	<?php if(isset($_GET['room_type'])) include 'menu_'.$_GET['room_type'].'.php';
          else if(isset($_SESSION['room_type'])) include 'menu_'.$_SESSION['room_type'].'.php';
          else include 'menu_simple.php';?>
</header>

  <img alt="full screen background image" src="" id="full-screen-background-image" />
  <flickr>
  	<a href="" id="imageLink"><img id="flickrLogo" src="https://upload.wikimedia.org/wikipedia/commons/9/9b/Flickr_logo.png"/><br></a>
  	<author>Photo by <a href="" id="authorLink"></a></author>
  </flickr>
  
  <jitsi>
  	<a href="https://meet.jit.si/" target="_blank"><img id="jitsiLogo" src="../assets/img/jitsi.svg"/><br></a>
	Based on Jitsi Meet
  </jitsi>