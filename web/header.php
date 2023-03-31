<script src="https://cdnjs.cloudflare.com/ajax/libs/lettering.js/0.6.1/jquery.lettering.min.js"></script>
<script	src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.2.12/jquery.jgrowl.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="../assets/js/general_v1.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<link href="../assets/css/header.v2.css" rel="stylesheet">
<link href="../assets/css/subtitle.css" rel="stylesheet">

<script type="text/javascript">

  	$(document).ready(function() {
	    	var images = [
			'https://live.staticflickr.com/65535/44574560331_0101fffd98_h.jpg',];
			
            var image_links = [
			'https://www.flickr.com/photos/nikiforovpizza/44574560331/'];

            var authors = [
			'Mykyta Nikiforov'];
			
            var author_links = [
			'https://www.flickr.com/photos/nikiforovpizza/'];
			
	    	var index = Math.floor(Math.random() * images.length);
            $('#full-screen-background-image').attr("src", images[index]);
            $('#imageLink').prop("href", image_links[index]);
            $('#authorLink').prop("href", author_links[index]).text(authors[index]);
		});

	function block(){
		$.blockUI({ css: { 
	        border: 'none', 
	        padding: '15px', 
	        backgroundColor: '#000', 
	        '-webkit-border-radius': '10px', 
	        '-moz-border-radius': '10px', 
	        opacity: .5, 
	        color: '#fff'
	    },
	    message: '<?php print $lang['WAIT']?>' });
	}
	
	function unblock(){
		$.unblockUI();
	}

</script>
<header>
	<?php if(isset($_GET['room_type'])) include 'menu_'.$_GET['room_type'].'.php';
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

<div id="growl" class="jGrowl bottom-left"></div>
