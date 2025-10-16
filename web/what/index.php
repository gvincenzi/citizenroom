<?php
include '../bootstrap.php';
include_once '../../server/service/lang.php';
include '../../server/service/langs/' . prefered_language ( $available_languages ) . '.php';
include prefered_language ( $available_languages ) . '.php';

?>
<html lang="en">
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta property="og:title" content="<?php print $lang['PAGE_TITLE']?>" />
		
	<!-- Facebook Meta Tags -->
	<meta property="og:url" content="https://citizenroom.altervista.org/web/what/">
	<meta property="og:type" content="website">
	<meta name="description" property="og:description" content="Cos'è e perché CitizenRoom - What and why CitizenRoom (italian language) - Qu'est-ce que et pourquoi CitizenRoom (en italien)">
	<meta property="og:image" content="https://citizenroom.altervista.org/web/assets/img/icon.jpg">

	<!-- Twitter Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta property="twitter:domain" content="citizenroom.altervista.org">
	<meta property="twitter:url" content="https://citizenroom.altervista.org/web/what/">
	<meta name="twitter:title" content="CitizenRoom - A free space where you can feel at home">
	<meta name="twitter:description" content="Informations about CitizenRoom (italian language)">
	<meta name="twitter:image" content="https://citizenroom.altervista.org/web/assets/img/icon.jpg">

    <link href="../assets/css/what.css?v=<?php print time()?>" rel="stylesheet">

</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 
  
  <div class="col-md-5 ml-auto mr-auto">
		<div class="card card-plain">
        	<div class="card-header text-center">
				<div class="logo" id="title"><a href="../join">CitizenRoom</a></div>
					<div id="primary-navigation-menu">
						<nav>
							<ul class="nav justify-content-center">
								<nav classname="nav-item">
									<ul>
										<li class="nav-link"><a href="../join" class="link menu-link"><?php print $lang['JOIN']?></a></li>
										<li class="nav-link"><a href="../what" class="link menu-link"><?php print $lang['ABOUT']?></a></li>
										<li class="nav-link"><a href="../privacy" class="link menu-link">Privacy (italian language)</a></li>
									</ul>
								</nav>
							</ul>
						</nav>
           			</div>
        		</div>
    		</div>
		</div>
  </div>
  <div class="what">
    <?php print $cookieDisclaimer;?>
  </div>
        
</body>
</html>