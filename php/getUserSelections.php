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

	$user_id = validate_input($_POST['user_id']);
	$season_id = validate_input($_POST['season']); 
	$week_id = validate_input($_POST['week']);

	$query = "SELECT s.fixture_id, v.name as stadium, f.ko, f.home_id, t1.team as home_team, t1.abbreviation as home_abv, f.home_score, t1.logo as home_logo, f.away_id, t2.team as away_team, t2.abbreviation as away_abv, f.away_score, t2.logo as away_logo, f.status, t3.team as selected_winner, s.selected_outcome_id, o.name as selected_outcome, s.winner_pts, s.outcome_pts, s.total_pts FROM selections s LEFT JOIN fixtures f ON (s.fixture_id = f.fixture_id) LEFT JOIN stadiums v ON (f.stadium_id = v.stadium_id) LEFT JOIN teams t1 ON (f.home_id = t1.team_id) LEFT JOIN teams t2 ON (f.away_id = t2.team_id) LEFT JOIN teams t3 ON (s.selected_winner_id = t3.team_id) LEFT JOIN outcomes o ON (s.selected_outcome_id = o.outcome_id) WHERE s.user_id = '".$user_id."' AND f.season = '".$season_id."' AND f.week = '".$week_id."'  ORDER BY `ko` ASC, `fixture_id` ASC";


	$result = $conn->query($query);
	
	if (!$result) {

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "query failed";

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