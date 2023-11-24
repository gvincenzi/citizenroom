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
            } else if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='themed'){
             	$api->joinTheme($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['room_type'], $link);
             } else if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='public'){
				$api->join($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['room_type'], $link);
			}
			break;
		case 'left':
			$api->leftRoom($link);
			break;
		case 'theme':
        	$api->theme($link, $lang);
        	break;
        case 'themeDetails':
            $api->themeDetails($_REQUEST['room_id'], true, $link);
            break;
	}
}else {
	$arr = array('success' => 'false', 'message' => 'Error in input parameters');
	print $arr;
}

class API{
    public function join($nickname,$room_id,$room_type,$link){
		$nickname = mysqli_real_escape_string($link, $nickname);
    	
		$_SESSION['room_id'] = $room_id;
        $_SESSION['nickname'] = $nickname;
        $_SESSION['room_type'] = $room_type;
        
        header('Location: ../../../web/room');
    }
	
    public function joinCustom($room_title,$room_logo,$nickname,$room_id,$room_type,$link){
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);

		$_SESSION['room_title'] = stripslashes($room_title);
		$_SESSION['room_logo'] = $room_logo;

		$this->join($nickname,$room_id,$room_type,$link);
	}

	public function joinTheme($nickname,$room_id,$room_type,$link){
    	unset($_SESSION['room_title']);
    	unset($_SESSION['room_logo']);

    	unset($_SESSION['room_theme_title']);
        unset($_SESSION['room_theme_description']);
        unset($_SESSION['room_theme_info']);
        unset($_SESSION['room_theme_image']);
    	unset($_SESSION['room_theme_bg_image']);
    	unset($_SESSION['room_theme_bg_image_link']);
    	unset($_SESSION['room_theme_bg_image_author']);
    	unset($_SESSION['room_theme_bg_image_author_link']);

    	$theme = $this->themeDetails($room_id,false,$link);

        $this->join($nickname,$room_id,$room_type,$link);
    }

	public function leftRoom($link){
		$arr = array('success' => 'true');

		unset($_SESSION['room_id']);
		unset($_SESSION['nickname']);
		unset($_SESSION['room_type']);
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);

    	unset($_SESSION['room_theme_title']);
    	unset($_SESSION['room_theme_description']);
    	unset($_SESSION['room_theme_info']);
    	unset($_SESSION['room_theme_image']);
    	unset($_SESSION['room_theme_bg_image']);
    	unset($_SESSION['room_theme_bg_image_link']);
    	unset($_SESSION['room_theme_bg_image_author']);
    	unset($_SESSION['room_theme_bg_image_author_link']);
		
		print json_encode($arr);
	}
	
	public function theme($link){
    	$stmt = mysqli_stmt_init($link);
    	$stmt->prepare("SELECT * FROM citizenroom_theme");
    	$stmt->execute();
    	$result = $stmt->get_result();
    	$myArray = array();
    	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    		$row["title"] = ( $row["title"] );
    		$row["description"] = ( $row["description"] );
    		$row["info"] = ( $row["info"] );
            $myArray[] = $row;
    	}
   		$tojson = json_encode($myArray,JSON_UNESCAPED_UNICODE);
   		print $tojson;
   	}

   	public function themeDetails($room_id,$json,$link){
       	$stmt = mysqli_stmt_init($link);
       	$stmt->prepare("SELECT * FROM citizenroom_theme WHERE room_id=?");
       	$stmt->execute();
       	$result = $stmt->get_result();
       	$stmt->bind_param('s', $room_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $row["title"] = ( $row["title"] );
        $row["description"] = ( $row["description"] );
        $row["info"] = ( $row["info"] );

        $_SESSION['room_theme_title'] = stripslashes($row['title']);
        $_SESSION['room_theme_description'] = stripslashes($row['description']);
        $_SESSION['room_theme_info'] = stripslashes($row['info']);
        $_SESSION['room_theme_image'] = stripslashes($row['image']);

        $_SESSION['room_theme_bg_image'] = stripslashes($row['bg_image']);
        $_SESSION['room_theme_bg_image_link'] = stripslashes($row['bg_image_link']);
        $_SESSION['room_theme_bg_image_author'] = stripslashes($row['bg_image_author']);
        $_SESSION['room_theme_bg_image_author_link'] = stripslashes($row['bg_image_author_link']);

        if($json == true){
            $tojson = json_encode($row,JSON_UNESCAPED_UNICODE);
           	print $tojson;
        } else {
            return $row;
        }
    }
}
?>
