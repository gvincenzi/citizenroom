<?php
include_once 'lang.php';
include 'langs/'. prefered_language($available_languages) .'.php';
// Include database connection settings
include_once 'config.php';
// Inialize session
session_start();
$link = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Error: '.mysqli_connect_error());
$stmt = mysqli_stmt_init($link);
$stmt->prepare("SELECT * FROM citizenroom_user WHERE enabled=1 and mail = ? and password = ?");
$stmt->bind_param('ss', mysqli_real_escape_string($link, $_POST['mail']),md5(mysqli_real_escape_string($link, $_POST['password'])));
$stmt->execute(); 
$result = $stmt->get_result();
		
// Check username and password match
if( mysqli_num_rows( $result ) == 1){
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		$_SESSION["login.error"] = NULL;
		$_SESSION['user'] = (string)($row['user_id']);
		$_SESSION['user_name'] = (string)($row['name']);
		$_SESSION['user_surname'] = (string)($row['surname']);
        $_SESSION['user_mail'] = (string)($row['mail']);
        $_SESSION['user_serial'] = (string)($row['serial']);
		$_SESSION['user_stream_key'] = (string)($row['stream_key']);
	}

	$stmtLastLogin = mysqli_stmt_init($link);
	$stmtLastLogin->prepare("UPDATE citizenroom_user SET last_login=now() WHERE user_id = ?");
	$stmtLastLogin->bind_param('i', $_SESSION['user']);
	$stmtLastLogin->execute(); 
	
	// Jump to secured page
	header('Location: ../../web/'.$_POST['path']);
}
else {
	// Jump to login page
	$_SESSION["login.error"] = $lang['LOGIN_ERROR'];
	header('Location: ../../web/login/?path='.$_POST['path']);
}

?>