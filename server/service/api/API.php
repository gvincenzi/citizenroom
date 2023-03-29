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
			if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='civic_hall'){
				$api->joinCountry($_REQUEST['room_country'], $_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['room_type'], $link);
			} else if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='public'){
				$api->join($_REQUEST['nickname'], $_REQUEST['room_id'], $_REQUEST['room_type'], $link);
			}
			break;
		case 'left':
			$api->leftRoom($link);
			break;
		case 'rooms/check':
			$api->checkRoom($_GET['room_id'], $link);
			break;
		case 'subscription/check':
			$api->checkSubscription($_REQUEST['nickname'], $_REQUEST['room_id'], $link);
			break;
		case 'country':
			$api->country($_REQUEST['room_country'], $link, $lang);
			break;
	}
}else {
	$arr = array('success' => 'false', 'message' => 'Error in input parameters');
	print $arr;
}

class API{
	public function checkSubscription($nickname,$room_id,$link){
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ?");
		$stmt->bind_param('is', $room_id,$nickname);
		$stmt->execute(); 
		$result = $stmt->get_result();
		if( mysqli_num_rows( $result ) == 0){
		
			unset($_SESSION['room_id']);
			unset($_SESSION['nickname']);

			$arr = array('success' => 'false', 'message' => 'Subscription does not exist');
		} else {
			$arr = array('success' => 'true', 'message' => 'Subscription OK');
		}
		
		print json_encode($arr);
	}

    public function join($nickname,$room_id,$room_type,$link){
		$nickname = mysqli_real_escape_string($link, $nickname);
    	
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
        $_SESSION['room_type'] = $room_type;
        
        header('Location: ../../../web/room');
    }
	
	public function joinCountry($country,$nickname,$room_id,$room_type,$link){
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);
		unset($_SESSION['room_country']);
		unset($_SESSION['room_place']);
		unset($_SESSION['room_wikipedia']);
		unset($_SESSION['room_website']);
		unset($_SESSION['room_mail']);
		
		$place = $this->getCountryPlaceInfo($country,$room_id,$link);
		$_SESSION['room_title'] = stripslashes($place['name']);
		$_SESSION['room_logo'] = $place['logo'];
		$_SESSION['room_country'] = $_REQUEST['room_country'];
		$_SESSION['room_place'] = $place['dept'].' ('.$place['shortcode'].'), '.$place['region'];
		$_SESSION['room_wikipedia'] = $place['wikipedia'];
		$_SESSION['room_website'] = $place['website'];
		$_SESSION['room_mail'] = $place['email'];
		
		$this->join($nickname,$room_id,$room_type,$link);
	}
	


	public function leftRoom($link){
		$arr = array('success' => 'false');
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("DELETE FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ?");
		$stmt->bind_param('is',$_SESSION['room_id'],$_SESSION['nickname']);

		$resultUpdate = $stmt->execute();
		$arr = array('success' => $resultUpdate);
		mysqli_stmt_close($stmt);
			
		unset($_SESSION['room_id']);
		unset($_SESSION['nickname']);
		unset($_SESSION['room_type']);
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);
		unset($_SESSION['room_country']);
		unset($_SESSION['room_place']);
		unset($_SESSION['room_wikipedia']);
		unset($_SESSION['room_website']);
		unset($_SESSION['room_mail']);
		
		print json_encode($arr);
	}
	
	public function country($room_country, $link){
		$stmt = mysqli_stmt_init($link);
		
		switch($room_country){
			case "italy":
				if(isset($_REQUEST['room_id'])){
					$stmt->prepare("SELECT comune as name, pro_com_t as room_id, lat as latitude, citizenroom_country_italy.long as longitude FROM citizenroom_country_italy WHERE pro_com_t = ?");
					$stmt->bind_param('s', $_REQUEST['room_id']);
				} else {
					$stmt->prepare("SELECT comune as name, pro_com_t as room_id, sigla as shortcode FROM citizenroom_country_italy order by comune"); 
				}
				break;
			case "france":
				if(isset($_REQUEST['room_id'])){
					$stmt->prepare("SELECT nom_commune_complet as name,code_commune_INSEE as room_id, latitude as latitude, longitude as longitude FROM citizenroom_country_france WHERE code_commune_INSEE = ? and ligne_5 = ''");
					$stmt->bind_param('s', $_REQUEST['room_id']);
				} else {
					$stmt->prepare("SELECT nom_commune_complet as name,code_commune_INSEE as room_id, code_departement as shortcode FROM citizenroom_country_france WHERE ligne_5 = '' order by nom_commune_complet"); break;
				}
				break;
		}
		
		$stmt->execute(); 
		$result = $stmt->get_result();
		$myArray = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row["name"] = utf8_encode( $row["name"] );
			$row["shortcode"] = utf8_encode( sprintf("%02s", $row["shortcode"]) );
            $myArray[] = $row;
		}
		
		$tojson = json_encode($myArray,JSON_UNESCAPED_UNICODE);
		print $tojson;
	}
	
	public function getCountryPlaceInfo($country,$room_id,$link){ 
		$stmt = mysqli_stmt_init($link);
		
		switch($country){
			case "italy":$stmt->prepare("SELECT comune as name, stemma as logo, den_prov as dept, sigla as shortcode, den_reg as region, wikipedia as wikipedia, sito_web as website, mail as email FROM citizenroom_country_italy WHERE pro_com_t = ?"); break;
			case "france":$stmt->prepare("SELECT nom_commune_complet as name, nom_departement as dept, code_departement as shortcode, nom_region as region, CONCAT('https://fr.wikipedia.org/wiki/', nom_commune_complet) as wikipedia, citizenroom_country_france_blason.url as logo FROM citizenroom_country_france LEFT JOIN citizenroom_country_france_blason on upper(citizenroom_country_france_blason.url) like concat('%',nom_commune_complet,'%') WHERE code_commune_INSEE = ? and ligne_5 = '' limit 1"); break;
			
			
		}
		
		$stmt->bind_param('s', $room_id);
		$stmt->execute(); 
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$row["name"] = utf8_encode( $row["name"] );
		$row["dept"] = utf8_encode( $row["dept"] );
		$row["shortcode"] = utf8_encode( sprintf("%02s", $row["shortcode"]) );
		$row["region"] = utf8_encode( $row["region"] );
		$row["wikipedia"] = utf8_encode( $row["wikipedia"] );
		return $row;
	}
}
?>
