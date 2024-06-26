<?php
include '../bootstrap.php';
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/' . prefered_language ( $available_languages ) . '.php';
include prefered_language ( $available_languages ) . '.php';

session_start();
?>
<head>
	<meta charset="utf8">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="InMediArt">
  <link href="../assets/css/what.css?v=<?php print time()?>" rel="stylesheet">

</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 
  
  <div class="col-md-5 ml-auto mr-auto">
			<div class="card card-plain">
        <div class="card-header text-center">
						<div class="logo" id="title">CitizenRoom</div>
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
  <div class="what">
    <?php print $cookieDisclaimer;?>
  </div>
        
</body>
</html>