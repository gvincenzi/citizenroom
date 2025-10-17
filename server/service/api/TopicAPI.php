<?php
include_once 'API.php';

$api = new API();
$topicApi = new TopicAPI($api);

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {
		case 'init':
			if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='custom' && isset($_REQUEST['room_topic_name']) && isset($_REQUEST['room_topic_domain'])){
				$topicApi->init($_REQUEST['room_topic_name'],$_REQUEST['room_topic_domain']);
			}
			break;
		case 'join':
			if(isset($_REQUEST['room_type']) && ($_REQUEST['room_type']=='custom')){
				$topicApi->join($_REQUEST['room_topic_name'],$_REQUEST['room_topic_domain'],$_REQUEST['room_type'],$_REQUEST['nickname'],$_REQUEST['room_id'],$_REQUEST['room_title'] ?? "",$_REQUEST['room_logo'] ?? "",$_REQUEST['room_custom_link'] ?? "");
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
	protected $api;
        
    public function __construct($baseApi){
        $this->api = $baseApi;
    }

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

	public function join($topicName,$topicDomain,$room_type,$nickname,$room_id,$room_title,$room_logo,$room_custom_link){
		unset($_SESSION['room_title']);
		unset($_SESSION['room_logo']);
		unset($_SESSION['room_custom_link']);
		unset($_SESSION['room_additional_data']);
		
		//READ DATA
		$file = fopen("../../data/topic/$topicName/$topicDomain.csv","r");
		$keys = fgetcsv($file, escape: "\\");
		$topic_data = [];
		while ($line = fgetcsv($file, escape: "\\")) {
			$data = array_combine($keys, $line);
			$topic_data[] = $data;
		}
		fclose($file);

		if($topicName == "parliament"){
			switch($topicDomain)
			{
				case 'france';
					foreach($topic_data as $french_national_assembly_delegate){
						if($french_national_assembly_delegate['uid'] == $room_id)
						{
							$room_title = stripslashes($french_national_assembly_delegate['firstname'].' '.$french_national_assembly_delegate['lastname']);
							$room_logo = "https://upload.wikimedia.org/wikipedia/commons/a/a7/Logo_de_l%27Assembl%C3%A9e_nationale_fran%C3%A7aise.svg";
							$room_custom_link = "https://www.assemblee-nationale.fr/dyn/deputes/PA".$french_national_assembly_delegate['uid'];

							//ADDITIONAL TOPIC DATA
							$_SESSION['room_additional_data'] = $french_national_assembly_delegate;
							$_SESSION['room_additional_data']['photo']="https://www2.assemblee-nationale.fr/static/tribun/17/photos/".$french_national_assembly_delegate['uid'].".jpg";
							break;
						}
					}
					break;
				case 'italy';
					foreach($topic_data as $italian_deputy){
						if($italian_deputy['uid'] == $room_id)
						{
							$room_title = stripslashes($italian_deputy['firstname'].' '.$italian_deputy['lastname']);
							$room_logo = "https://upload.wikimedia.org/wikipedia/commons/4/4d/Logo_della_Camera_dei_deputati.svg";
							$room_custom_link = "https://www.camera.it/leg19/29?tipoAttivita=&tipoVisAtt=&tipoPersona=&idLegislatura=19&shadow_deputato=".$italian_deputy['uid'];

							//ADDITIONAL TOPIC DATA
							$_SESSION['room_additional_data'] = $italian_deputy;
							$_SESSION['room_additional_data']['photo']="https://documenti.camera.it/_dati/leg19/schededeputatinuovosito/fotoDefinitivo/big/d".$italian_deputy['uid'].".jpg";
							break;
						}
					}
					break;
			}
			
		}

		$this->api->join($room_type,$nickname,$room_id,$room_title,$room_logo,$room_custom_link);
	}
}
?>
