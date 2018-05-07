<?php
session_start();
require 'db_config.php';
require 'log.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if(!$conn){
	die('Could not connect: ' .mysql_error());
}

$sql = "SELECT MAX(pet_id) AS id FROM Pets";
$result = $conn->query($sql);
if($result->num_rows > 0){
	$row = mysqli_fetch_assoc($result);
	$highestID = $row["id"];
	$highestID++;
}

//prepare to insert and then execute
$stmt = $conn->prepare("INSERT INTO Pets (pet_id, user_id, name, weight, height, age, serial) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('iisssss', $id, $_SESSION['login_user'], $name, $weight, $height, $age, $serial);
/*
$stmt = $conn->prepare("UPDATE Pets SET pet_id = '$id' name = '$
*/

$_SESSION['serial'] = $serial;
$id = $highestID;
$name = $_POST['name'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$age = $_POST['age'];
//$type = $_POST['type'];
$serial = $_POST['serial'];

$stmt->execute();
$stmt->close();

redirect('ownerHome.php');

mysqli_close($conn);
?>
