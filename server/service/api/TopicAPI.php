<?php
require_once 'API.php';

$api = new API();
$topicApi = new TopicAPI();

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {
		case 'init':
			if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='topic' && isset($_REQUEST['room_topic_name']) && isset($_REQUEST['room_topic_domain'])){
				$topicApi->init($_REQUEST['room_topic_name'],$_REQUEST['room_topic_domain']);
			}
			break;
		case 'join':
			if(isset($_REQUEST['room_type']) && ($_REQUEST['room_type']=='topic')){
				$topicApi->join($_REQUEST['room_topic_name'],$_REQUEST['room_topic_domain'],$_REQUEST['room_type'],$_REQUEST['nickname'],$_REQUEST['room_id'],$_REQUEST['room_title'] ?? "",$_REQUEST['room_logo'] ?? "",$_REQUEST['room_custom_link'] ?? "", $_REQUEST['room_topic_name'], $_REQUEST['room_topic_domain']);
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

class TopicAPI {
	public function init($topicName,$topicDomain){
		//READ DATA
		$file = fopen("../../data/topic/$topicName/$topicDomain.csv","r");
		$keys = fgetcsv($file, escape: "\\");
		$topic_data = [];
		while ($line = fgetcsv($file, escape: "\\")) {
			$data = array_combine($keys, $line);
			$topic_data[] = $data;
		}
		fclose($file);
		$tojson = json_encode($topic_data,JSON_UNESCAPED_UNICODE);
		print $tojson;
	}

	public function join($topicName,$topicDomain,$room_type,$nickname,$room_id,$room_title,$room_logo,$room_custom_link,$room_topic_name,$room_topic_domain){
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);
		unset($_SESSION['room_custom_link']);
		unset($_SESSION['room_additional_data']);
		unset($_SESSION['room_topic_name']);
		unset($_SESSION['room_topic_domain']);

		$_SESSION['room_id'] = $room_id;
        $_SESSION['nickname'] = $nickname;
		$_SESSION['room_type'] = $room_type;
		$_SESSION['room_topic_name'] = $room_topic_name;
		$_SESSION['room_topic_domain'] = $room_topic_domain;
		
		$filename = "../../data/topic/$topicName/$topicDomain.csv";

		if (file_exists($filename)) {
			//READ DATA
			$file = fopen($filename,"r");
			$keys = fgetcsv($file, escape: "\\");
			$topic_data = [];
			while ($line = fgetcsv($file, escape: "\\")) {
				$data = array_combine($keys, $line);
				$topic_data[] = $data;
			}
			fclose($file);
		}

		if($topicName == "parliament"){
			switch($topicDomain)
			{
				case 'france';
					foreach($topic_data as $french_national_assembly_delegate){
						if($french_national_assembly_delegate['uid'] == $room_id)
						{
							$_SESSION['room_title'] = stripslashes($french_national_assembly_delegate['firstname'].' '.$french_national_assembly_delegate['lastname']);
							$_SESSION['room_logo'] = "https://upload.wikimedia.org/wikipedia/commons/a/a7/Logo_de_l%27Assembl%C3%A9e_nationale_fran%C3%A7aise.svg";
							$_SESSION['room_custom_link'] = "https://www.assemblee-nationale.fr/dyn/deputes/PA".$french_national_assembly_delegate['uid'];

							//ADDITIONAL TOPIC DATA
							$_SESSION['room_additional_data'] = $french_national_assembly_delegate;
							$_SESSION['room_additional_data']['h5'] = $french_national_assembly_delegate['group'];
							$_SESSION['room_additional_data']['h6'] = $french_national_assembly_delegate['departement'].' ('.$french_national_assembly_delegate['circonscription'].'<sup>e</sup> circonscription)';
							$_SESSION['room_additional_data']['photo']="https://www2.assemblee-nationale.fr/static/tribun/17/photos/".$french_national_assembly_delegate['uid'].".jpg";
							$_SESSION['room_additional_data']['country'] = $topicDomain;
							break;
						}
					}
					break;
				case 'italy';
					foreach($topic_data as $italian_deputy){
						if($italian_deputy['uid'] == $room_id)
						{
							$_SESSION['room_title'] = stripslashes($italian_deputy['firstname'].' '.$italian_deputy['lastname']);
							$_SESSION['room_logo'] = "https://www.camera.it/application/xmanager/projects/leg19/img/header/logo_camera.jpg";
							$_SESSION['room_custom_link'] = "https://www.camera.it/leg19/29?tipoAttivita=&tipoVisAtt=&tipoPersona=&idLegislatura=19&shadow_deputato=".$italian_deputy['uid'];

							//ADDITIONAL TOPIC DATA
							$_SESSION['room_additional_data'] = $italian_deputy;
							$_SESSION['room_additional_data']['h5'] = $italian_deputy['group'];
							$_SESSION['room_additional_data']['h6'] = $italian_deputy['departement'].' ('.$italian_deputy['circonscription'].')';
							$_SESSION['room_additional_data']['photo']="https://documenti.camera.it/_dati/leg19/schededeputatinuovosito/fotoDefinitivo/big/d".$italian_deputy['uid'].".jpg";
							$_SESSION['room_additional_data']['country'] = $topicDomain;
							break;
						}
					}
					break;
				case 'europe';
					foreach($topic_data as $european_deputy){
						if($european_deputy['mep_identifier'] == $room_id)
						{
							$_SESSION['room_title'] = stripslashes($european_deputy['mep_given_name'].' '.$european_deputy['mep_family_name']);
							$_SESSION['room_logo'] = "https://upload.wikimedia.org/wikipedia/commons/1/1e/European_Parliament_logo.svg";
							$_SESSION['room_custom_link'] = "https://www.europarl.europa.eu/meps/". substr($_COOKIE['citizenroom']['bestlang'],0,2)."/".$european_deputy['mep_identifier'];

							//ADDITIONAL TOPIC DATA
							$_SESSION['room_additional_data'] = $european_deputy;
							$_SESSION['room_additional_data']['h5'] = $european_deputy['mep_country_of_representation'];
							$_SESSION['room_additional_data']['h6'] = $european_deputy['mep_political_group'];
							$_SESSION['room_additional_data']['photo']=$european_deputy['mep_image'];
							$_SESSION['room_additional_data']['country'] = $topicDomain;
							break;
						}
					}
					break;
			}
			
		} else if($topicName == "municipality"){
			switch($topicDomain)
			{
				case 'france';
					$url = "https://geo.api.gouv.fr/communes?code=$room_id&fields=code,nom,mairie,region,departement";
					$response = @file_get_contents($url);
					$topic_data = json_decode($response, true);
					foreach($topic_data as $french_municipality){
						$_SESSION['room_title'] = stripslashes($french_municipality['nom']);
						$_SESSION['room_logo'] = "https://upload.wikimedia.org/wikipedia/fr/thumb/2/22/Republique-francaise-logo.svg/768px-Republique-francaise-logo.svg.png";
						$_SESSION['room_custom_link'] = "https://".substr($_COOKIE['citizenroom']['bestlang'],0,2).".wikipedia.org/wiki/".$french_municipality['nom'];

						//ADDITIONAL TOPIC DATA
						$_SESSION['room_additional_data'] = $french_municipality;
						$_SESSION['room_additional_data']['h5'] = $french_municipality['departement']['nom'].' ('.$french_municipality['departement']['code'].')';
						$_SESSION['room_additional_data']['h6'] = $french_municipality['region']['nom'];
						$_SESSION['room_additional_data']['photo'] = "";
						$_SESSION['room_additional_data']['lat'] = $french_municipality['mairie']['coordinates'][1];
						$_SESSION['room_additional_data']['lng'] = $french_municipality['mairie']['coordinates'][0];
						$_SESSION['room_additional_data']['country'] = $topicDomain;
						break;
					}
					break;
			}
		}

		header("Location: ../../../web/topic/$topicName/room");
	}
}
?>
