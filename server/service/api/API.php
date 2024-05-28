<?php
include_once '../../admin/lang.php';
include '../../admin/langs/'. prefered_language($available_languages) .'.php';
include_once '../../admin/config.php';

session_start();
$link = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Error: '.mysqli_connect_error());
$api = new API();

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {
		case 'join':
			if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='custom'){
              	$api->joinCustom($_REQUEST['room_title'], $_REQUEST['room_logo'], $_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['room_type'], $link);
            } else if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='public'){
				$api->join($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['room_type'], $link);
			}
			break;
		case 'left':
			$api->leftRoom($link);
			break;
	}
} else {
	$arr = array('health' => 'OK');
	print json_encode($arr);
}

class API {
    public function join($nickname,$room_id,$room_type,$link){
		$nickname = mysqli_real_escape_string($link, $nickname);
    	
		$_SESSION['room_id'] = $room_id;
        $_SESSION['nickname'] = $nickname;
		$_SESSION['room_type'] = $room_type;
		if(!isset($_SESSION['room_title'])){
			$_SESSION['room_title'] = "";
		}
		if(!isset($_SESSION['room_logo'])){
			$_SESSION['room_logo'] = "";
		} 
        
        header('Location: ../../../web/room');
    }
	
    public function joinCustom($room_title,$room_logo,$nickname,$room_id,$room_type,$link){
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);

		$_SESSION['room_title'] = stripslashes($room_title);
		$_SESSION['room_logo'] = $room_logo;

		$this->join($nickname,$room_id,$room_type,$link);
	}

	public function leftRoom($link){
		$arr = array('success' => 'true');

		unset($_SESSION['room_id']);
		unset($_SESSION['nickname']);
		unset($_SESSION['room_type']);
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);

		print json_encode($arr);
	}
	
}
?>
