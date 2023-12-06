<script type="text/javascript">

  	$(document).ready(function() {
	    	var images = [
	    	    'https://live.staticflickr.com/8323/8378955329_b46073595f_b_d.jpg'
			];

			var image_links = [
                'https://www.flickr.com/photos/nasose/8378955329'
            ];

            var authors = [
                'Nasos Efstathiadis'
            ];

            var author_links = [
                'https://www.flickr.com/photos/nasose/'
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
        <?php echo $lang['MUSICIAN_ROOM'];?>
    </div>

	<nav>
    	<ul>
    		<nav classname="site-nav">
    			<ul>
    			    <li class=""><a href="../what"><?php print $lang['ABOUT']?></a></li>
                    <li class=""><a href="../join"><?php print $lang['JOIN']?></a></li>
    				<li class=""><a href="../custom?room_type=custom"><?php print $lang['CUSTOM_ROOM']?></a></li>
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