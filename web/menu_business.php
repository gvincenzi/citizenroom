<div id="primary-navigation">
 <?php 
 if(isset($_SESSION['nickname']) && isset($_SESSION['room_id'])){
	print_r('<img class="logo" src="../assets/img/logo_business.png" alt="citizenroom" style="width:50%; max-width:535px" onclick="location.href=\'../room/?type=business\'" />');
 } else {
    print_r('<img class="logo" src="../assets/img/logo_business.png" alt="citizenroom" style="width:50%; max-width:535px" onclick="location.href=\'../join/?type=business\'" />');
 } ?>
	<nav>
		<ul>
			<nav classname="site-nav">
				<ul>
					<?php 
                    	if(isset($_SESSION['nickname']) && isset($_SESSION['room_id'])){
                    		//print_r('<li class=""><a href="../../server/admin/left.php">'.$lang['LEFT'].'</a></li>');
                    	}else{
                    		print_r('<li class=""><a href="../../web/join?type=business">'.$lang['JOIN'].'</a></li>');
                    	}
                    ?>
					<?php 
                    	if(isset($_SESSION['user'])){
							print_r('<li class=""><a href="../../web/dashboard?type=business">Dashboard</a></li>');
                    		print_r('<li class=""><a href="../../server/admin/logout.php">Logout</a></li>');
							print_r('<li class=""></li>');
                    	}else{
							//print_r('<li class=""><a href="../../web/login?type=business">'.$lang['LOGIN'].'</a></li>');
                    		//print_r('<li class=""><a href="../../web/signup?type=business">'.$lang['SIGNUP'].'</a></li>');
                    	}
                    ?>
                    <li class=""><a href="#" onclick="changeLanguage('en')">English</a></li>
					<li class=""><a href="#" onclick="changeLanguage('it')">Italiano</a></li>
                    <li class=""><a href="#" onclick="changeLanguage('fr')"><?php print ("Français")?></a></li>
				</ul>
			</nav>
		</ul>
	</nav>
</div>