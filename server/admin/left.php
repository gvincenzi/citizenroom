<?php
	include_once 'config.php';
	session_start();
	
	// Let's connect to host
	$link = mysqli_connect($hostname, $username, $password, $dbname) or DIE('Error: '.mysqli_connect_error());
		
	$stmt = mysqli_stmt_init($link);
	//Prepare the SQL statement, with ? to reflect the parameters to be supplied later.
	$stmt->prepare("DELETE FROM citizenroom_subscription WHERE citizenroom_subscription.room_id = ? AND citizenroom_subscription.nickname = ?");
	// Bind parameters (an integer and a string). 'is' tells MySQL you're passing an integer(i) and a string(s)
	$stmt->bind_param('is',$_SESSION['room_id'],$_SESSION['nickname']);
	$stmt->execute(); 
	mysqli_stmt_close($stmt);
	session_destroy();
	header('Location: ../../web/join');
		
?>