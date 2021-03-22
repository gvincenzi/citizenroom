<?php
include_once '../../admin/lang.php';
include '../../admin/langs/'. prefered_language($available_languages) .'.php';
include_once '../../admin/config.php';
require 'UserRegister.php';

session_start();
$link = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Error: '.mysqli_connect_error());
$api = new API();

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {		
		case 'join':
			if(isset($_REQUEST['serial']) && $_REQUEST['serial']!=''){
				$api->joinBusiness($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['password'], $_REQUEST['serial'], $link);
			} else {
				$api->join($_REQUEST['nickname'], $_REQUEST['room_id'], $link);
			}
			break;
		case 'subscription/check':
			$api->checkSubscription($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['serial'], $link);
			break;
		case 'users/add':
			$api->usersAdd($_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['mail'], $link, $lang);
			break;
		case 'users/resetpassword':
			$api->resetPassword($_REQUEST['mail'], $link);
			break;
		case 'users/update':
			$api->usersUpdate($_REQUEST['id'], $_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['mail'], $link, $lang);
			break;
		case 'rooms/add':
			$api->roomsAdd($_REQUEST['room_id'], $_REQUEST['password'], $_REQUEST['serial'], $_REQUEST['room_title'], $link, $lang);
			break;
		case 'rooms/delete':
			$api->roomsDelete($_REQUEST['room_id'], $_REQUEST['password'], $_REQUEST['serial'], $link, $lang);
			break;
		case 'rooms/get':
			$api->roomsGet($_REQUEST['serial'], $link);
			break;
	}
}else {
	$arr = array('success' => 'false', 'message' => 'Error in input parameters');
	print $arr;
}

class API{	
	public function checkSubscription($nickname,$room_id,$serial,$link){
		if($serial == null || $serial==''){
			$serial = 'PUBLIC';
		}
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ? AND citizenroom_subscription.serial = ?");
		$stmt->bind_param('iss', $room_id,$nickname,$serial);
		$stmt->execute(); 
		$result = $stmt->get_result();
		if( mysqli_num_rows( $result ) == 0){
		
			unset($_SESSION['room_id']);
			unset($_SESSION['nickname']);
			unset($_SESSION['password']);
			unset($_SESSION['user_serial']);
			
			$arr = array('success' => 'false', 'message' => 'Subscription does not exist');
		} else {
			$arr = array('success' => 'true', 'message' => 'Subscription OK');
		}
		
		print json_encode($arr);
	}
	
    public function join($nickname,$room_id,$link){	
		$nickname = mysqli_real_escape_string($link, $nickname);
    	
    	$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ? AND citizenroom_subscription.serial = 'PUBLIC'");
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
        
        header('Location: ../../../web/room');
    }
	
	public function joinBusiness($nickname,$room_id,$password,$serial,$link){	
		$nickname = mysqli_real_escape_string($link, $nickname);
		
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ? AND password = ?");
		$stmtCheck->bind_param('iss', $room_id, $serial, $password);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 0){
			header('Location: ../../../web/join?callback=ROOM_JOIN_ERROR');
			return;
		} else {
			$stmt = mysqli_stmt_init($link);
			$stmt->prepare("SELECT * FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ? AND citizenroom_subscription.serial = ?");
			$stmt->bind_param('iss',$room_id,$nickname,$serial);
			$stmt->execute(); 
			$result = $stmt->get_result();
			if( mysqli_num_rows( $result ) == 0){
				$stmtInsert = mysqli_stmt_init($link);
				$stmtInsert->prepare("INSERT INTO citizenroom_subscription (room_id,nickname,serial) VALUES (?,?,?)");
				$stmtInsert->bind_param('iss',$room_id,$nickname,$serial);
				$stmtInsert->execute();
				
				mysqli_stmt_close($stmtInsert);
			}

			mysqli_free_result($result);
			mysqli_stmt_close($stmt);
					
			$_SESSION['room_id'] = $room_id;
			$_SESSION['nickname'] = $nickname;
			$_SESSION['password'] = $password;
			$_SESSION['user_serial'] = $serial;
			
			$room = $this->roomsGetById($serial,$room_id,$link);
			$_SESSION['room_title'] = stripslashes($room['title']);

			header('Location: ../../../web/room?type=business');
		}
    }
	
	public function resetPassword($user_mail,$link){   	
        $service = new UserRegister();
        $result = $service->resetPassword(prefered_language($available_languages),$user_mail,$link);

        if($result==true){
        	header('Location: ../../../web/login?callback=PASSWORD_RESET_OK');
        }else{
        	header('Location: ../../../web/login?callback=PASSWORD_RESET_ERROR');
        }
        
    }
	
	public function usersAdd($user_name,$user_surname,$user_mail,$link,$lang){   	
    	$user_name = mysqli_real_escape_string($link, $user_name);
    	$user_surname = mysqli_real_escape_string($link, $user_surname);
		
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_user WHERE mail = ?");
		$stmtCheck->bind_param('s', $user_mail);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 0){
			$stmtInsert = mysqli_stmt_init($link);
			$stmtInsert->prepare("INSERT INTO citizenroom_user (`name`, `surname`, `mail`) VALUES (?,?,?)");
			$stmtInsert->bind_param('sss', $user_name, $user_surname, $user_mail);
			$stmtInsert->execute();
			$user_id = mysqli_insert_id($link);
			
			mysqli_stmt_close($stmtInsert);
			
			$service = new UserRegister();
			$result = $service->register(prefered_language($available_languages),$_REQUEST['mail'],$link);

			if($result==true){
				$arr = array('success' => 'true', 'message' => $lang['USER_ADD_OK']);
			}else{
				$arr = array('success' => 'false', 'message' => $lang['USER_ADD_ERROR']);
			}
			
			//Reload Session
			$stmtSelect = mysqli_stmt_init($link);
			$stmtSelect->prepare("SELECT * FROM citizenroom_user WHERE user_id = ?");
			$stmtSelect->bind_param('i', $user_id);
			$stmtSelect->execute();
			if( mysqli_num_rows( $result ) == 1){
				while($row = $result->fetch_array(MYSQLI_BOTH)){
					$_SESSION['user'] = (string)($row['user_id']);
					$_SESSION['user_name'] = (string)($row['name']);
					$_SESSION['user_surname'] = (string)($row['surname']);
					$_SESSION['user_mail'] = (string)($row['mail']);
					$_SESSION['user_serial'] = (string)($row['serial']);
				}
			}
			
			if($_REQUEST['path']!='' && $_REQUEST['path']!=null){
				header('Location: ../../../web/'.$_REQUEST['path']);
			}else{
				header('Location: ../../../web/join');
			}
		}
        
		$arr = array('success' => 'false', 'message' => $lang['USER_ALREADY_EXISTS']);
        print json_encode($arr);	
    }
	
	public function usersUpdate($user_id, $user_name,$user_surname,$user_mail,$link,$lang){   	
    	$user_name = mysqli_real_escape_string($link, $user_name);
    	$user_surname = mysqli_real_escape_string($link, $user_surname);

		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("UPDATE citizenroom_user SET name = ?,surname = ?, mail = ? WHERE user_id = ?");
		$stmt->bind_param('sssi', $user_name, $user_surname, $user_mail, $user_id);
		$stmt->execute();
		mysqli_stmt_close($stmt);
		
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_surname'] = $user_surname;
		$_SESSION['user_mail'] = $user_mail;
		
		$_SESSION["profile.message"] = $lang['USER_UPDATE_OK'];
		header('Location: ../../../web/dashboard?type=business');	
	}
	
	public function roomsAdd($room_id,$password,$serial,$title,$link,$lang){   	
		$title = mysqli_real_escape_string($link, $title);
		$password = mysqli_real_escape_string($link, $password);
		
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ?");
		$stmtCheck->bind_param('is', $room_id, $serial);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 0){
			$stmtInsert = mysqli_stmt_init($link);
			$stmtInsert->prepare("INSERT INTO citizenroom_business_room (`room_id`, `serial`, `password`, `title`) VALUES (?,?,?,?)");
			$stmtInsert->bind_param('isss', $room_id, $serial, $password, $title);
			$resultInsert = $stmtInsert->execute();

			if($resultInsert==true){
				$_SESSION["room.message"] = $lang['ROOM_ADD_OK'];
			}else{
				$_SESSION["room.error"] = $lang['ROOM_ADD_ERROR'];
			}
			mysqli_free_result($resultInsert);
			mysqli_free_result($result);
			mysqli_stmt_close($stmtCheck);
			mysqli_stmt_close($stmtInsert);
			
		} else {
			$stmtUpdate = mysqli_stmt_init($link);
			$stmtUpdate->prepare("UPDATE citizenroom_business_room SET password = ?, title = ? WHERE room_id = ? AND serial = ?");
			$stmtUpdate->bind_param('ssis', $password, $title, $room_id, $serial);
			$resultUpdate = $stmtUpdate->execute();
			
			if($resultUpdate==true){
				$_SESSION["room.message"] = $lang['ROOM_ADD_OK'];
			}else{
				$_SESSION["room.error"] = $lang['ROOM_ADD_ERROR'];
			}
			mysqli_free_result($resultUpdate);
			mysqli_free_result($result);
			mysqli_stmt_close($stmtCheck);
			mysqli_stmt_close($stmtUpdate);
		}
		
        header('Location: ../../../web/dashboard?type=business');
    }
	
	public function roomsDelete($room_id,$password,$serial,$link,$lang){   	
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ?");
		$stmtCheck->bind_param('is', $room_id, $serial);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 1){
			$stmtDelete = mysqli_stmt_init($link);
			$stmtDelete->prepare("DELETE FROM citizenroom_business_room WHERE room_id = ? AND serial = ? AND password = ?");
			$stmtDelete->bind_param('iss', $room_id, $serial, $password);
			$resultDelete = $stmtDelete->execute();
			
			$stmtDeleteSubs = mysqli_stmt_init($link);
			$stmtDeleteSubs->prepare("DELETE FROM citizenroom_subscription WHERE room_id = ? AND serial = ?");
			$stmtDeleteSubs->bind_param('is', $room_id, $serial);
			$resultDeleteSubs = $stmtDeleteSubs->execute();
			
			if($resultDelete==true && $resultDeleteSubs==true){
				$_SESSION["room.list.message"] = $lang['ROOM_DELETE_OK'];
				$arr = array('success' => 'true', 'message' => $lang['ROOM_DELETE_OK']);
			}else{
				$_SESSION["room.list.error"] = $lang['ROOM_DELETE_ERROR'];
				$arr = array('success' => 'false', 'message' => $lang['ROOM_DELETE_ERROR']);
			}
			mysqli_free_result($result);
			mysqli_free_result($resultDelete);
			mysqli_free_result($resultDeleteSubs);
			mysqli_stmt_close($stmtCheck);
			mysqli_stmt_close($stmtDelete);
			mysqli_stmt_close($stmtDeleteSubs);
		} else {
			$_SESSION["room.list.error"] = $lang['ROOM_NOT_FOUND'];
			$arr = array('success' => 'false', 'message' => $lang['ROOM_NOT_FOUND']);
		}
     
        print json_encode($arr);	
    }
	
	public function roomsGet($serial,$link){ 
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE serial = ?");
		$stmtCheck->bind_param('s', $serial);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
		$myArray = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray[] = $row;
		}
		print json_encode($myArray);
	}
	
	public function roomsGetById($serial,$room_id,$link){ 
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE serial = ? AND room_id = ?");
		$stmtCheck->bind_param('si', $serial,$room_id);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
		$row = $result->fetch_assoc();
		return $row;
	}
}
?>