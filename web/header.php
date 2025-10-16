<script type="text/javascript">
  	$(document).ready(function() {
		randomBackground();
	});
</script>
<div id="primary-navigation">
	<nav>
		<ul class="nav justify-content-end">
           	<nav classname="nav-item">
           		<ul>
                    <li class="nav-link"><a href="#" onclick="changeLanguage('en_US')">English</a></li>
           	    	<li class="nav-link"><a href="#" onclick="changeLanguage('it_IT')">Italiano</a></li>
                    <li class="nav-link"><a href="#" onclick="changeLanguage('fr_FR')"><?php print ("Français")?></a></li>
					<li class="nav-link"><a href="https://github.com/gvincenzi/citizenroom/releases/tag/7.0.0" target="_blank">v 7.0.0</a></li>
           		</ul>
           	</nav>
        </ul>
    </nav>
</div>

<img alt="full screen background image" src="" id="full-screen-background-image" />
<flickr>
  	<a href="" id="imageLink" target="_blank"><img id="flickrLogo" src="https://upload.wikimedia.org/wikipedia/commons/9/9b/Flickr_logo.png"/><br></a>
  	<author>Photo by <a href="" id="authorLink" target="_blank"></a></author><br>
	<license>License <a href="" id="licenseLink" target="_blank"></a></license>
</flickr>