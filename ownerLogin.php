<?php
session_start();

require 'db_config.php';
require 'log.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if(!$conn){
	die('Count not connect: ' .mysql_error());
}

//Check login
if(!empty($_POST['email']) &&!empty($_POST['password'])){
	$email = $_POST['email'];
	$formPassword = $_POST['password'];

	//Checking password and ID via cookie
	if($stmt = $conn->prepare("SELECT user_id, password FROM Users A WHERE A.email=?")){
		$stmt->bind_param("s", $email);
		$stmt->execute();

		$stmt->bind_result($user_id, $password);
		$stmt->fetch();

		logToFile($user_id);
		logToFile($password);

		//Check the passowrd and redirect if wrong
		if(password_verify($formPassword, $password)){
			logToFile('Successful Login');
			$_SESSION['login_user'] = $user_id;
			setcookie("owner", $user_id, time() + (86400 * 30), '/');
			if(isset($_SESSION['login_user']))
				redirect('ownerHome.php');
		}
		else{
			logToFile("Login incorrect");
			redirect('ownerLogin.html');
		}
			
		$stmt->close();
	}
}
mysqli_close($conn);
?>
