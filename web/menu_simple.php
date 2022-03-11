<div id="primary-navigation">
 <?php 
 if(isset($_SESSION['nickname']) && isset($_SESSION['room_id'])){
	print_r('<img class="logo" src="../assets/img/logo.png" alt="citizenroom" style="width:50%; max-width:535px" onclick="location.href=\'../room\'" />');
 } else {
    print_r('<img class="logo" src="../assets/img/logo.png" alt="citizenroom" style="width:50%; max-width:535px" onclick="location.href=\'../join\'" />');
 } ?>
	<nav>
		<ul>
			<nav classname="site-nav">
				<ul>
                    <li class=""><a href="#" onclick="changeLanguage('en')">English</a></li>
					<li class=""><a href="#" onclick="changeLanguage('it')">Italiano</a></li>
                    <li class=""><a href="#" onclick="changeLanguage('fr')"><?php print ("Français")?></a></li>
					<li class=""><a href="../civichall"><?php print $lang['CIVIC_HALL']?></a></li>
				</ul>
			</nav>
		</ul>
	</nav>
</div>