<?php
include_once '../../admin/lang.php';
include '../../admin/langs/'. prefered_language($available_languages) .'.php';

session_start();
$api = new API();

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {
		case 'join':
			if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='public' || $_REQUEST['room_type']=='custom'){
				$api->join($_REQUEST['room_type'],$_REQUEST['nickname'],$_REQUEST['room_id'],$_REQUEST['room_title'] ?? "",$_REQUEST['room_logo'] ?? "");
			}
			break;
		case 'left':
			$api->leftRoom();
			break;
	}
} else {
	$arr = array('health' => 'OK');
	print json_encode($arr);
}

class API {
    public function join($room_type,$nickname,$room_id,$room_title,$room_logo){
		$_SESSION['room_id'] = $room_id;
        $_SESSION['nickname'] = $nickname;
		$_SESSION['room_type'] = $room_type;
		$_SESSION['room_title'] = stripslashes($room_title);
		$_SESSION['room_logo'] = $room_logo;
        
        header('Location: ../../../web/room');
    }
	
	public function leftRoom(){
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
