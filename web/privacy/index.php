<?php
include '../bootstrap.php';
include_once '../../server/service/lang.php';
include '../../server/service/langs/' . prefered_language ( $available_languages ) . '.php';
include prefered_language ( $available_languages ) . '.php';

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
  <?php include $_SERVER['DOCUMENT_ROOT'].'/web/menu.php';?> 
  <div class="what">
    <?php print $cookieDisclaimer;?>
  </div>
        
</body>
</html>