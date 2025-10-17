<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/server/service/lang.php';
include $_SERVER['DOCUMENT_ROOT'].'/server/service/langs/'. prefered_language($available_languages) .'.php';

// Current action
$dir = getcwd();
$part = explode('/', $dir);
$index = sizeof($part)-1;
if($index == 0){
	$part = explode('\\', $dir);
	$index = sizeof($part)-1;
}
$action=$part[$index];

// Current parameters
$dir = $_SERVER['REQUEST_URI'];
$part = explode('?', $dir);
$index = sizeof($part)-1;
if($index>0) $action=$action."?".$part[$index];

$_SESSION['action'] = $action;
	
// Check, if user has already joined a room, then jump to secured page
if((!isset($_SESSION['nickname']) || !isset($_SESSION['room_id'])) && $_SESSION['action'] == "room") {
	$url = $_SERVER['DOCUMENT_ROOT']."/web/join";
	header("Location: $url");
}
?>
