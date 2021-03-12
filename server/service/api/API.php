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
			$api->join($_REQUEST['nickname'], $_REQUEST['room_id'], $link);
			break;
	}
}else {
	$arr = array('success' => 'false', 'message' => 'Error in input parameters');
	print $arr;
}

class API{	
    public function join($nickname,$room_id,$link){	
		echo $nickname.$room_id;
    	
    	$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ?");
		$stmt->bind_param('is', $room_id,$nickname);
		$stmt->execute(); 
		$result = $stmt->get_result();
		if( mysqli_num_rows( $result ) == 0){
			$stmtInsert = mysqli_stmt_init($link);
			$stmtInsert->prepare("INSERT INTO citizenroom_subscription (room_id,nickname) VALUES (?,?)");
			$stmtInsert->bind_param('is', $room_id,$nickname);
			$stmtInsert->execute();
			
			mysqli_stmt_close($stmtInsert);
		}

		mysqli_free_result($result);
		mysqli_stmt_close($stmt);
        		
		$_SESSION['room_id'] = $room_id;
        $_SESSION['nickname'] = $nickname;
        
        if($_REQUEST['path']!='' && $_REQUEST['path']!=null){
        	header('Location: ../../../web/'.$_REQUEST['path']);
        }else{
        	header('Location: ../../../web/room');
        }
    }
}
?>