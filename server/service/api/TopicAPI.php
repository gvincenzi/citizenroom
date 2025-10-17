<?php
include_once '../lang.php';
include '../langs/'. prefered_language($available_languages) .'.php';

session_start();
$api = new TopicAPI();

if (isset($_REQUEST['method'] )){
	switch ($_REQUEST['method']) {
		case 'init':
			if(isset($_REQUEST['room_type']) && $_REQUEST['room_type']=='topic'){
				$api->init($_REQUEST['room_topic_name'],$_REQUEST['room_topic_domain']);
			}
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
}
?>
