<?php
class Alert{
	public function sendMail($langCode, $mail, $room_title, $nickname){		
		$to = $mail;
		$from = "citizenroom@altervista.org";
		$subject = "CitizenRoom - Room entry alert";
		$headers = "";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: CitizenRoom <'.$from.'>' . "\r\n";

		$message = file_get_contents( 'mailtemplates/alert_room_entry_'.$langCode.'.tpl' ) ;
		$message = str_replace( '__MAIL__', $mail, $message );
		$message = str_replace( '__ROOMTITLE__', $room_title, $message );
		$message = str_replace( '__NICKNAME__', $nickname, $message );
		mail($to,$subject,$message,$headers);
	}
}
?>