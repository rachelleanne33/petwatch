<?php
	session_start();
	require 'log.php';

	if(!isset($_COOKIE["owner"])){
		logToFile('Cookie not set');
		redirect('ownerLogin.html');
	}
?>

<html lang = "en">
	<head>
		<title>Pet History</title>
		<meta charset = "utf-8"/>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  		<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>

<script>
$(document).ready(function(){
	var len = 0;
	if(len >= 1) {
    		$('.noPets').hide();
	}else{
		$('.noPets').show();
	}


});
</script>
	</head>

<body>
	<header class = "container">
		<nav class="col-sm-4 col-sm-offset-8 text-right">
   	    		<a class="btn btn-nav" href="home.html" role="button"><b>HOME</b></a>
			<a class="btn btn-nav" href="about.html" role="button"><b>ABOUT</b></a>
       			<a class="btn btn-nav" href="contact.html" role="button"><b>CONTACT</b></a>
		</nav>

		<div class = "row">
			<h1 class = "col-sm-16">PetWatch</h1>
			<nav class="col-sm-4 text-left">
   	    			<a class="btn btn-nav" href="petRegister.html" role="button"><b>Add Pet</b></a>
				<a class="btn btn-nav" href="petHistory.php" role="button"><b>Pet History</b></a>
<!--      				<a class="btn btn-nav" href="contact.html" role="button"><b>CONTACT</b></a>
-->			</nav>
		</div>
	</header>
	<div class = "petData">
		<section class = "jumbotron">
			<div class = "container text-center">
				<h2>Pet History</h3>
				<div class = "row text-center tranbox">
					<p class = "noPets">You don't have any pets yet. Add a pet!</p>	
					<a class = "noPets btn btn-primary" href="petRegister.html" role = "button" >Add Pet</a>
<?php

require 'db_config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if(!$conn){
	logToFile("connection test failed");
	die('Could not connect: ' . mysql_error());
}

//display results
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

mysqli_close($conn);

?>
				</div>
			</div>
		</section>
		</div>
	</body>

<style>
table{
	border-collapse: separate;
	border-spacing: 5px;
}
</style>

</html>
