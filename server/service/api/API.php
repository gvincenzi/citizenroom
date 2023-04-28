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
			} else if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='custom'){
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
		case 'country':
			$api->country($_REQUEST['room_country'], $link, $lang);
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
	
    public function joinCustom($room_title,$room_logo,$nickname,$room_id,$room_type,$link){
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);
		unset($_SESSION['room_country']);
		unset($_SESSION['room_place']);
		unset($_SESSION['room_wikipedia']);
		unset($_SESSION['room_website']);
		unset($_SESSION['room_mail']);

		$_SESSION['room_title'] = stripslashes($room_title);
		$_SESSION['room_logo'] = $room_logo;

		$this->join($nickname,$room_id,$room_type,$link);
	}

	public function joinTheme($nickname,$room_id,$room_type,$link){
    	unset($_SESSION['room_title']);
    	unset($_SESSION['room_logo']);
    	unset($_SESSION['room_country']);
    	unset($_SESSION['room_place']);
    	unset($_SESSION['room_wikipedia']);
    	unset($_SESSION['room_website']);
    	unset($_SESSION['room_mail']);

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
		unset($_SESSION['room_country']);
		unset($_SESSION['room_place']);
		unset($_SESSION['room_wikipedia']);
		unset($_SESSION['room_website']);
		unset($_SESSION['room_mail']);

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
			$row["name"] = ( $row["name"] );
			$row["shortcode"] = ( sprintf("%02s", $row["shortcode"]) );
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
		$row["name"] = ( $row["name"] );
		$row["dept"] = ( $row["dept"] );
		$row["shortcode"] = ( sprintf("%02s", $row["shortcode"]) );
		$row["region"] = ( $row["region"] );
		$row["wikipedia"] = ( $row["wikipedia"] );
		return $row;
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
