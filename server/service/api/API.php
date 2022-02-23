<?php
include_once '../../admin/lang.php';
include '../../admin/langs/'. prefered_language($available_languages) .'.php';
include_once '../../admin/config.php';
require 'UserRegister.php';
require 'Alert.php';

session_start();
$link = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Error: '.mysqli_connect_error());
$api = new API();

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {		
		case 'join':
			if(isset($_REQUEST['serial']) && $_REQUEST['serial']!=''){
				$api->joinBusiness($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['serial'], $_REQUEST['password'], $_REQUEST['room_type'], $link);
			} else {
				$api->join($_REQUEST['nickname'], $_REQUEST['room_id'], $link);
			}
			break;
		case 'left':
			$api->leftRoom($link);
			break;
		case 'rooms/check':
			$api->checkRoom($_GET['room_id'], $_GET['serial'], $link);
			break;
		case 'rooms/hash':
			$api->hash($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['serial'], $link);
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
			$api->usersUpdate($_REQUEST['id'], $_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['mail'], $_REQUEST['stream_key'], $_REQUEST['channel_id'], $_REQUEST['room_telegram_notif'], $link, $lang);
			break;
		case 'rooms/add':
			$api->roomsAdd($_REQUEST['room_id'], $_REQUEST['serial'], $_REQUEST['room_title'], $_REQUEST['room_logo'], $_REQUEST['room_password'], $link, $lang);
			break;
		case 'rooms/delete':
			$api->roomsDelete($_REQUEST['room_id'], $_REQUEST['serial'], $link, $lang);
			break;
		case 'rooms/get':
			$api->roomsGet($_REQUEST['serial'], $link);
			break;
		case 'rooms/get/id':
			$api->roomsGetById($_REQUEST['serial'], $_REQUEST['room_id'], $link);
			break;
		case 'rooms/ticket/get':
			$api->ticketGet($_REQUEST['serial'], $_REQUEST['room_id'], $link, $lang);
			break;
		case 'rooms/ticket/add':
			$api->ticketAdd($_REQUEST['room_id'], $_REQUEST['serial'], $_REQUEST['nickname'], $link, $lang);
			break;
		case 'rooms/ticket/delete':
			$api->ticketDelete($_REQUEST['room_id'], $_REQUEST['serial'], $_REQUEST['nickname'], $link);
			break;
		case 'rooms/ticket/validate':
			$api->ticketValidate($_REQUEST['room_id'], $_REQUEST['serial'], $_REQUEST['nickname'], $link, $lang);
			break;
	}
}else {
	$arr = array('success' => 'false', 'message' => 'Error in input parameters');
	print $arr;
}

class API{	
	public function hash($nickname,$room_id,$serial,$link){
		if($serial == null || $serial==''){
			$serial = 'PUBLIC';
		}
		
		$lastTicket = $this->ticketGetLast($serial,$room_id,$link);
		
		if($lastTicket['hash'] != null){
			$previousHash = $lastTicket['hash'];
		} else {
			$previousHash = 'GENESIS';
		}
		
		$hash = md5($nickname.$room_id.$serial.$previousHash);
		
		$stmtUpdateTicket = mysqli_stmt_init($link);
		$stmtUpdateTicket->prepare("UPDATE citizenroom_business_room_ticket SET hash = ?, previousHash = ? WHERE room_id = ? AND serial = ? AND nickname = ?");
		$stmtUpdateTicket->bind_param('ssiss', $hash, $previousHash, $room_id, $serial, $nickname);
		$stmtUpdateTicket->execute();
	
		mysqli_stmt_close($stmtUpdateTicket);
	}
	
	public function ticketGetLast($serial,$room_id,$link){ 
		$stmtLast = mysqli_stmt_init($link);
		$stmtLast->prepare("SELECT * FROM citizenroom_business_room_ticket WHERE serial = ? AND room_id = ? AND used = 1 ORDER BY `id` DESC LIMIT 1");
		$stmtLast->bind_param('si', $serial,$room_id);
		$stmtLast->execute();
		$result = $stmtLast->get_result();
		$row = $result->fetch_assoc();
		return $row;
	}

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
			unset($_SESSION['password']);
			unset($_SESSION['nickname']);
			unset($_SESSION['serial']);
			
			$arr = array('success' => 'false', 'message' => 'Subscription does not exist');
		} else {
			$arr = array('success' => 'true', 'message' => 'Subscription OK');
		}
		
		print json_encode($arr);
	}
	
	public function checkRoom($room_id,$serial,$link){
		if($serial == null || $serial==''){
			$serial = 'PUBLIC';
		}
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.serial = ?");
		
		$stmt->bind_param('is', $room_id,$serial);
		$stmt->execute(); 
		$result = $stmt->get_result();
		$myArray = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray[] = $row;
		}
		
		print json_encode($myArray);
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
	
	public function joinBusiness($nickname,$room_id,$serial,$password,$room_type,$link){	
		$nickname = mysqli_real_escape_string($link, $nickname);
		
		if(!$this->nicknameHasValidTicket($serial,$room_id,$nickname,$link) && $room_type != 'live'){
			header('Location: ../../../web/join?type=business&callback=TICKET_JOIN_ERROR');
		} else {
			$stmtCheck = mysqli_stmt_init($link);
			$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ? AND password = ?");
			$stmtCheck->bind_param('iss', $room_id, $serial, $password);
			$stmtCheck->execute();
			$result = $stmtCheck->get_result();
			if( mysqli_num_rows( $result ) == 0){
				header('Location: ../../../web/join?callback=ROOM_JOIN_ERROR');
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
				
				unset($_SESSION['room_id']);
				unset($_SESSION['nickname']);
				unset($_SESSION['password']);
				unset($_SESSION['serial']);
				unset($_SESSION['room_title']);
				unset($_SESSION['room_logo']);
						
				$_SESSION['room_id'] = $room_id;
				$_SESSION['nickname'] = $nickname;
				$_SESSION['serial'] = $serial;
				$_SESSION['password'] = $password;
				
				$room = $this->roomsGetByIdInternal($serial,$room_id,$link);
				$_SESSION['room_title'] = stripslashes($room['title']);
				$_SESSION['room_logo'] = $room['logo'];
				
				if(!isset($_SESSION['user'])){
					$alertService = new Alert();
					$alertService->sendMail(prefered_language($available_languages), $room['mail'], $room['title'], $nickname);
				}
				
				$this->validTicket($serial,$room_id,$nickname,$link);
				
				if (!isset($_REQUEST['no_redirect'])){
					if (isset($_REQUEST['room_type']) && $_REQUEST['room_type'] == "live"){
						header('Location: ../../../web/live?type=business');
					} else {
						header('Location: ../../../web/room?type=business');
					}
				}
			}
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
				$_SESSION["signup.success"] = $lang['USER_ADD_OK'];
			}else{
				$arr = array('success' => 'false', 'message' => $lang['USER_ADD_ERROR']);
				$_SESSION["signup.error"] = $lang['USER_ADD_ERROR'];
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
			
			header('Location: ../../../web/login?type=business');
		} else {
			$arr = array('success' => 'false', 'message' => $lang['USER_ALREADY_EXISTS']);
			$_SESSION["signup.error"] = $lang['USER_ALREADY_EXISTS'];
			header('Location: ../../../web/signup?type=business');
		}
    }
	
	public function usersUpdate($user_id, $user_name,$user_surname,$user_mail,$user_stream_key,$user_channel_id,$user_room_telegram_notif,$link,$lang){   	
    	$user_name = mysqli_real_escape_string($link, $user_name);
    	$user_surname = mysqli_real_escape_string($link, $user_surname);
		
		$withMailNotif = isset($_REQUEST['user_room_mail_notif']) ? 1 : 0;

		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("UPDATE citizenroom_user SET name = ?, surname = ?, mail = ?, stream_key = ?, channel_id =?, room_mail_notif=?, room_telegram_notif=?  WHERE user_id = ?");
		$stmt->bind_param('sssssisi', $user_name, $user_surname, $user_mail, $user_stream_key, $user_channel_id, $withMailNotif, $user_room_telegram_notif, $user_id);
		$stmt->execute();
		mysqli_stmt_close($stmt);
		
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_surname'] = $user_surname;
		$_SESSION['user_mail'] = $user_mail;
		$_SESSION['user_stream_key'] = $user_stream_key;
		$_SESSION['user_channel_id'] = $user_channel_id;
		$_SESSION['user_room_mail_notif'] = $withMailNotif;
		$_SESSION['user_room_telegram_notif'] = $user_room_telegram_notif;
		
		$_SESSION["profile.message"] = $lang['USER_UPDATE_OK'];
		header('Location: ../../../web/dashboard?type=business&log='.$user_room_mail_notif.$user_room_telegram_notif);	
	}
	
	public function roomsAdd($room_id,$serial,$title,$logo,$password,$link,$lang){   	
		$title = mysqli_real_escape_string($link, $title);
		$withTicket = isset($_REQUEST['room_with_ticket']) ? 1 : 0;
		
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ?");
		$stmtCheck->bind_param('is', $room_id, $serial);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 0){
			$stmtInsert = mysqli_stmt_init($link);
			$stmtInsert->prepare("INSERT INTO citizenroom_business_room (`room_id`, `serial`, `title`, `logo`, `password`, `withTicket`) VALUES (?,?,?,?,?,?)");
			$stmtInsert->bind_param('issssi', $room_id, $serial, $title, $logo, $password, $withTicket);
			$resultInsert = $stmtInsert->execute();

			if($resultInsert==true){
				if($withTicket==1) $this->ticketAddInternal($room_id,$serial,$_SESSION['user_name'].' '.$_SESSION['user_surname'],$link,$lang);
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
			$stmtUpdate->prepare("UPDATE citizenroom_business_room SET title = ?, logo = ?, withTicket = ?, password = ? WHERE room_id = ? AND serial = ?");
			$stmtUpdate->bind_param('ssisis', $title, $logo, $withTicket, $password, $room_id, $serial);
			$resultUpdate = $stmtUpdate->execute();
			
			if($resultUpdate==true){
				if($withTicket==1){
					$this->ticketAddInternal($room_id,$serial,$_SESSION['user_name'].' '.$_SESSION['user_surname'],$link,$lang);
				} else {
					$this->ticketDeleteAll($room_id,$serial,$link,$lang);
				}
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
	
	public function roomsDelete($room_id,$serial,$link,$lang){   	
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ?");
		$stmtCheck->bind_param('is', $room_id, $serial);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 1){
			$stmtDelete = mysqli_stmt_init($link);
			$stmtDelete->prepare("DELETE FROM citizenroom_business_room WHERE room_id = ? AND serial = ?");
			$stmtDelete->bind_param('is', $room_id, $serial);
			$resultDelete = $stmtDelete->execute();
			
			$stmtDeleteSubs = mysqli_stmt_init($link);
			$stmtDeleteSubs->prepare("DELETE FROM citizenroom_subscription WHERE room_id = ? AND serial = ?");
			$stmtDeleteSubs->bind_param('is', $room_id, $serial);
			$resultDeleteSubs = $stmtDeleteSubs->execute();
			
			$stmtDeleteTickets = mysqli_stmt_init($link);
			$stmtDeleteTickets->prepare("DELETE FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ?");
			$stmtDeleteTickets->bind_param('is', $room_id, $serial);
			$resultDeleteTickets = $stmtDeleteTickets->execute();
			
			if($resultDelete==true && $resultDeleteSubs==true && $resultDeleteTickets==true){
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
	
	public function roomsGetByIdInternal($serial,$room_id,$link){ 
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT citizenroom_business_room.*,owner.mail as mail FROM citizenroom_business_room INNER JOIN citizenroom_user as owner ON owner.serial = citizenroom_business_room.serial WHERE citizenroom_business_room.serial = ? AND citizenroom_business_room.room_id = ?");
		$stmtCheck->bind_param('si', $serial,$room_id);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function roomsGetById($serial,$room_id,$link){ 
		print json_encode($this->roomsGetByIdInternal($serial,$room_id,$link));
	}
	
	public function ticketAddInternal($room_id,$serial,$nickname,$link,$lang){
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ? AND nickname = ?");
		$stmtCheck->bind_param('iss', $room_id, $serial, $nickname);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
        if( mysqli_num_rows( $result ) == 0){
			$stmtInsert = mysqli_stmt_init($link);
			$stmtInsert->prepare("INSERT INTO citizenroom_business_room_ticket (`room_id`, `serial`, `nickname`) VALUES (?,?,?)");
			$stmtInsert->bind_param('iss', $room_id, $serial, $nickname);
			$resultInsert = $stmtInsert->execute();

			if($resultInsert==true){
				//$_SESSION["ticket.message"] = $lang['ROOM_TICKET_ADD_OK'];
			}else{
				$_SESSION["ticket.error"] = $lang['ROOM_TICKET_ADD_ERROR'];
			}
			mysqli_free_result($resultInsert);
			mysqli_free_result($result);
			mysqli_stmt_close($stmtCheck);
			mysqli_stmt_close($stmtInsert);
		}
	}
	
	public function ticketAdd($room_id,$serial,$nickname,$link,$lang){   
		$this->ticketAddInternal($room_id,$serial,$nickname,$link,$lang);
        header('Location: ../../../web/ticket?type=business&room_id='.$room_id);
    }
	
	public function ticketDeleteAll($room_id,$serial,$link,$lang){
		$stmtDeleteTickets = mysqli_stmt_init($link);
		$stmtDeleteTickets->prepare("DELETE FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ?");
		$stmtDeleteTickets->bind_param('is', $room_id, $serial);
		$resultDeleteTickets = $stmtDeleteTickets->execute();
	}
	
	public function ticketDelete($room_id,$serial,$nickname,$link,$lang){   			
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ? AND nickname = ?");
		$stmtCheck->bind_param('iss', $room_id, $serial, $nickname);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
		$arr = array('success' => 'false');
        if( mysqli_num_rows( $result ) == 1){
			$stmtDelete = mysqli_stmt_init($link);
			$stmtDelete->prepare("DELETE FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ? AND nickname = ?");
			$stmtDelete->bind_param('iss', $room_id, $serial, $nickname);
			$resultDelete = $stmtDelete->execute();
			
			if($resultDelete==true && $resultDeleteSubs==true){
				$_SESSION["ticket.message"] = $lang['ROOM_DELETE_OK'];
				$arr = array('success' => 'true', 'message' => $lang['ROOM_DELETE_OK']);
			}else{
				$_SESSION["ticket.error"] = $lang['ROOM_DELETE_ERROR'];
				$arr = array('success' => 'false', 'message' => $lang['ROOM_DELETE_ERROR']);
			}
			mysqli_free_result($result);
			mysqli_free_result($resultDelete);
			mysqli_free_result($resultDeleteSubs);
			mysqli_stmt_close($stmtCheck);
			mysqli_stmt_close($stmtDelete);
			mysqli_stmt_close($stmtDeleteSubs);
		}
     
        print json_encode($arr);
	}
	
	public function ticketGet($serial,$room_id,$link,$lang){   			
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ? ORDER BY nickname ASC");
		$stmtCheck->bind_param('is', $room_id, $serial);
		$stmtCheck->execute();
		$result = $stmtCheck->get_result();
		$myArray = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray[] = $row;
		}
		print json_encode($myArray);
	}
	
	public function nicknameHasValidTicket($serial,$room_id,$nickname,$link){ 
		$stmtCheckIsWithTicket = mysqli_stmt_init($link);
		$stmtCheckIsWithTicket->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ? AND withTicket = 1");
		$stmtCheckIsWithTicket->bind_param('is', $room_id, $serial);
		$stmtCheckIsWithTicket->execute();
		$resultCheckIsWithTicket = $stmtCheckIsWithTicket->get_result();
		
		$stmtCheck = mysqli_stmt_init($link);
		$stmtCheck->prepare("SELECT * FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ? AND nickname = ? AND (used = 0 OR (used = 1 AND UUID = ?))");
		$stmtCheck->bind_param('isss', $room_id, $serial, $nickname, $this->getUUID());
		$stmtCheck->execute();
		$resultCheck = $stmtCheck->get_result();
		
		$withoutTicket = mysqli_num_rows( $resultCheckIsWithTicket ) == 0;
		$hasValidTicket = mysqli_num_rows( $resultCheck )  > 0;
		mysqli_free_result($resultCheckIsWithTicket);
		mysqli_stmt_close($stmtCheckIsWithTicket);
		mysqli_free_result($resultCheck);
		mysqli_stmt_close($stmtCheck);
		return $withoutTicket || $hasValidTicket;
	}
	
	public function validTicket($serial,$room_id,$nickname,$link){ 	
		$stmtUpdate = mysqli_stmt_init($link);
		$stmtUpdate->prepare("UPDATE citizenroom_business_room_ticket SET used = 1, UUID = ? WHERE room_id = ? AND serial = ? AND nickname = ?");
		$stmtUpdate->bind_param('siss', $this->getUUID(), $room_id, $serial, $nickname);
		return $stmtUpdate->execute();
	}
	
	public function ticketValidate($room_id,$serial,$nickname,$link,$lang){
		$stmtCheckIsWithTicket = mysqli_stmt_init($link);
		$stmtCheckIsWithTicket->prepare("SELECT * FROM citizenroom_business_room WHERE room_id = ? AND serial = ? AND withTicket = 1");
		$stmtCheckIsWithTicket->bind_param('is', $room_id, $serial);
		$stmtCheckIsWithTicket->execute();
		$resultCheckIsWithTicket = $stmtCheckIsWithTicket->get_result();
		$roomWithTicket = mysqli_num_rows( $resultCheckIsWithTicket );
		
		mysqli_free_result($resultCheckIsWithTicket);
		mysqli_stmt_close($stmtCheckIsWithTicket);
		
		if($roomWithTicket == 0){
			$arr = array('success' => 'true', 'message' => $nickname.' '.$lang['ROOM_TICKET_VALIDATION_OK']);
		} else {
			$stmtCheck = mysqli_stmt_init($link);
			$stmtCheck->prepare("SELECT * FROM citizenroom_business_room_ticket WHERE room_id = ? AND serial = ? AND nickname = ? AND used = 1");
			$stmtCheck->bind_param('iss', $room_id, $serial, $nickname);
			$stmtCheck->execute();
			$resultCheck = $stmtCheck->get_result();
			if(mysqli_num_rows( $resultCheck ) == 0){
				$arr = array('success' => 'false', 'message' => $nickname.' '.$lang['ROOM_TICKET_VALIDATION_FAILED']);
			} else {
				while($row = $resultCheck->fetch_array(MYSQLI_BOTH)){
					$hashToCheck = md5($nickname.$room_id.$serial.((string)$row['previousHash']));
					if($hashToCheck == (string)$row['hash']){
						$arr = array('success' => 'true', 'message' => $nickname.' '.$lang['ROOM_TICKET_VALIDATION_OK']);
					} else {
						$arr = array('success' => 'false', 'message' => $nickname.' '.$lang['ROOM_TICKET_VALIDATION_FAILED']);
					}
				}
			}
		}
     
        print json_encode($arr);
	}
	
	public function leftRoom($link){
		$arr = array('success' => 'false');
		$stmt = mysqli_stmt_init($link);
		if(isset($_SESSION['serial']) && $_SESSION['serial']!=''){
			$stmt->prepare("DELETE FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ? AND citizenroom_subscription.serial = ?");
			$stmt->bind_param('iss',$_SESSION['room_id'],$_SESSION['nickname'],$_SESSION['serial']);
		} else {
			$stmt->prepare("DELETE FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ? AND citizenroom_subscription.serial = 'PUBLIC'");
			$stmt->bind_param('is',$_SESSION['room_id'],$_SESSION['nickname']);
		}
		
		$resultUpdate = $stmt->execute();
		$arr = array('success' => $resultUpdate);
		mysqli_stmt_close($stmt);
			
		unset($_SESSION['room_id']);
		unset($_SESSION['nickname']);
		unset($_SESSION['password']);
		unset($_SESSION['serial']);
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);
		
		print json_encode($arr);
	}
	
	public function getUUID(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   
		  {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		  }
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
		  {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		  }
		//whether ip is from remote address
		else
		  {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		  }
		return $ip_address;
	}
}
?>