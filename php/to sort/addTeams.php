<?php


	$executionStartTime = microtime(true);

	include("config.php");
	include("validate.php");

	header('Content-Type: application/json; charset=UTF-8');

	$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

	if (mysqli_connect_errno()) {
		
		$output['status']['code'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "database unavailable";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output);

		exit;

	}
	foreach ($_POST['teams'] as $team){
		$name = $team['team'];
		$mascot = $team['mascot'];
		$location = $team['location'];
		$abr = $team['abbreviation'];
		$league = $team['league'];
		$conf = $team['conference'];
		$div = $team['division'];
		$image = strtolower($mascot).".png";

		$query = "INSERT INTO `teams` (`team`, `mascot`, `location`, `abbreviation`, `league`, `conference`, `division`, `image`) VALUES ('".$name."', '".$mascot."', '".$location."', '".$abr."', '".$league."', '".$conf."', '".$div."', '".$image."')";

		$result = $conn->query($query);

	}
	

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	
	mysqli_close($conn);

	echo json_encode($output); 


?>