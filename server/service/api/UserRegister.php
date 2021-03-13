<?php
class UserRegister{
	public function register($langCode, $mail, $link){
		if ($mail=='') {
			echo ('Please Fill Email');
		}

		$new_user_mail = $mail;
		
		// Lets see if the email exists
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT citizenroom_user.name as user_name, citizenroom_user.surname as user_surname FROM citizenroom_user WHERE mail = ? AND password IS NULL");
		$stmt->bind_param('s', $new_user_mail);
		$stmt->execute();
		$result = $stmt->get_result();
		if( mysqli_num_rows( $result ) == 1){
			$name = null;
			$surname=null;
			while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
				$name = $row['user_name'];
				$surname = $row['user_surname'];
			}
			
			//Generate a RANDOM MD5 Hash for a password
			$random_password=md5(uniqid(rand()));
			
			//Take the first 8 digits and use them as the password we intend to email the user
			$emailpassword=substr($random_password, 0, 8);
			
			//Encrypt $emailpassword in MD5 format for the database
			$newpassword = md5($emailpassword);
			
			//Generate Serial Number
			$serial = $this->generateSerialNumber();
			while(!$this->serialUnique($serial,$link)) {
				$serial = $this->generateSerialNumber();
			}
			
			mysqli_free_result($result);
			mysqli_stmt_close($stmt);
			
			$stmt2 = mysqli_stmt_init($link);
			$stmt2->prepare("UPDATE `citizenroom_user` SET `password` = ?,`serial` = ? WHERE `mail` = ?");
			$stmt2->bind_param('sss', $newpassword, $serial, $new_user_mail);
			$stmt2->execute();
			mysqli_stmt_close($stmt2);
			
			$this->sendMailUserRegister($new_user_mail, $name, $surname, $emailpassword, $langCode);
			
			return true;
		}else{
			return false;
		}
	}

	public function sendMailUserRegister($mail, $name, $surname, $password, $langCode){
		$to = $mail;
		$from = "citizenroom@altervista.org";
		$subject = "CitizenRoom Subscription";
		$headers = "";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: CitizenRoom <'.$from.'>' . "\r\n";

		$message = file_get_contents( 'mailtemplates/userregister_'.$langCode.'.tpl' ) ;
		$message = str_replace( '__NAME__', $name, $message );
		$message = str_replace( '__SURNAME__', $surname, $message );
		$message = str_replace( '__MAIL__', $mail, $message );
		$message = str_replace( '__PASSWORD__', $password, $message );
		
		mail($to,$subject,$message,$headers);
	}
	
	public function resetPassword($langCode, $mail, $link){
		if ($mail=='') {
			echo ('Please Fill Email');
		}
		
		// Lets see if the email exists
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_user WHERE mail = ?");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$result = $stmt->get_result();
		if( mysqli_num_rows( $result ) == 0) {
			return false;
		}
		
		mysqli_free_result($result);
		mysqli_stmt_close($stmt);
		
		//Generate a RANDOM MD5 Hash for a password
		$random_password=md5(uniqid(rand()));
		
		//Take the first 8 digits and use them as the password we intend to email the user
		$emailpassword=substr($random_password, 0, 8);
		
		//Encrypt $emailpassword in MD5 format for the database
		$newpassword = md5($emailpassword);
		
		// Make a safe query			
		$stmt2 = mysqli_stmt_init($link);
		$stmt2->prepare("UPDATE `citizenroom_user` SET `password` = ? WHERE `mail` = ?");
		$stmt2->bind_param('ss', $newpassword, $mail);
		$stmt2->execute();
		mysqli_stmt_close($stmt2);
		
		$this->sendMailResetPassword($mail, $emailpassword, $langCode);
		return true;
	}
	
	public function sendMailResetPassword($mail, $password, $langCode){
		$to = $mail;
		$from = "citizenroom@altervista.org";
		$subject = "CitizenRoom - Reset password";
		$headers = "";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: CitizenRoom <'.$from.'>' . "\r\n";

		$message = file_get_contents( 'mailtemplates/passwordchanger_'.$langCode.'.tpl' ) ;
		$message = str_replace( '__MAIL__', $mail, $message );
		$message = str_replace( '__PASSWORD__', $password, $message );
		mail($to,$subject,$message,$headers);
	}
    
    public function generateSerialNumber(){
		//Generate a RANDOM MD5 Hash for a serial number
		$random_serial=md5(uniqid(rand()));
		//Take the first 6 digits and use them as a serial number
		$serial=substr($random_serial, 0, 6);
		
		return $serial;
	}
	
	public function serialUnique($serial,$link){
	// Lets see if the email exists
		$stmt = mysqli_stmt_init($link);
		$stmt->prepare("SELECT * FROM citizenroom_user WHERE serial = ?");
		$stmt->bind_param('s', $serial);
		$stmt->execute();
		$result = $stmt->get_result();
		if( mysqli_num_rows( $result ) >0) {
			return false;
		} else {
			return true;
		}
	}
}
?>