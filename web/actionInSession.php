<?php
include_once '../../server/admin/lang.php';
include '../../server/admin/langs/'. prefered_language($available_languages) .'.php';

// Inialize session
session_start();

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
	header('Location: ../join');
}
if(!isset($_SESSION['user']) && $_SESSION['action'] == "dashboard?type=business") {
	header('Location: ../login/?type=business');
}
?>
