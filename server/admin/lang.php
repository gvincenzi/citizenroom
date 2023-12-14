<?php
$available_languages = array(
	'en_US',
	'it_IT',
	'fr_FR',
);

/* 
  determine which language out of an available set the user prefers most
  
  $available_languages        array with language-tag-strings (must be lowercase) that are available
  $http_accept_language    a HTTP_ACCEPT_LANGUAGE string (read from $_SERVER['HTTP_ACCEPT_LANGUAGE'] if left out)
*/
function prefered_language($available_languages,$http_accept_language="auto") {
	if(empty($_COOKIE['citizenroom']['bestlang']) or !in_array($_COOKIE['citizenroom']['bestlang'],$available_languages)){
	    $bestlang = $available_languages[0];
		
		// Duration : 31 days (2678400 seconds)
	    setcookie('citizenroom[bestlang]', $bestlang, time()+2678400, '/');
	    return $bestlang;
	}else{
		return $_COOKIE['citizenroom']['bestlang'];
	}
}

?>