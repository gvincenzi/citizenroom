<?php
include_once '../../admin/config.php';

session_start();
$link = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Error: '.mysqli_connect_error());
$api = new ReservationAPI();
$api->conference($link);

class ReservationAPI{
    public function conference($link){
        $stmt = mysqli_stmt_init($link);
        parse_str(file_get_contents("php://input"), $data);
        $data = (object)$data;
        //$arr = array('id' => '364758328','mail_owner' => 'citizenroom@altervista.org', 'name' => $data->name,'start_time' => $data->start_time, 'duration' => '900000');
        //$arr = array('message' => 'Reservation KO');

        $name_str_arr = preg_split ("/\_/", $data->name);

        if($name_str_arr[2]=='themed'){
            $stmt->prepare("SELECT * FROM citizenroom_theme WHERE room_id=?");
            $stmt->bind_param('s', $name_str_arr[1]);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows != 1){
                $arr = array('message' => 'You cannot join the '.$data->name.' room');
                $tojson = json_encode($arr,JSON_UNESCAPED_UNICODE);

                http_response_code(401);
                print $tojson;
            } else {
                $row = $result->fetch_assoc();
                $arr = array('id' => $name_str_arr[1], 'mail_owner' => 'citizenroom@altervista.org', 'name' => $data->name,'start_time' => $data->start_time,
                'duration' => 900000,
                'max_occupants' => $row['max_occupants'],
                'password' => $row['room_id'].'_'.$row['password']);
                $tojson = json_encode($arr,JSON_UNESCAPED_UNICODE);
                http_response_code(201);
                print $tojson;
            }
        } else {
            $arr = array('id' => $name_str_arr[1], 'mail_owner' => 'citizenroom@altervista.org', 'name' => $data->name,'start_time' => $data->start_time, 'duration' => 900000);
            $tojson = json_encode($arr,JSON_UNESCAPED_UNICODE);
            http_response_code(201);
            print $tojson;
        }       
    }
}
?>