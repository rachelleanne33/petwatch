<?php
	session_start();
	require 'log.php';

	if(!isset($_COOKIE['owner'])){
		logToFile('Cookie not set');
		redirect('ownerLogin.html');
	}
	if(!isset($_SESSION['login_user']))
		redirect('ownerLogin.html');

?>

<html lang = "en">
	<head>
		<title>Owner Home</title>
		<meta charset = "utf-8"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
<!--
<script>

$(document).ready(function(){
	if ($('#pet').children().length == 0){
		$('.noPets').hide();
	}
	else{
		$('.noPets').hide();
	}
});

</script>
-->

</head>

<body>
	<header class = "container">
		<nav class="col-sm-4 col-sm-offset-8 text-right">
   	    		<a class="btn btn-nav" href="index.html" role="button"><b>HOME</b></a>
			<a class="btn btn-nav" href="about.html" role="button"><b>ABOUT</b></a>
       			<a class="btn btn-nav" href="contact.html" role="button"><b>CONTACT</b></a>
		</nav>

		<div class = "row">
			<h1 class = "col-sm-16">PetWatch</h1>
			<nav class="col-sm-4 text-left">
   	    			<a class="btn btn-nav" href="petRegister.html" role="button"><b>Pet Profiles</b></a>
				<a class="btn btn-nav" href="petHistory.php" role="button"><b>Pet History</b></a>
				<a class="btn btn-nav" href="contact.html" role="button"><b>My Account</b></a>
			</nav>
		</div>
	</header>
	<div class = "petData">
		<section class = "jumbotron">
			<div class = "container text-center">
				<h2>Daily Activity</h3>
				<div class = "row text-center tranbox">
				<!--	<p class = "noPets">You don't have any pets yet. Add a pet!</p>	
					<a class = "noPets btn btn-primary" href="petRegister.html" role = "button" >Add Pet</a>
				-->
<?php

require 'db_config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if(!$conn){
	logToFile("connection test failed");
	die('Could not connect: ' . mysql_error());
}

/*
$user = $_SESSION['login_user'];
$sql = "SELECT * FROM Pets WHERE user_id = '$user'";

$result = $conn->query($sql);

if($result->num_rows > 0){
	echo "<table align = 'center' cellpadding = '10'  id = 'pet'><tr><th>Pet Name </th><th>Age </th><th>Weight </th><th>Height </th></tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr><td>".$row["name"]."</td><td>".$row["age"]."</td><td>".$row["weight"]."</td><td>".$row["height"]."</td><td>".$row["type"]."</td></tr>";
	}
	echo "</table>";
}
*/
$display = false;
$user = $_SESSION['login_user'];
$sql = "SELECT * FROM Pets WHERE user_id = '$user'";

$result = $conn->query($sql);
if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		$petName = $row["name"];
		$weight = $row["weight"];
		$age = $row["age"];
		$display = true;
	}
}

//Display each pet's data

$sql = "SELECT * FROM accelData";
$result = $conn->query($sql);

if($result->num_rows > 0){
	$steps = 0;
	while($row= $result->fetch_assoc()){
		if(date('y-m-d') == date('y-m-d', $row["time"]))
			break;
	}

	$steps = $steps + $row["accel"];
	while($row = $result->fetch_assoc()){
		$steps += $row["accel"];
	}
}

$sql2 = "SELECT * FROM tempData";
$result2 = $conn->query($sql2);

if($result2->num_rows > 0){
	$temp = 0;
	$count = 1; 
	while($row2= $result2->fetch_assoc()){
		if(date('y-m-d') == date('y-m-d', $row2["time"]))
			break;
	}
	$temp +=  $row2["temp"];
	while($row2 = $result2->fetch_assoc()){
		$temp += $row["temp"];
		$count++;
	}
	$temp /= $count;

}

if($display == true){

	echo "<div id = 'box' class = 'container col-md-4' > 
			<h3 id = 'pet'>".$petName."</h3>
			<p id = 'pet'>Age ".$age."</p>
			<p id = 'pet'>Weighs ".$weight." lbs</p></div>
	      <div id = 'box' class = 'container col-md-7 col-md-offset-1'>
			<h3 id = 'pet'>".$petName."'s Activities Today</h3>
			<div class = 'info'><p align='left'>Steps taken: ".$steps."</p></div>
			<div id = 'last' class = 'info'><p align='left'>Average body temperature: ".$temp."</p></div></div>";
}

mysqli_close($conn);

?>
				<a class = "noPets btn btn-lg btn-primary" href="petRegister.html" role = "button" >Add Pet</a>
				
				</div>
			</div>
		</section>
		</div>
	</body>


<style>
#box{
	background:white;	
	margin-top: 30px;
	border-radius: 5px;
}
.info{
	margin: 10px;
	margin-left: 20px;
	margin-right: 20px;
	padding: 4px;
	background:#cee3ff;
	border-radius: 5px;
}
#last{
	margin-bottom: 20px;
}
p{
	margin: 4px;
}
h3{
	margin: 20px;
}
.noPets{
	margin: 30px;
}
#box{
	
}
</style>

</html>

