<!DOCTYPE html>
<head>
	<title>Pet Info</title>
</head>

<body>
	<div class = "petData">
		
<?php

$db_host = "dbserver.engr.scu.edu";
$db_user = "janders2";
$db_pass = "00001106738";
$db_name = "sdb_janders2";
	
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if(!$conn){
	logToFile("connection test failed");
	die('Could not connect: ' . mysql_error());
}
	
//display results
$sql = "SELECT * FROM Ellie";
$result = $conn->query($sql);

if($result->num_rows > 0){
	echo "<table><tr><th>Log Time</th><th>Accelerometer</th><th>Temperature</th><th>Humidity</th><th>Tag ID</th><th>Tag Time</th></tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr><td>".$row["log_time"]."</td><td>".$row["accel"]."</td><td>".$row["temp"]."</td><td>".$row["humid"]."</td><td>".$row["tag_id"]."</td><td>".$row["tag_time"]."</td></tr>";
	}
	echo "</table>";
}

mysqli_close($conn);
?>
	</div>
</body>
