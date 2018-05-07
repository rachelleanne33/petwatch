<?php

require 'db_config.php';
require 'log.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if(!$conn){
	die('Could not connect: ' .mysql_error());
}

$sql = "SELECT MAX(user_id) AS id FROM Users";
$result = $conn->query($sql);
if($result->num_rows > 0){
	$row = mysqli_fetch_assoc($result);
	$highestID = $row["id"];
	$highestID++;
}

$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

//prepare to insert and then execute
$stmt = $conn->prepare("INSERT INTO Users (user_id, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('issss', $id, $first_name, $last_name, $email, $password);

$id = $highestID;
/*$stmt2 = $conn->prepare("INSERT INTO Pets(user_id) VALUES (?)");
$stmt2->bind_param('i', $id);
*/
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $hash;

$stmt->execute();
$stmt->close();

redirect('ownerLogin.html');

mysqli_close($conn);
?>
