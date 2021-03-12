<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/' . prefered_language ( $available_languages ) . '.php';
include prefered_language ( $available_languages ) . '.php';

session_start();
?>
<head>
	<meta charset="iso-8859-1">
	<title><?php print $lang['PAGE_TITLE']?></title>
	<meta name="description" content="CitizenRoom">
	<meta name="author" content="InMediArt">
	<script src="https://code.jquery.com/jquery-3.2.1.js"
		integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		crossorigin="anonymous"></script>
    
    <link href="../assets/css/what.css" rel="stylesheet">

</head>

<body style="background-color: #f5f5f5">   
  <?php include '../header.php';?> 
  
  <div class="what">
  <?php print $cookieDisclaimer;?>
  </div>
</body>
</html>