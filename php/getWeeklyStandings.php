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

	$league_id = validate_input($_POST['league_id']);
	$week_id = validate_input($_POST['week_id']);

	$query = "SELECT l.user_id, u.name, SUM(s.winner_pts) as winner_pts, SUM(s.outcome_pts) as outcome_pts, SUM(s.total_pts) as total_pts FROM user_leagues l LEFT JOIN users u ON (l.user_id = u.user_id) LEFT JOIN selections s ON (l.user_id = s.user_id) LEFT JOIN fixtures f ON (s.fixture_id = f.fixture_id) WHERE l.league_id = '".$league_id."' AND f.week = '".$week_id."' GROUP By l.user_id ORDER BY total_pts DESC, winner_pts DESC, outcome_pts DESC";

	$result = $conn->query($query);
	
	if (!$result) {

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "query failed";	
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output); 

		exit;

	}
   
   	$data = [];

	while ($row = mysqli_fetch_assoc($result)) {

		array_push($data, $row);

	}

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	$output['data'] = $data;
	
	mysqli_close($conn);

	echo json_encode($output); 

?>