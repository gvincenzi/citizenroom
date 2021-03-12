<div id="primary-navigation">
 <?php 
 if(isset($_SESSION['nickname']) && isset($_SESSION['room_id'])){
	print_r('<img class="logo" src="../assets/img/logo.png" alt="citizenroom" height="160" onclick="location.href=\'../room\'" />');
 } else {
    print_r('<img class="logo" src="../assets/img/logo.png" alt="citizenroom" height="160" onclick="location.href=\'../join\'" />');
 } ?>
	<nav>
		<ul>
			<nav classname="site-nav">
				<ul>
					<?php 
                    	if(isset($_SESSION['nickname']) && isset($_SESSION['room_id'])){
                    		print_r('<li class=""><a href="../../server/admin/left.php">'.$lang['LEFT'].'</a></li>');
                    	}else{
                    		print_r('<li class=""><a href="../../web/join">'.$lang['JOIN'].'</a></li>');
                    	}
                    ?>
                    <li class=""></li>
                    <li class=""><a href="#" onclick="changeLanguage('en')">English</a></li>
					<li class=""><a href="#" onclick="changeLanguage('it')">Italiano</a></li>
                    <li class=""><a href="#" onclick="changeLanguage('fr')"><?php print ("Français")?></a></li>
				</ul>
			</nav>
		</ul>
	</nav>
</div>