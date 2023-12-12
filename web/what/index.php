<?php
include '../bootstrap.php';
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/' . prefered_language ( $available_languages ) . '.php';
include prefered_language ( $available_languages ) . '.php';

session_start();
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

    <link href="../assets/css/what.css" rel="stylesheet">

</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 
  
  <div class="what">
  <?php print $cookieDisclaimer;?>
  </div>
</body>
</html>
