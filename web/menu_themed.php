<style type="text/css">
    .themed_room_details {
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
          color: white;
          /*font-weight: bold;*/
          /*border: 3px solid #f1f1f1;*/
          position: absolute;
          bottom: 0%;
          z-index: -1;
          width: 100%;
          padding: 5px;
          /*text-align: center;*/
    }

    .themed_room_image{
        position: absolute;
        right: 20;
        bottom: 20;
        width: 150px;
        border-radius: 15px;
    }
</style>

<script type="text/javascript">

  	$(document).ready(function() {
	    	var images = [
	    	<?php if(isset($_SESSION['room_theme_bg_image'])) echo "'".$_SESSION['room_theme_bg_image']."'"; else echo "'https://live.staticflickr.com/8731/16981355745_017d3cfb6d_b.jpg'";?>
			];

			var image_links = [
            <?php if(isset($_SESSION['room_theme_bg_image_link'])) echo "'".$_SESSION['room_theme_bg_image_link']."'"; else echo "'https://www.flickr.com/photos/131391737@N02/16981355745'";?>
            ];

            var authors = [
            <?php if(isset($_SESSION['room_theme_bg_image_author'])) echo "'".$_SESSION['room_theme_bg_image_author']."'"; else echo "'Bay Area Event Staffing'";?>
            ];

            var author_links = [
            <?php if(isset($_SESSION['room_theme_bg_image_author_link'])) echo "'".$_SESSION['room_theme_bg_image_author_link']."'"; else echo "'https://www.flickr.com/photos/131391737@N02/'";?>
            ];

	    	var index = Math.floor(Math.random() * images.length);
            $('#full-screen-background-image').attr("src", images[index]);
            $('#full-screen-background-image').css("filter","blur(8px)");
            $('#full-screen-background-image').css("-webkit-filter","blur(8px)");
            $('#imageLink').prop("href", image_links[index]);
            $('#authorLink').prop("href", author_links[index]).text(authors[index]);

            $('.form-signup').css("background-color","#FFFFFF");
            $('.form-signup').css("opacity","0.8");

		});

</script>

<div id="primary-navigation">
    <div class="logo" id="title">
        <?php if(isset($_SESSION['room_theme_title'])) echo $_SESSION['room_theme_title']; else echo $lang['THEMED_ROOM'];?>
    </div>

	<nav>
    	<ul>
    		<nav classname="site-nav">
    			<ul>
    			    <li class=""><a href="../what"><?php print $lang['ABOUT']?></a></li>
                    <li class=""><a href="../join"><?php print $lang['JOIN']?></a></li>
    				<li class=""><a href="../civichall?room_type=civic_hall"><?php print $lang['CIVIC_HALL']?></a></li>
    				<li class=""><a href="../custom?room_type=custom"><?php print $lang['CUSTOM_ROOM']?></a></li>
    				<li class=""><a href="../themed?room_type=themed"><?php print $lang['THEMED_ROOM']?></a></li>
    			</ul>
    		</nav>
    	</ul>
    	<ul>
           	<nav classname="site-nav">
           		<ul>
                    <li class=""><a href="#" onclick="changeLanguage('en')">English</a></li>
           	    	<li class=""><a href="#" onclick="changeLanguage('it')">Italiano</a></li>
                    <li class=""><a href="#" onclick="changeLanguage('fr')"><?php print ("Français")?></a></li>
           		</ul>
           	</nav>
        </ul>
    </nav>
</div>

<div class="themed_room_details">
  <h1 id="description"><?php echo $_SESSION['room_theme_description'];?></h1>
  <p id="info"><?php echo $_SESSION['room_theme_info'];?></p>
  <img id="image" src=<?php if(isset($_SESSION['room_theme_image'])) echo "'".$_SESSION['room_theme_image']."'"; else echo "'../assets/img/icon.jpg'"?> class="themed_room_image"/>
</div>
